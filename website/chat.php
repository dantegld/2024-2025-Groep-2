<div id="chatBubble" class="chat-bubble" onclick="toggleChatWindow()">
    <i class="fa fa-comments" aria-hidden="true"></i>
</div>
<div id="chatWindow" class="chat-window" style="display: none;">
    <div class="chat-header">
        <span>Chat with us</span>
        <button onclick="toggleChatWindow()">X</button>
    </div>
    <div class="chat-body">
        <div id="messages"></div>
    </div>
    <div class="chat-footer">
        <input type="text" id="messageInput" placeholder="Type your message...">
        <button id="sendButton">Send</button>
    </div>
</div>

<script>
    function toggleChatWindow() {
        var chatWindow = document.getElementById("chatWindow");
        if (chatWindow.style.display === "none" || chatWindow.style.display === "") {
            chatWindow.style.display = "block";
        } else {
            chatWindow.style.display = "none";
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        let ws;
        const guestName = <?php
            include 'connect.php';
            $klantid = 4;
            $sqluser = "SELECT klantnaam FROM tblklant WHERE klant_id = ?";
            $stmt = $mysqli->prepare($sqluser);
            $stmt->bind_param('i', $klantid);
            $stmt->execute();
            $stmt->bind_result($klantnaam);
            $stmt->fetch();
            echo json_encode($klantnaam);
            $stmt->close();
        ?>;
        console.log('Guest name:', guestName);
        const messagesDiv = document.getElementById('messages');
        const messageInput = document.getElementById('messageInput');
        const sendButton = document.getElementById('sendButton');

        function connectWebSocket() {
            ws = new WebSocket('ws://127.0.0.1:8080/');
            ws.onopen = function() {
                console.log('WebSocket connection opened');
                ws.send(JSON.stringify({ type: 'login', name: guestName }));
            };
            ws.onerror = function(error) {
                console.error('WebSocket error:', error);
            };
            ws.onclose = function() {
                console.log('WebSocket connection closed');
            };
            ws.onmessage = function(event) {
                const data = JSON.parse(event.data);
                console.log('Message received:', data);
                if (data.type === 'storedMessages') {
                    data.messages.forEach(msg => {
                        if ((msg.from === 'admin' && msg.to === guestName) ||
                            (msg.from === guestName && msg.to === 'admin')) {
                            const message = document.createElement('div');
                            message.textContent = (msg.from === guestName ? 'You' : msg.from) + ": " + msg.message;
                            messagesDiv.appendChild(message);
                        }
                    });
                    messagesDiv.scrollTop = messagesDiv.scrollHeight;
                } else if (data.type === 'message') {
                    if ((data.from === 'admin' && data.to === guestName) ||
                        (data.from === guestName && data.to === 'admin')) {
                        const message = document.createElement('div');
                        message.textContent = (data.from === guestName ? 'You' : data.from) + ": " + data.message;
                        messagesDiv.appendChild(message);
                        messagesDiv.scrollTop = messagesDiv.scrollHeight;
                    }
                }
            };
        }

        connectWebSocket();

        sendButton.addEventListener('click', function() {
            if (ws.readyState === WebSocket.OPEN) {
                const message = messageInput.value;
                console.log('Sending message:', message);
                ws.send(JSON.stringify({ type: 'message', to: 'admin', message: message }));
                messageInput.value = '';
            } else {
                console.error('WebSocket is not open');
            }
        });

        window.onbeforeunload = function() {
            if (ws.readyState === WebSocket.OPEN) {
                ws.close();
            }
        };

        window.addEventListener('focus', function() {
            if (ws.readyState === WebSocket.CLOSED) {
                connectWebSocket();
            }
        });
    });
</script>