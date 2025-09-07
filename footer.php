  </main>
  <footer class="footer">
    <p>© <?php echo date('Y'); ?> Community Helper. It is developed by Md Rizwan Ansari</p>
  </footer>

  <!-- Chatbot widget -->
  <div class="chatbot">
    <button class="chat-toggle" id="chatToggle">🤖</button>
    <div class="chat-window" id="chatWindow" aria-live="polite">
      <div class="chat-header">Helper Bot</div>
      <div class="chat-messages" id="chatMessages"></div>
      <div class="chat-input">
        <input type="text" id="chatInput" placeholder="Ask something..." aria-label="Chat input" />
        <button id="chatSend">Send</button>
      </div>
    </div>
  </div>
</body>
</html>
