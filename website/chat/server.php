<?php
set_time_limit(0);
$host = '127.0.0.1';
$port = 8080;

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket === false) {
    die("socket_create() failed: " . socket_strerror(socket_last_error()));
}
if (socket_bind($socket, $host, $port) === false) {
    die("socket_bind() failed: " . socket_strerror(socket_last_error($socket)));
}
if (socket_listen($socket, 5) === false) {
    die("socket_listen() failed: " . socket_strerror(socket_last_error($socket)));
}

$clients = [];
$guestNames = [];
$messages = [];
$messagesFile = 'messages.json';

if (file_exists($messagesFile)) {
    $messages = json_decode(file_get_contents($messagesFile), true);
    if ($messages === null) {
        $messages = [];
    }
} else {
    $messages = [];
}

function saveMessages($messages, $file) {
    file_put_contents($file, json_encode($messages));
}

function handShake($clientSocket, $clientHeader) {
    preg_match("/Sec-WebSocket-Key: (.*)\r\n/", $clientHeader, $matches);
    $key = trim($matches[1]);
    $acceptKey = base64_encode(pack('H*', sha1($key . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
    $headers = [
        'HTTP/1.1 101 Switching Protocols',
        'Upgrade: websocket',
        'Connection: Upgrade',
        'Sec-WebSocket-Accept: ' . $acceptKey,
        "\r\n"
    ];
    socket_write($clientSocket, implode("\r\n", $headers));
}

function unmask($data) {
    $length = ord($data[1]) & 127;
    if ($length == 126) {
        $masks = substr($data, 4, 4);
        $message = substr($data, 8);
    } elseif ($length == 127) {
        $masks = substr($data, 10, 4);
        $message = substr($data, 14);
    } else {
        $masks = substr($data, 2, 4);
        $message = substr($data, 6);
    }
    $decoded = "";
    for ($i = 0; $i < strlen($message); ++$i) {
        $decoded .= $message[$i] ^ $masks[$i % 4];
    }
    return $decoded;
}

function mask($text) {
    $b1 = 0x81;
    $length = strlen($text);
    if ($length <= 125) {
        return pack('CC', $b1, $length) . $text;
    } elseif ($length <= 65535) {
        return pack('CCn', $b1, 126, $length) . $text;
    } else {
        return pack('CCNN', $b1, 127, 0, $length) . $text;
    }
}

while (true) {
    $read = array_merge([$socket], $clients);
    socket_select($read, $null, $null, 0);

    if (in_array($socket, $read)) {
        $clientSocket = socket_accept($socket);
        if ($clientSocket === false) {
            continue;
        }
        $clients[] = $clientSocket;
        $header = socket_read($clientSocket, 1024);
        handShake($clientSocket, $header);
        socket_getpeername($clientSocket, $ip);
        $read = array_filter($read, function($sock) use ($socket) {
            return $sock !== $socket;
        });
    }

    foreach ($read as $clientSocket) {
        $data = @socket_read($clientSocket, 1024);
        if ($data === false || $data === "") {
            $index = array_search($clientSocket, $clients);
            if ($index !== false) {
                unset($clients[$index], $guestNames[$index]);
            }
            socket_close($clientSocket);
            continue;
        }

        $decoded = unmask($data);
        $dataArr = json_decode($decoded, true);
        if ($dataArr === null) {
            continue;
        }

        if ($dataArr['type'] === 'login') {
            $index = array_search($clientSocket, $clients);
            if ($index !== false) {
                $guestNames[$index] = $dataArr['name'];
                if ($dataArr['name'] === 'admin') {
                    $chatType = isset($dataArr['chat']) ? $dataArr['chat'] : 'support';
                    if ($chatType === 'group') {
                        $groupMessages = array_filter($messages, function($m) {
                            return $m['to'] === 'adminchat';
                        });
                        socket_write($clientSocket, mask(json_encode([
                            'type' => 'storedMessages',
                            'messages' => array_values($groupMessages)
                        ])));
                    } else {
                        $guests = array_values(array_filter($guestNames, function($n) {
                            return $n !== 'admin';
                        }));
                        socket_write($clientSocket, mask(json_encode([
                            'type' => 'guestList',
                            'guests' => $guests
                        ])));
                        $directMessages = array_filter($messages, function($m) {
                            return $m['to'] !== 'adminchat';
                        });
                        socket_write($clientSocket, mask(json_encode([
                            'type' => 'storedMessages',
                            'messages' => array_values($directMessages)
                        ])));
                    }
                } else {
                    $directMessages = array_filter($messages, function($m) use ($dataArr) {
                        return ($m['from'] === 'admin' && $m['to'] === $dataArr['name']) ||
                               ($m['from'] === $dataArr['name'] && $m['to'] === 'admin');
                    });
                    socket_write($clientSocket, mask(json_encode([
                        'type' => 'storedMessages',
                        'messages' => array_values($directMessages)
                    ])));
                    $guests = array_values(array_filter($guestNames, function($n) {
                        return $n !== 'admin';
                    }));
                    foreach ($clients as $client) {
                        $clientIndex = array_search($client, $clients);
                        if (isset($guestNames[$clientIndex]) && $guestNames[$clientIndex] === 'admin') {
                            socket_write($client, mask(json_encode([
                                'type' => 'guestList',
                                'guests' => $guests
                            ])));
                        }
                    }
                }
            }
        } elseif ($dataArr['type'] === 'message') {
            $index = array_search($clientSocket, $clients);
            if ($index !== false && isset($guestNames[$index])) {
                $newMessage = [
                    'from' => $guestNames[$index],
                    'to' => $dataArr['to'],
                    'message' => $dataArr['message']
                ];
                $messages[] = $newMessage;
                saveMessages($messages, $messagesFile);
                foreach ($clients as $client) {
                    socket_write($client, mask(json_encode([
                        'type' => 'message',
                        'from' => $guestNames[$index],
                        'to' => $dataArr['to'],
                        'message' => $dataArr['message']
                    ])));
                }
            }
        }
    }
}

socket_close($socket);
?>
