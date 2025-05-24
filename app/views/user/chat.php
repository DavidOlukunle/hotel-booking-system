<?php

require_once __DIR__ . "/../../../app/controllers/ChatController.php";
use app\controllers\ChatController;

$chat = new ChatController();

// Handle chat POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $chat->getReply();
    exit;
}

// if (!$message) {
//     echo json_encode(['error' => 'No message provided']);
//     exit;
// }

?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
 </head>
 <body>
  <style>
    body {
        font-family: Arial;
        background: #f4f4f4;
        padding: 30px;
    }
    .chat-container {
        background: white;
        padding: 20px;
        border-radius: 10px;
        width: 500px;
        margin: auto;
        box-shadow: 0 0 10px rgba(0,0,0,0.2);
    }
    .chat-box {
        border: 1px solid #ccc;
        height: 300px;
        overflow-y: scroll;
        padding: 10px;
        margin-bottom: 10px;
    }
    #chat-form input {
        width: 75%;
        padding: 10px;
    }
    #chat-form button {
        padding: 10px;
    }
  </style>
</head>
<body>
  <div class="chat-container">
    <div class="chat-box" id="chat-box"></div>

    <form id="chat-form" method="POST">
      <input type="text" name="message" id="chat-input" placeholder="Say something..." required />
      <button type="submit">Send</button>
    </form>
  </div>

  <script>
    const form = document.getElementById('chat-form');
    const input = document.getElementById('chat-input');
    const chatBox = document.getElementById('chat-box');

    form.addEventListener('submit', async function(e) {
      e.preventDefault();
      const message = input.value.trim();
      if (!message) return;

      appendMessage('You', message);
      input.value = '';

      const formData = new FormData();
      formData.append('message', message);

      try {
        const res = await fetch('', {
          method: 'POST',
          body: formData
        });

        const data = await res.json();
        const reply = data.response || 'Error';
        appendMessage('Bot', reply);
      } catch (err) {
        appendMessage('Bot', 'Something went wrong.');
      }
    });

    function appendMessage(sender, message) {
      const p = document.createElement('p');
      p.innerHTML = `<strong>${sender}:</strong> ${message}`;
      chatBox.appendChild(p);
      chatBox.scrollTop = chatBox.scrollHeight;
    }
  </script>
</body>
</html>
 