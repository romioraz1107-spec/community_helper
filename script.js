
document.getElementById('navToggle')?.addEventListener('click', ()=>{
  document.getElementById('navLinks')?.classList.toggle('show');
});

// Geolocation helper
document.getElementById('geoBtn')?.addEventListener('click', ()=>{
  if (!navigator.geolocation) return alert('Geolocation not supported');
  navigator.geolocation.getCurrentPosition((pos)=>{
    document.getElementById('lat').value = pos.coords.latitude.toFixed(6);
    document.getElementById('lng').value = pos.coords.longitude.toFixed(6);
  }, (err)=>{
    alert('Could not get location: ' + err.message);
  });
});

// Simple rule-based chatbot
const chatToggle = document.getElementById('chatToggle');
const chatWindow = document.getElementById('chatWindow');
const chatMessages = document.getElementById('chatMessages');
const chatInput = document.getElementById('chatInput');
const chatSend = document.getElementById('chatSend');

function addMsg(text, who='bot'){
  const div = document.createElement('div');
  div.className = 'msg ' + who;
  div.textContent = text;
  chatMessages.appendChild(div);
  chatMessages.scrollTop = chatMessages.scrollHeight;
}

if (chatToggle){
  chatToggle.addEventListener('click', ()=>{
    chatWindow.classList.toggle('show');
    if (chatWindow.classList.contains('show') && !chatMessages.dataset.greeted){
      addMsg('Hi! I am Helper Bot. Ask me how to post a request or how helpers reply.');
      chatMessages.dataset.greeted = '1';
    }
  });
}

function botReply(q){
  const s = q.toLowerCase();
  if (s.includes('post') || s.includes('request')) return 'Click "Post Request" in the top menu, fill details and submit.';
  if (s.includes('helper') || s.includes('respond')) return 'Helpers visit the Helper Desk and respond with contact info & image.';
  if (s.includes('location')) return 'Use "Use my current location" to auto-fill latitude & longitude.';
  if (s.includes('forgot')) return 'Use "Forgot password" on the login page to generate a reset link.';
  return "I'm a simple demo bot. Try asking about posting a request, helper responses, or location.";
}

chatSend?.addEventListener('click', ()=>{
  const txt = (chatInput.value || '').trim();
  if (!txt) return;
  addMsg(txt, 'user');
  chatInput.value='';
  setTimeout(()=> addMsg(botReply(txt), 'bot'), 300);
});
chatInput?.addEventListener('keydown', (e)=>{
  if (e.key==='Enter') chatSend.click();
});
