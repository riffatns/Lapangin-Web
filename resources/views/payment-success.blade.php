<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pembayaran Berhasil - Lapangin</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
      color: white;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
    }

    .success-container {
      background: rgba(28, 28, 30, 0.9);
      border-radius: 20px;
      padding: 3rem;
      text-align: center;
      max-width: 500px;
      width: 100%;
      border: 1px solid #374151;
      animation: slideIn 0.5s ease-out;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .success-icon {
      font-size: 4rem;
      margin-bottom: 1rem;
      animation: bounce 1s ease-in-out;
    }

    @keyframes bounce {
      0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
      }
      40% {
        transform: translateY(-10px);
      }
      60% {
        transform: translateY(-5px);
      }
    }

    .success-title {
      font-size: 2rem;
      font-weight: 800;
      color: #22c55e;
      margin-bottom: 1rem;
    }

    .success-message {
      color: #9ca3af;
      margin-bottom: 2rem;
      line-height: 1.6;
    }

    .btn-primary {
      background: linear-gradient(135deg, #f59e0b, #d97706);
      color: white;
      padding: 1rem 2rem;
      border: none;
      border-radius: 12px;
      font-weight: 700;
      font-size: 1.1rem;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      margin: 0.5rem;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 30px rgba(245, 158, 11, 0.4);
    }

    .btn-secondary {
      background: rgba(255, 255, 255, 0.1);
      color: white;
      padding: 1rem 2rem;
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 12px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      margin: 0.5rem;
    }

    .btn-secondary:hover {
      background: rgba(255, 255, 255, 0.2);
      transform: translateY(-2px);
    }

    .countdown {
      margin-top: 2rem;
      color: #9ca3af;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>
  <div class="success-container">
    <div class="success-icon">✅</div>
    <h1 class="success-title">Pembayaran Berhasil!</h1>
    <p class="success-message">
      Terima kasih! Booking Anda telah dikonfirmasi dan pembayaran berhasil diproses.
      Anda akan menerima email konfirmasi dalam beberapa menit.
    </p>
    
    <div>
      <a href="{{ route('pesanan') }}" class="btn-primary">
        📋 Lihat Pesanan
      </a>
      <a href="{{ route('dashboard') }}" class="btn-secondary">
        🏠 Kembali ke Dashboard
      </a>
    </div>

    <div class="countdown">
      Akan diarahkan ke halaman pesanan dalam <span id="countdown">5</span> detik
    </div>
  </div>

  <script>
    let timeLeft = 5;
    const countdownElement = document.getElementById('countdown');
    
    const timer = setInterval(() => {
      timeLeft--;
      countdownElement.textContent = timeLeft;
      
      if (timeLeft <= 0) {
        clearInterval(timer);
        window.location.href = '{{ route("pesanan") }}';
      }
    }, 1000);
  </script>
</body>
</html>
