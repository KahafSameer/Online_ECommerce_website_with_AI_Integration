document.addEventListener("DOMContentLoaded", () => {
  const input = document.getElementById("user-input");
  const sendBtn = document.getElementById("send-btn");

  input.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
      e.preventDefault();
      sendMessage();
    }
  });

  sendBtn.addEventListener("click", sendMessage);
});

// Modern eCommerce Chatbot UI logic
function sendMessage() {
  const userInputElem = document.getElementById("user-input");
  const userInput = userInputElem.value.trim();
  const chatBox = document.getElementById("chat-box");

  if (userInput === "") return;

  // User Message
  const userMessage = document.createElement("div");
  userMessage.className = "user-message bubble mb-2";
  userMessage.innerHTML = `<i class="fas fa-user-circle text-primary me-2"></i>${escapeHtml(userInput)}`;
  chatBox.appendChild(userMessage);

  // Loading placeholder
  const loadingMessage = document.createElement("div");
  loadingMessage.className = "bot-message bubble mb-2";
  loadingMessage.innerHTML = '<span class="text-muted"><i class="fas fa-spinner fa-spin"></i> Thinking...</span>';
  chatBox.appendChild(loadingMessage);
  chatBox.scrollTop = chatBox.scrollHeight;

  // Send to chatbot.php
  fetch("chatbot.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ message: userInput })
  })
    .then((response) => response.json())
    .then((data) => {
      chatBox.removeChild(loadingMessage);

      const botMessage = document.createElement("div");
      botMessage.className = "bot-message bubble mb-2 position-relative";
      const responseText = data.response
        ? data.response
        : data.error || "No response.";

      // Markdown to HTML (simple)
      const formatted = formatMarkdown(responseText);
      botMessage.innerHTML = `<i class="fas fa-robot text-warning me-2"></i>${formatted}`;

      // Add Copy Button
      const copyBtn = document.createElement("button");
      copyBtn.className = "copy-btn btn btn-sm btn-outline-warning position-absolute top-0 end-0 m-2";
      copyBtn.textContent = "Copy";
      copyBtn.style.display = "none";

      copyBtn.onclick = () => {
        navigator.clipboard.writeText(stripHtml(responseText));
        copyBtn.innerHTML = "&#10003;";
        copyBtn.classList.add("copied-animate");
        setTimeout(() => {
          copyBtn.textContent = "Copy";
          copyBtn.classList.remove("copied-animate");
        }, 1000);
      };

      botMessage.addEventListener("mouseenter", () => {
        copyBtn.style.display = "inline-block";
      });
      botMessage.addEventListener("mouseleave", () => {
        copyBtn.style.display = "none";
      });

      botMessage.appendChild(copyBtn);
      chatBox.appendChild(botMessage);

      userInputElem.value = "";
      chatBox.scrollTop = chatBox.scrollHeight;
    })
    .catch(() => {
      chatBox.removeChild(loadingMessage);

      const errorMessage = document.createElement("div");
      errorMessage.className = "bot-message bubble mb-2";
      errorMessage.innerHTML = '<span class="text-danger"><i class="fas fa-exclamation-circle me-2"></i>Bot: Failed to fetch response.</span>';
      chatBox.appendChild(errorMessage);
    });
}

// Convert simple markdown (**bold**, *italic*, lists) to HTML
function formatMarkdown(text) {
  let html = escapeHtml(text);

  // Bold: **text**
  html = html.replace(/\*\*(.*?)\*\*/g, "<strong>$1</strong>");

  // Italic: *text*
  html = html.replace(/\*(.*?)\*/g, "<em>$1</em>");

  // Lists
  if (html.match(/(^|\n)\s*[-*]\s+/)) {
    html = html.replace(/(^|\n)\s*[-*]\s+(.*?)(?=\n|$)/g, "$1<ul><li>$2</li></ul>");
    html = html.replace(/<\/ul>\s*<ul>/g, "");
  }

  return html.replace(/\n/g, "<br>");
}

// Escape HTML
function escapeHtml(text) {
  return text
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;");
}

// Remove HTML tags for copy
function stripHtml(html) {
  let tmp = document.createElement("div");
  tmp.innerHTML = html;
  return tmp.textContent || tmp.innerText || "";
}
