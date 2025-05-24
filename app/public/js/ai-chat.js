document.addEventListener('DOMContentLoaded', () => {
  const chatForm = document.getElementById('chat-form');
  const chatBox = document.getElementById('chat-box');
  const input = document.getElementById('chat-input');

  chatForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const userMessage = input.value.trim();
    if (!userMessage) return;

    // Append user message
    chatBox.innerHTML += `<div class="text-right text-blue-700">${userMessage}</div>`;
    input.value = '';

    // Send message to server
    const response = await fetch('/ai-chat/message', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `message=${encodeURIComponent(userMessage)}`
    });

    const data = await response.json();
    chatBox.innerHTML += `<div class="text-left text-gray-800">${data.response}</div>`;
    chatBox.scrollTop = chatBox.scrollHeight;
  });
});
