<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Customer Support</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <!-- font awesome -->
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--  -->
    <!-- owl stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Great+Vibes|Poppins:400,700&display=swap&subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesoeet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <link rel="icon" href="images/icon/favicon.png">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f9f9f9;
        }
        #chat {
            display: flex;
            width: 80%;
            height: 80%;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        #guestList {
            width: 30%;
            background-color: #007BFF;
            color: white;
            overflow-y: auto;
        }
        #guestList div {
            padding: 15px;
            cursor: pointer;
        }
        #guestList div:hover, #guestList .selected {
            background-color: #0056b3;
        }
        #messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #f1f1f1;
        }
        #chatBar {
            display: flex;
            padding: 10px;
            background-color: #fff;
            border-top: 1px solid #ddd;
        }
        #messageInput {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-right: 10px;
        }
        #sendButton {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        #sendButton:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
<?php
include 'connect.php';
session_start();
include 'functies/functies.php';
controleerAdmin();
include 'functies/adminSideMenu.php';
?>
<div class="adminpageCenter">
  <div id="chat">
    <div id="guestList">
      <h2 style="width:fit-content;margin:auto;padding:5px">Customer Support</h2>
    </div>
    <div style="flex: 1; display: flex; flex-direction: column;">
      <div id="messages"></div>
      <div id="chatBar" style="display:none;">
        <input type="text" id="messageInput" placeholder="Type a message...">
        <button id="sendButton">Send</button>
      </div>
    </div>
  </div>
  <script>
    let ws;
    let currentChat = null;
    const guestListDiv = document.getElementById('guestList');
    const messagesDiv = document.getElementById('messages');
    const messageInput = document.getElementById('messageInput');
    const sendButton = document.getElementById('sendButton');
    const chatBar = document.getElementById('chatBar');
    const chatHistory = {};

    function getChatKey(from, to) {
      return from === 'admin' ? to : from;
    }

    ws = new WebSocket('ws://127.0.0.1:8080/');
    ws.onopen = function() {
      console.log('WebSocket connection opened for admin support');
      ws.send(JSON.stringify({ type: 'login', name: 'admin', chat: 'support' })); // Specify support chat
    };
    ws.onerror = function(error) {
      console.error('WebSocket error:', error);
    };
    ws.onclose = function() {
      console.log('WebSocket connection closed');
    };
    ws.onmessage = function(event) {
      const data = JSON.parse(event.data);
      if (data.type === 'guestList') {
        data.guests.forEach(guest => {
          if (!document.getElementById(guest)) {
            const guestDiv = document.createElement('div');
            guestDiv.id = guest;
            guestDiv.textContent = guest;
            guestDiv.onclick = function() {
              if (currentChat) {
                document.getElementById(currentChat).classList.remove('selected');
              }
              currentChat = guest;
              guestDiv.classList.add('selected');
              messagesDiv.innerHTML = '';
              chatBar.style.display = 'block';
              if (chatHistory[currentChat]) {
                chatHistory[currentChat].forEach(msg => {
                  const message = document.createElement('div');
                  message.textContent = `${msg.from}: ${msg.message}`;
                  messagesDiv.appendChild(message);
                });
              }
            };
            guestListDiv.appendChild(guestDiv);
          }
        });
      } else if (data.type === 'storedMessages') {
        data.messages.forEach(msg => {
          if (msg.to !== 'adminchat') {
            const key = getChatKey(msg.from, msg.to);
            if (!chatHistory[key]) {
              chatHistory[key] = [];
            }
            chatHistory[key].push(msg);
          }
        });
        if (currentChat && chatHistory[currentChat]) {
          messagesDiv.innerHTML = '';
          chatHistory[currentChat].forEach(msg => {
            const message = document.createElement('div');
            message.textContent = `${msg.from}: ${msg.message}`;
            messagesDiv.appendChild(message);
          });
        }
      } else if (data.type === 'message') {
        if(data.to === 'adminchat') return;
        const key = getChatKey(data.from, data.to);
        if (!chatHistory[key]) {
          chatHistory[key] = [];
        }
        chatHistory[key].push(data);
        if (currentChat === key) {
          const message = document.createElement('div');
          message.textContent = `${data.from}: ${data.message}`;
          messagesDiv.appendChild(message);
          messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }
        if (!document.getElementById(key) && key !== 'admin') {
          const guestDiv = document.createElement('div');
          guestDiv.id = key;
          guestDiv.textContent = key;
          guestDiv.onclick = function() {
            if (currentChat) {
              document.getElementById(currentChat).classList.remove('selected');
            }
            currentChat = key;
            guestDiv.classList.add('selected');
            messagesDiv.innerHTML = '';
            chatBar.style.display = 'block';
            if (chatHistory[currentChat]) {
              chatHistory[currentChat].forEach(msg => {
                const message = document.createElement('div');
                message.textContent = `${msg.from}: ${msg.message}`;
                messagesDiv.appendChild(message);
              });
            }
          };
          guestListDiv.appendChild(guestDiv);
        }
      }
    };

    sendButton.onclick = function() {
      if (ws.readyState === WebSocket.OPEN && currentChat) {
        const message = messageInput.value;
        ws.send(JSON.stringify({ type: 'message', to: currentChat, message: message }));
        messageInput.value = '';
      } else {
        console.error('WebSocket is not open or no chat selected');
      }
    };

    window.onbeforeunload = function() {
      if (ws.readyState === WebSocket.OPEN) {
        ws.close();
      }
    };

    window.addEventListener('focus', function() {
      if (ws.readyState === WebSocket.CLOSED) {
        ws = new WebSocket('ws://127.0.0.1:8080/');
      }
    });
  </script>
</div>s
</body>
</html>