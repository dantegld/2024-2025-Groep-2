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
    <!-- fevicon -->
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
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
<body>
  <style>
      #chat-box {
            border: 1px solid #ccc;
            height: 300px;
            overflow-y: auto;
            padding: 10px;
            background: #fff;
            text-align: left;
            border-radius: 5px;
        }
        input[type="text"] {
            width: 80%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px 15px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
  </style>

<?php
session_start();
include 'connect.php';
include 'functies/functies.php';
controleerAdmin();
include 'functies/adminSideMenu.php';

// Get the admin's username from your helper function:
$username = getUsername($_SESSION['klant_id'], $mysqli);
?>

<div class="adminpageCenter"> 
  <h1>Admin Group Chat</h1>
  <div id="chat-box" style="border:1px solid #000; height:300px; padding:5px; width:80%;"></div>
  <input type="text" id="message" placeholder="Type a message...">
  <button onclick="sendMessage()">Send</button>
  
  <script>
    let socket = new WebSocket("ws://127.0.0.1:8080/");
    console.log("Initializing WebSocket connection for group chat...");

    socket.onopen = function () {
      console.log("WebSocket connection opened for group chat");
      socket.send(JSON.stringify({
          type: "login",
          name: "<?php echo $username; ?>",
          chat: "group"  // Specify group chat
      }));
      console.log("<?php echo $username; ?> logged in as group admin");
    };

    socket.onerror = function(error) {
      console.error("WebSocket error:", error);
    };

    socket.onclose = function() {
      console.log("WebSocket closed");
    };

    socket.onmessage = function (event) {
      console.log("Message received:", event.data);
      let data = JSON.parse(event.data);
      let chatBox = document.getElementById("chat-box");

      if (data.type === "storedMessages") {
          data.messages.forEach(function(msg) {
              if (msg.to === "adminchat") {
                  let messageDiv = document.createElement("div");
                  messageDiv.innerHTML = `<strong>${msg.from}:</strong> ${msg.message}`;
                  chatBox.appendChild(messageDiv);
              }
          });
      } else if (data.type === "message") {
          if (data.to === "adminchat") {
              let messageDiv = document.createElement("div");
              messageDiv.innerHTML = `<strong>${data.from}:</strong> ${data.message}`;
              chatBox.appendChild(messageDiv);
              chatBox.scrollTop = chatBox.scrollHeight;
          }
      }
    };

    function sendMessage() {
      let messageInput = document.getElementById("message");
      let message = messageInput.value;
      console.log("Sending group message:", message);

      if (message.trim() !== "") {
          socket.send(JSON.stringify({
              type: "message",
              from: "<?php echo $username; ?>",
              to: "adminchat",
              message: message
          }));
          messageInput.value = "";
      }
    }
  </script>
</div>
</body>
</html>
