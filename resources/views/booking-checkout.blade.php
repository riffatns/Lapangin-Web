<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Checkout Booking - Lapangin</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    html {
      scroll-behavior: smooth;
    }
    
    body {
      font-family: 'Inter', sans-serif;
      background-color: #0f0f0f;
      color: white;
      line-height: 1.6;
      overflow-x: hidden;
    }
    
    /* Navigation */
    .navbar {
      background: rgba(28, 28, 30, 0.95);
      backdrop-filter: blur(20px);
      border-bottom: 1px solid #333;
      padding: 1rem 0;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
    }
    
    .nav-container {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 2rem;
    }
    
    .nav-brand {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 1.5rem;
      font-weight: 700;
      color: #f59e0b;
      text-decoration: none;
    }
    
    .nav-links {
      display: flex;
      gap: 2rem;
      align-items: center;
    }
    
    .btn-back {
      background: linear-gradient(135deg, #374151, #4b5563);
      color: white;
      padding: 0.75rem 1.5rem;
      border: none;
      border-radius: 10px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    
    .btn-back:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    /* Main Content */
    .main-content {
      margin-top: 80px;
      min-height: calc(100vh - 80px);
      background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
      padding: 3rem 0;
    }

    /* Hero Header */
    .checkout-header {
      text-align: center;
      margin-bottom: 3rem;
      padding: 2rem 0;
    }

    .checkout-title {
      font-size: 2.5rem;
      font-weight: 800;
      background: linear-gradient(135deg, #f59e0b, #fbbf24);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin-bottom: 0.5rem;
    }

    .checkout-subtitle {
      font-size: 1.2rem;
      color: #9ca3af;
    }

    /* Content Wrapper */
    .content-wrapper {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 2rem;
    }

    .checkout-grid {
      display: grid;
      grid-template-columns: 1fr 400px;
      gap: 3rem;
      align-items: start;
    }

    /* Payment Section */
    .payment-section {
      background: rgba(28, 28, 30, 0.8);
      border-radius: 20px;
      padding: 2rem;
      border: 1px solid #374151;
    }

    .section-title {
      font-size: 1.5rem;
      font-weight: 700;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      color: #f59e0b;
    }

    .payment-methods {
      display: flex;
      flex-direction: column;
      gap: 1rem;
      margin-bottom: 2rem;
    }

    .payment-method {
      border: 2px solid #374151;
      border-radius: 12px;
      padding: 1.5rem;
      cursor: pointer;
      transition: all 0.3s ease;
      background: rgba(0, 0, 0, 0.3);
    }

    .payment-method:hover {
      border-color: #f59e0b;
      background: rgba(245, 158, 11, 0.1);
    }

    .payment-method.selected {
      border-color: #f59e0b;
      background: rgba(245, 158, 11, 0.2);
    }

    .payment-method-header {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin-bottom: 1rem;
    }

    .payment-icon {
      font-size: 1.5rem;
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #f59e0b, #d97706);
      border-radius: 10px;
    }

    .payment-title {
      font-weight: 600;
      font-size: 1.1rem;
    }

    .payment-description {
      color: #9ca3af;
      font-size: 0.9rem;
    }

    .payment-details {
      display: none;
      margin-top: 1rem;
      padding-top: 1rem;
      border-top: 1px solid #4b5563;
    }

    .payment-details.show {
      display: block;
    }

    .form-group {
      margin-bottom: 1rem;
    }

    .form-label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 600;
      color: #d1d5db;
    }

    .form-select, .form-input {
      width: 100%;
      background: rgba(0, 0, 0, 0.5);
      border: 1px solid #4b5563;
      border-radius: 8px;
      padding: 0.75rem;
      color: white;
      font-size: 1rem;
      transition: border-color 0.3s ease;
    }

    .form-select:focus, .form-input:focus {
      outline: none;
      border-color: #f59e0b;
    }

    /* Booking Summary */
    .booking-summary {
      background: linear-gradient(135deg, #1f2937, #111827);
      border-radius: 20px;
      padding: 2rem;
      border: 1px solid #374151;
      position: sticky;
      top: 120px;
    }

    .venue-info {
      display: flex;
      gap: 1rem;
      margin-bottom: 1.5rem;
      padding-bottom: 1.5rem;
      border-bottom: 1px solid #4b5563;
    }

    .venue-image {
      width: 80px;
      height: 80px;
      border-radius: 12px;
      background: linear-gradient(135deg, #374151, #4b5563);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      flex-shrink: 0;
    }

    .venue-details h3 {
      font-weight: 700;
      margin-bottom: 0.25rem;
    }

    .venue-meta {
      color: #9ca3af;
      font-size: 0.9rem;
    }

    .booking-details {
      margin-bottom: 1.5rem;
    }

    .detail-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 0.75rem;
      padding: 0.5rem 0;
    }

    .detail-label {
      color: #9ca3af;
    }

    .detail-value {
      font-weight: 600;
    }

    .time-slots-list {
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
    }

    .time-slot-badge {
      background: linear-gradient(135deg, #f59e0b, #d97706);
      color: white;
      padding: 0.25rem 0.75rem;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 500;
    }

    .price-summary {
      background: rgba(0, 0, 0, 0.3);
      border-radius: 12px;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
    }

    .price-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 0.75rem;
    }

    .price-total {
      border-top: 1px solid #4b5563;
      padding-top: 0.75rem;
      margin-top: 0.75rem;
      font-weight: 700;
      font-size: 1.2rem;
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
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      width: 100%;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 30px rgba(245, 158, 11, 0.4);
    }

    .btn-primary:disabled {
      opacity: 0.6;
      cursor: not-allowed;
      transform: none;
      box-shadow: none;
    }

    /* Payment Gateway Cards */
    .gateway-options {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
      gap: 1rem;
      margin-top: 1rem;
    }

    .gateway-card {
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid #4b5563;
      border-radius: 8px;
      padding: 1rem;
      text-align: center;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .gateway-card:hover, .gateway-card.selected {
      border-color: #f59e0b;
      background: rgba(245, 158, 11, 0.1);
    }

    .gateway-icon {
      font-size: 1.5rem;
      margin-bottom: 0.5rem;
    }

    .gateway-name {
      font-size: 0.8rem;
      font-weight: 600;
    }

    /* Security Badge */
    .security-badge {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      background: rgba(34, 197, 94, 0.1);
      border: 1px solid rgba(34, 197, 94, 0.3);
      border-radius: 8px;
      padding: 0.75rem;
      margin-top: 1rem;
      font-size: 0.9rem;
    }

    .security-icon {
      color: #22c55e;
    }

    /* Responsive */
    @media (max-width: 1024px) {
      .checkout-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
      }

      .booking-summary {
        position: relative;
        top: auto;
        order: -1;
      }
    }

    @media (max-width: 768px) {
      .content-wrapper {
        padding: 0 1rem;
      }
      
      .checkout-title {
        font-size: 2rem;
      }

      .payment-section, .booking-summary {
        padding: 1.5rem;
      }

      .venue-info {
        flex-direction: column;
        text-align: center;
      }

      .gateway-options {
        grid-template-columns: repeat(2, 1fr);
      }
    }
  </style>
</head>
<body>
  <!-- Navigation -->
  <nav class="navbar">
    <div class="nav-container">
      <a href="{{ route('dashboard') }}" class="nav-brand">
        <img src="{{ asset('img/Lapangin-White.png') }}" alt="Lapangin" style="height: 32px; width: auto;">
      </a>
      <div class="nav-links">
        <a href="{{ route('pesanan') }}" class="btn-back">
          ← Kembali ke Pesanan
        </a>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="main-content">
    <!-- Header -->
    <div class="checkout-header">
      <h1 class="checkout-title">💳 Checkout Booking</h1>
      <p class="checkout-subtitle">Selesaikan pembayaran untuk mengkonfirmasi booking Anda</p>
    </div>

    <!-- Content -->
    <div class="content-wrapper">
      <div class="checkout-grid">
        <!-- Payment Section -->
        <div class="payment-section">
          <h2 class="section-title">
            💰 Pilih Metode Pembayaran
          </h2>

          <form action="{{ route('booking.payment', $booking) }}" method="POST" id="payment-form">
            @csrf
            
            <div class="payment-methods">
              <!-- Bank Transfer -->
              <div class="payment-method" data-method="transfer">
                <div class="payment-method-header">
                  <div class="payment-icon">🏦</div>
                  <div>
                    <div class="payment-title">Transfer Bank</div>
                    <div class="payment-description">Transfer langsung ke rekening bank</div>
                  </div>
                </div>
                <div class="payment-details" id="transfer-details">
                  <div class="form-group">
                    <label class="form-label">Pilih Bank</label>
                    <select name="bank_name" class="form-select">
                      <option value="">Pilih Bank</option>
                      <option value="bca">BCA</option>
                      <option value="mandiri">Mandiri</option>
                      <option value="bni">BNI</option>
                      <option value="bri">BRI</option>
                      <option value="cimb">CIMB Niaga</option>
                      <option value="permata">Permata</option>
                    </select>
                  </div>
                </div>
              </div>

              <!-- E-Wallet -->
              <div class="payment-method" data-method="ewallet">
                <div class="payment-method-header">
                  <div class="payment-icon">📱</div>
                  <div>
                    <div class="payment-title">E-Wallet</div>
                    <div class="payment-description">Bayar dengan dompet digital</div>
                  </div>
                </div>
                <div class="payment-details" id="ewallet-details">
                  <div class="gateway-options">
                    <div class="gateway-card" data-ewallet="gopay">
                      <div class="gateway-icon">🟢</div>
                      <div class="gateway-name">GoPay</div>
                    </div>
                    <div class="gateway-card" data-ewallet="ovo">
                      <div class="gateway-icon">🟣</div>
                      <div class="gateway-name">OVO</div>
                    </div>
                    <div class="gateway-card" data-ewallet="dana">
                      <div class="gateway-icon">🔵</div>
                      <div class="gateway-name">DANA</div>
                    </div>
                    <div class="gateway-card" data-ewallet="shopee">
                      <div class="gateway-icon">🟠</div>
                      <div class="gateway-name">ShopeePay</div>
                    </div>
                  </div>
                  <input type="hidden" name="ewallet_type" id="ewallet_type">
                </div>
              </div>

              <!-- Credit Card -->
              <div class="payment-method" data-method="credit_card">
                <div class="payment-method-header">
                  <div class="payment-icon">💳</div>
                  <div>
                    <div class="payment-title">Kartu Kredit/Debit</div>
                    <div class="payment-description">Visa, Mastercard, dan kartu lokal</div>
                  </div>
                </div>
                <div class="payment-details" id="credit_card-details">
                  <div class="form-group">
                    <label class="form-label">Nomor Kartu</label>
                    <input type="text" class="form-input" placeholder="1234 5678 9012 3456" maxlength="19">
                  </div>
                  <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                      <label class="form-label">Expired</label>
                      <input type="text" class="form-input" placeholder="MM/YY" maxlength="5">
                    </div>
                    <div class="form-group">
                      <label class="form-label">CVV</label>
                      <input type="text" class="form-input" placeholder="123" maxlength="3">
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <input type="hidden" name="payment_method" id="payment_method" required>

            <!-- Security Badge -->
            <div class="security-badge">
              <span class="security-icon">🔒</span>
              <span>Pembayaran Anda dilindungi dengan enkripsi SSL 256-bit</span>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-primary" id="submit-payment" disabled>
              🔒 Bayar Sekarang - Rp {{ number_format($booking->total_price) }}
            </button>
          </form>
        </div>

        <!-- Booking Summary -->
        <div class="booking-summary">
          <h3 class="section-title">📋 Ringkasan Booking</h3>
          
          <!-- Venue Info -->
          <div class="venue-info">
            <div class="venue-image">
              @switch($venue->sport->name)
                @case('Badminton')
                  🏸
                  @break
                @case('Futsal')
                  ⚽
                  @break
                @case('Tennis')
                  🎾
                  @break
                @case('Basketball')
                  🏀
                  @break
                @default
                  🏅
              @endswitch
            </div>
            <div class="venue-details">
              <h3>{{ $venue->name }}</h3>
              <div class="venue-meta">{{ $venue->sport->name }} • {{ $venue->city }}</div>
            </div>
          </div>

          <!-- Booking Details -->
          <div class="booking-details">
            <div class="detail-row">
              <span class="detail-label">Kode Booking:</span>
              <span class="detail-value">{{ $booking->booking_code }}</span>
            </div>
            <div class="detail-row">
              <span class="detail-label">Tanggal:</span>
              <span class="detail-value">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</span>
            </div>
            <div class="detail-row">
              <span class="detail-label">Waktu:</span>
              <div class="detail-value">
                <div class="time-slots-list">
                  @foreach($booking->selected_time_slots as $slot)
                    <span class="time-slot-badge">{{ $slot }}:00</span>
                  @endforeach
                </div>
              </div>
            </div>
            <div class="detail-row">
              <span class="detail-label">Durasi:</span>
              <span class="detail-value">{{ $booking->duration_hours }} jam</span>
            </div>
          </div>

          <!-- Price Summary -->
          <div class="price-summary">
            <div class="price-row">
              <span>Harga per jam:</span>
              <span>Rp {{ number_format($venue->price_per_hour) }}</span>
            </div>
            <div class="price-row">
              <span>Durasi:</span>
              <span>{{ $booking->duration_hours }} jam</span>
            </div>
            <div class="price-row">
              <span>Subtotal:</span>
              <span>Rp {{ number_format($booking->total_price) }}</span>
            </div>
            <div class="price-row">
              <span>Biaya Admin:</span>
              <span>Gratis</span>
            </div>
            <div class="price-row price-total">
              <span>Total Bayar:</span>
              <span>Rp {{ number_format($booking->total_price) }}</span>
            </div>
          </div>

          <!-- Booking Timer -->
          <div style="text-align: center; color: #9ca3af; font-size: 0.9rem;">
            ⏰ Selesaikan pembayaran dalam <span id="countdown">15:00</span>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script>
    let selectedMethod = null;
    let selectedEwallet = null;

    // Payment method selection
    document.querySelectorAll('.payment-method').forEach(method => {
      method.addEventListener('click', function() {
        // Remove selection from all methods
        document.querySelectorAll('.payment-method').forEach(m => {
          m.classList.remove('selected');
          m.querySelector('.payment-details').classList.remove('show');
        });

        // Select this method
        this.classList.add('selected');
        this.querySelector('.payment-details').classList.add('show');
        
        selectedMethod = this.dataset.method;
        document.getElementById('payment_method').value = selectedMethod;
        
        updateSubmitButton();
      });
    });

    // E-wallet selection
    document.querySelectorAll('.gateway-card').forEach(card => {
      card.addEventListener('click', function() {
        document.querySelectorAll('.gateway-card').forEach(c => c.classList.remove('selected'));
        this.classList.add('selected');
        
        selectedEwallet = this.dataset.ewallet;
        document.getElementById('ewallet_type').value = selectedEwallet;
        
        updateSubmitButton();
      });
    });

    function updateSubmitButton() {
      const submitBtn = document.getElementById('submit-payment');
      let isValid = false;

      if (selectedMethod === 'transfer') {
        const bankSelect = document.querySelector('select[name="bank_name"]');
        isValid = bankSelect.value !== '';
      } else if (selectedMethod === 'ewallet') {
        isValid = selectedEwallet !== null;
      } else if (selectedMethod === 'credit_card') {
        isValid = true; // For demo purposes
      }

      submitBtn.disabled = !isValid;
    }

    // Bank selection change
    document.querySelector('select[name="bank_name"]').addEventListener('change', updateSubmitButton);

    // Countdown Timer
    let timeLeft = 15 * 60; // 15 minutes in seconds

    function updateCountdown() {
      const minutes = Math.floor(timeLeft / 60);
      const seconds = timeLeft % 60;
      const display = `${minutes}:${seconds.toString().padStart(2, '0')}`;
      document.getElementById('countdown').textContent = display;

      if (timeLeft <= 0) {
        Swal.fire({
          title: 'Waktu Habis!',
          text: 'Batas waktu pembayaran telah berakhir. Booking akan dibatalkan.',
          icon: 'error',
          background: '#1f2937',
          color: '#fff',
          confirmButtonColor: '#f59e0b'
        }).then(() => {
          window.location.href = '{{ route("pesanan") }}';
        });
        return;
      }

      timeLeft--;
    }

    setInterval(updateCountdown, 1000);

    // Form submission
    document.getElementById('payment-form').addEventListener('submit', function(e) {
      e.preventDefault();
      
      Swal.fire({
        title: 'Memproses Pembayaran...',
        text: 'Mohon tunggu sebentar',
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

      // Simulate payment processing
      setTimeout(() => {
        this.submit();
      }, 2000);
    });

    // Success/Error Messages
    @if(session('success'))
      Swal.fire({
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        icon: 'success',
        background: '#1f2937',
        color: '#fff',
        confirmButtonColor: '#f59e0b'
      });
    @endif

    @if(session('error'))
      Swal.fire({
        title: 'Error!',
        text: '{{ session('error') }}',
        icon: 'error',
        background: '#1f2937',
        color: '#fff',
        confirmButtonColor: '#f59e0b'
      });
    @endif

    // Format card number input
    document.querySelector('input[placeholder="1234 5678 9012 3456"]').addEventListener('input', function(e) {
      let value = e.target.value.replace(/\s/g, '');
      let formattedValue = value.replace(/(.{4})/g, '$1 ').trim();
      e.target.value = formattedValue;
    });

    // Format expiry input
    document.querySelector('input[placeholder="MM/YY"]').addEventListener('input', function(e) {
      let value = e.target.value.replace(/\D/g, '');
      if (value.length >= 2) {
        value = value.substring(0, 2) + '/' + value.substring(2, 4);
      }
      e.target.value = value;
    });
  </script>
</body>
</html>
