<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>MOMAL AI</title>
  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <!-- Main Project Stylesheet -->
  <link rel="stylesheet" href="../css/style.css">
  <!-- Chatbot Specific Stylesheet -->
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <!-- Navbar -->
  <header class="header">
    <section class="flex">
        <a href="../home.php" class="logo"><i class="fas fa-store"></i> MOMAL<span>.COM</span></a>
        <nav class="navbar">
           
        </nav>
        
    </section>
  </header>

  <section class="form-container">
    <form onsubmit="sendMessage(event)">
      <h3><i class="fas fa-robot"></i> MOMAL AI Assistant</h3>
      <div id="chatHistory" class="chat-history">
        <!-- Welcome Message will be injected by JS -->
      </div>
      <div class="chat-input-area">
          <input type="text" id="userInput" placeholder="Ask about products, orders, or services..." required maxlength="200" class="box"/>
          <button type="submit" class="btn"><i class="fas fa-paper-plane"></i></button>
      </div>
      <div class="chat-error" id="errorBox"></div>
    </form>
  </section>

  <script>
    const chatHistory = document.getElementById('chatHistory');
    const errorBox = document.getElementById('errorBox');
    const userInput = document.getElementById('userInput');

    function addMessage(sender, text) {
      const msgDiv = document.createElement('div');
      msgDiv.className = 'chat-message ' + sender;
      const bubble = document.createElement('div');
      bubble.className = 'bubble';
      bubble.innerHTML = text; // Use innerHTML to render thinking spinner
      msgDiv.appendChild(bubble);
      chatHistory.appendChild(msgDiv);
      chatHistory.scrollTop = chatHistory.scrollHeight;
    }

    // Initial welcome message
    addMessage('bot', "👋 Hello! I'm your AI assistant. How can I help you with your shopping today?");

    async function sendMessage(event) {
      event.preventDefault();
      const message = userInput.value.trim();
      if (!message) return;
      addMessage('user', message);
      userInput.value = '';
      errorBox.textContent = '';
      addMessage('bot', '<i class="fas fa-spinner fa-spin"></i>');
      try {
        const res = await fetch('chatbot.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ message })
        });
        const data = await res.json();
        // Remove loading message
        const lastBotMsg = chatHistory.querySelector('.chat-message.bot:last-child');
        if (lastBotMsg && lastBotMsg.querySelector('.fa-spinner')) {
          lastBotMsg.remove();
        }
        if (data.response) {
          addMessage('bot', data.response);
        } else if (data.error) {
          addMessage('bot', data.error);
        } else {
          addMessage('bot', 'Sorry, something went wrong. Try again.');
        }
      } catch (err) {
        // Remove loading message
        const lastBotMsg = chatHistory.querySelector('.chat-message.bot:last-child');
        if (lastBotMsg && lastBotMsg.querySelector('.fa-spinner')) {
          lastBotMsg.remove();
        }
        addMessage('bot', 'Network error. Please check your connection.');
      }
    }
  </script>

</body>
</html>
