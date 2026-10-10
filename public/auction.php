<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bet Auction (Mobile First)</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @keyframes rise {
      0% { transform: translateY(100%); opacity: 0; }
      100% { transform: translateY(-100%); opacity: 1; }
    }
    .coin {
      animation: rise 1s ease-out forwards;
    }
    @keyframes confetti {
      0% { transform: translateY(0) rotate(0deg); }
      100% { transform: translateY(100vh) rotate(720deg); }
    }
    .confetti {
      animation: confetti 3s linear forwards;
    }
  </style>
</head>
<body class="bg-gradient-to-br from-black to-gray-900 min-h-screen text-white p-4">
  <div class="max-w-md mx-auto space-y-6">

    <div class="relative">
      <img src="https://via.placeholder.com/400x250" alt="Auction Item" class="w-full rounded-2xl shadow-lg" />
      <div class="absolute top-2 right-2 bg-white text-black px-4 py-1 rounded-full text-xs font-bold">
        ⏱ <span id="circle-timer">03:00</span>
      </div>
    </div>

    <div class="bg-gray-800 p-4 rounded-xl space-y-2">
      <h2 class="text-xl font-bold">Custom Gaming Chair</h2>
      <p class="text-sm text-gray-300">Current Highest Bid: <span id="currentBid">₹1,500</span></p>
      <ul class="text-sm text-gray-400">
        <li>🔥 Vaibhav Raj — ₹1500</li>
        <li>🧊 Ritu Sharma — ₹1450</li>
        <li>⭐ Arjun Mehta — ₹1400</li>
      </ul>
    </div>

    <form onsubmit="placeBid(event)" class="space-y-3">
      <input id="bidInput" type="number" placeholder="Your Bid (₹)" class="w-full p-3 rounded-lg border border-gray-600 bg-gray-900 text-white placeholder-gray-500 focus:ring-2 focus:ring-indigo-400 outline-none" />
      <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-semibold transition-all">
        🚀 Place Bid
      </button>
    </form>

    <div id="coin-container" class="fixed bottom-10 left-1/2 transform -translate-x-1/2 z-50"></div>
    <div id="confetti-container" class="fixed inset-0 pointer-events-none z-50"></div>
  </div>

  <script>
    let bid = 1500;

    function placeBid(e) {
      e.preventDefault();
      const input = document.getElementById('bidInput');
      const newBid = parseInt(input.value);
      if (!newBid || newBid <= bid) return alert('Enter a valid higher bid');

      bid = newBid;
      document.getElementById('currentBid').textContent = `₹${bid}`;
      triggerCoin();
      triggerConfetti();
      input.value = '';
    }

    function triggerCoin() {
      const coin = document.createElement('div');
      coin.textContent = '🪙';
      coin.className = 'coin text-3xl absolute bottom-0';
      coin.style.left = Math.random() * 80 + '%';
      document.getElementById('coin-container').appendChild(coin);
      setTimeout(() => coin.remove(), 1000);
    }

    function triggerConfetti() {
      for (let i = 0; i < 10; i++) {
        const confetti = document.createElement('div');
        confetti.className = 'confetti w-2 h-2 bg-yellow-400 rounded-full absolute';
        confetti.style.left = Math.random() * 100 + '%';
        confetti.style.top = '0';
        document.getElementById('confetti-container').appendChild(confetti);
        setTimeout(() => confetti.remove(), 3000);
      }
    }

    // Simple countdown circle logic
    let timerSeconds = 180;
    function updateTimer() {
      const mins = String(Math.floor(timerSeconds / 60)).padStart(2, '0');
      const secs = String(timerSeconds % 60).padStart(2, '0');
      document.getElementById('circle-timer').textContent = `${mins}:${secs}`;
      if (timerSeconds > 0) timerSeconds--;
    }
    setInterval(updateTimer, 1000);
  </script>
</body>
</html>
