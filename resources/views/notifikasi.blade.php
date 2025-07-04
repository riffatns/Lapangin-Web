<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notification Settings - Lapangin</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Inter', sans-serif;
      background-color: #1a1a1a;
      color: white;
      display: flex;
      height: 100vh;
      overflow: hidden;
    }
    
    /* Sidebar */
    .sidebar {
      width: 250px;
      background-color: #2c2c2e;
      padding: 2rem 0;
      display: flex;
      flex-direction: column;
      border-right: 1px solid #404040;
    }
    
    .logo {
      padding: 0 1.5rem;
      margin-bottom: 3rem;
    }
    
    .logo img {
      height: 32px;
    }
    
    .nav-menu {
      flex: 1;
      padding: 0 1rem;
    }
    
    .nav-item {
      display: flex;
      align-items: center;
      padding: 0.75rem 1rem;
      margin-bottom: 0.5rem;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.2s ease;
      text-decoration: none;
      color: #999;
      font-weight: 500;
    }
    
    .nav-item:hover {
      background-color: #404040;
      color: white;
    }
    
    .nav-item.active {
      background-color: #f59e0b;
      color: white;
    }
    
    .nav-item .icon {
      margin-right: 0.75rem;
      font-size: 1.1rem;
    }
    
    .user-section {
      padding: 1rem 1.5rem;
      border-top: 1px solid #404040;
    }
    
    .user-item {
      display: flex;
      align-items: center;
      padding: 0.75rem 1rem;
      margin-bottom: 0.5rem;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.2s ease;
      text-decoration: none;
      color: #999;
      font-weight: 500;
    }
    
    .user-item:hover {
      background-color: #404040;
      color: white;
    }
    
    .user-item.active {
      background-color: #f59e0b;
      color: white;
    }
    
    .user-item .icon {
      margin-right: 0.75rem;
      font-size: 1.1rem;
    }
    
    /* Main Content */
    .main-content {
      flex: 1;
      background-color: #1a1a1a;
      overflow-y: auto;
    }
    
    .header {
      background-color: #2c2c2e;
      padding: 1.5rem 2rem;
      border-bottom: 1px solid #404040;
    }
    
    .header h1 {
      font-size: 1.75rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
    }
    
    .header p {
      color: #999;
      font-size: 0.9rem;
    }
    
    /* Content */
    .content {
      padding: 2rem;
    }
    
    /* Notification Tabs */
    .notification-tabs {
      display: flex;
      background-color: #2c2c2e;
      border-radius: 12px;
      padding: 0.5rem;
      margin-bottom: 2rem;
      border: 1px solid #404040;
      overflow-x: auto;
    }
    
    .tab-btn {
      flex: 1;
      min-width: 120px;
      padding: 0.75rem 1rem;
      background: none;
      border: none;
      color: #999;
      font-weight: 500;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.2s ease;
      white-space: nowrap;
    }
    
    .tab-btn.active {
      background-color: #f59e0b;
      color: white;
    }
    
    .tab-btn:hover:not(.active) {
      color: white;
      background-color: #404040;
    }
    
    /* Empty State */
    .empty-state {
      text-align: center;
      padding: 3rem 2rem;
      max-width: 600px;
      margin: 0 auto;
    }
    
    .empty-icon {
      font-size: 4rem;
      margin-bottom: 1.5rem;
      opacity: 0.4;
    }
    
    .empty-title {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 1rem;
      color: #ccc;
    }
    
    .empty-description {
      font-size: 1rem;
      color: #999;
      line-height: 1.6;
      margin-bottom: 2rem;
    }
    
    /* Info Cards */
    .info-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 1.5rem;
      margin-top: 2rem;
    }
    
    .info-card {
      background-color: #2c2c2e;
      border-radius: 12px;
      padding: 1.5rem;
      border: 1px solid #404040;
      transition: transform 0.2s ease;
    }
    
    .info-card:hover {
      transform: translateY(-2px);
    }
    
    .card-icon {
      font-size: 2rem;
      margin-bottom: 1rem;
    }
    
    .card-title {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 0.75rem;
      color: #f59e0b;
    }
    
    .card-description {
      color: #ccc;
      font-size: 0.9rem;
      line-height: 1.5;
    }
    
    /* Notification Cards (when there are notifications) */
    .notification-list {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }
    
    .notification-card {
      background-color: #2c2c2e;
      border-radius: 12px;
      padding: 1.5rem;
      border: 1px solid #404040;
      border-left: 4px solid #f59e0b;
      transition: all 0.2s ease;
    }
    
    .notification-card:hover {
      background-color: #333333;
    }
    
    .notification-card.unread {
      border-left-color: #3b82f6;
      background-color: rgba(59, 130, 246, 0.1);
    }
    
    .notification-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 0.75rem;
    }
    
    .notification-type {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    
    .type-icon {
      font-size: 1.2rem;
    }
    
    .type-text {
      font-weight: 600;
      color: #f59e0b;
      font-size: 0.8rem;
      text-transform: uppercase;
    }
    
    .notification-time {
      color: #999;
      font-size: 0.8rem;
    }
    
    .notification-title {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
    }
    
    .notification-message {
      color: #ccc;
      line-height: 1.5;
      font-size: 0.9rem;
    }
    
    /* Demo Toggle */
    .demo-toggle {
      position: fixed;
      bottom: 2rem;
      right: 2rem;
      background: linear-gradient(135deg, #f59e0b, #d97706);
      color: white;
      border: none;
      padding: 1rem;
      border-radius: 50%;
      cursor: pointer;
      font-size: 1.2rem;
      box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
      transition: all 0.2s ease;
      z-index: 1000;
    }
    
    .demo-toggle:hover {
      transform: scale(1.1);
      box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
    }
    
    /* Sample notifications */
    .sample-notifications {
      display: none;
    }
    
    .show-sample .sample-notifications {
      display: block;
    }
    
    .show-sample .empty-state {
      display: none;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
      .sidebar {
        width: 70px;
      }
      
      .nav-item span:not(.icon),
      .user-item span:not(.icon) {
        display: none;
      }
      
      .content {
        padding: 1rem;
      }
      
      .notification-tabs {
        flex-direction: column;
      }
      
      .tab-btn {
        min-width: auto;
      }
      
      .info-cards {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="logo">
      <img src="{{ asset('img/Lapangin-White.png') }}" alt="Lapangin">
    </div>
    
    <div class="nav-menu">
      <a href="{{ route('dashboard') }}" class="nav-item">
        <span class="icon">🏠</span>
        <span>Home</span>
      </a>
      <a href="{{ route('pesanan') }}" class="nav-item">
        <span class="icon">📋</span>
        <span>Pesanan</span>
      </a>
      <a href="{{ route('komunitas') }}" class="nav-item">
        <span class="icon">👥</span>
        <span>Komunitas</span>
      </a>
    </div>
    
    <div class="user-section">
      <a href="{{ route('notifikasi') }}" class="user-item active">
        <span class="icon">🔔</span>
        <span>Notification</span>
      </a>
      <a href="{{ route('profile') }}" class="nav-item {{ request()->routeIs('profile') ? 'active' : '' }}">
        <span class="icon">👤</span>
        <span>Profile</span>
      </a>
      <form action="{{ url('/logout') }}" method="POST" style="display: inline; width: 100%;">
        @csrf
        <button type="submit" class="user-item" style="background: none; border: none; width: 100%; text-align: left;">
          <span class="icon">🚪</span>
          <span>Logout</span>
        </button>
      </form>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Header -->
    <div class="header">
      <h1>Notification Settings</h1>
      <p>Kelola preferensi notifikasi dan tetap update dengan aktivitas terbaru</p>
    </div>

    <!-- Content -->
    <div class="content">
      <!-- Notification Tabs -->
      <div class="notification-tabs">
        <button class="tab-btn active" onclick="switchTab('all')">Semua</button>
        <button class="tab-btn" onclick="switchTab('booking')">Booking</button>
        <button class="tab-btn" onclick="switchTab('payment')">Pembayaran</button>
        <button class="tab-btn" onclick="switchTab('community')">Komunitas</button>
        <button class="tab-btn" onclick="switchTab('promo')">Promo</button>
        <button class="tab-btn" onclick="switchTab('system')">Sistem</button>
      </div>

      @if($notifications->count() > 0)
      <!-- Notifications List -->
      <div class="notification-list">
        @foreach($notifications as $notification)
        <div class="notification-card {{ $notification->read_at ? '' : 'unread' }}">
          <div class="notification-header">
            <div class="notification-type">
              <span class="type-icon">
                @switch($notification->type)
                  @case('booking')
                    📅
                    @break
                  @case('payment')
                    💰
                    @break
                  @case('community')
                    👥
                    @break
                  @case('promo')
                    🎁
                    @break
                  @case('achievement')
                    🏆
                    @break
                  @case('system')
                    ⚠️
                    @break
                  @default
                    🔔
                @endswitch
              </span>
              <span class="type-text">{{ ucfirst($notification->type) }}</span>
            </div>
            <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
          </div>
          <h3 class="notification-title">{{ $notification->title }}</h3>
          <p class="notification-message">{{ $notification->message }}</p>
          @if(!$notification->read_at)
            <form action="{{ route('notifications.mark-read', $notification) }}" method="POST" style="margin-top: 10px;">
              @csrf
              <button type="submit" style="background: #f59e0b; color: white; border: none; padding: 5px 10px; border-radius: 4px; font-size: 12px;">Tandai Dibaca</button>
            </form>
          @endif
        </div>
        @endforeach
      </div>
      @else
      <!-- Empty State -->
      <div class="empty-state">
        <div class="empty-icon">🔔</div>
        <h2 class="empty-title">Belum Ada Notifikasi</h2>
        <p class="empty-description">
          Anda belum memiliki notifikasi apapun saat ini. Notifikasi akan muncul di sini ketika ada aktivitas baru terkait booking, pembayaran, komunitas, atau promo menarik dari Lapangin.
        </p>

        <!-- Info Cards -->
        <div class="info-cards">
          <div class="info-card">
            <div class="card-icon">📅</div>
            <h3 class="card-title">Booking & Jadwal</h3>
            <p class="card-description">
              Konfirmasi booking berhasil, pengingat sebelum main, perubahan jadwal, dan update terkait reservasi lapangan Anda.
            </p>
          </div>

          <div class="info-card">
            <div class="card-icon">💰</div>
            <h3 class="card-title">Pembayaran</h3>
            <p class="card-description">
              Status transaksi, konfirmasi pembayaran berhasil, invoice, dan informasi refund atau pengembalian dana.
            </p>
          </div>

          <div class="info-card">
            <div class="card-icon">👥</div>
            <h3 class="card-title">Komunitas</h3>
            <p class="card-description">
              Undangan main bareng, tournament, event komunitas, achievement baru, dan update dari komunitas yang Anda ikuti.
            </p>
          </div>

          <div class="info-card">
            <div class="card-icon">🎁</div>
            <h3 class="card-title">Promo & Penawaran</h3>
            <p class="card-description">
              Diskon spesial, promo weekend, cashback, voucher gratis, dan penawaran menarik lainnya dari Lapangin.
            </p>
          </div>

          <div class="info-card">
            <div class="card-icon">🏆</div>
            <h3 class="card-title">Achievement</h3>
            <p class="card-description">
              Level up, ranking baru, badge achievement, milestone, dan pencapaian lainnya dalam komunitas olahraga.
            </p>
          </div>

          <div class="info-card">
            <div class="card-icon">⚠️</div>
            <h3 class="card-title">Sistem & Update</h3>
            <p class="card-description">
              Update aplikasi, maintenance sistem, perubahan kebijakan, tips penggunaan, dan informasi penting lainnya.
            </p>
          </div>
        </div>
      </div>
      @endif

      <!-- Generate Sample Notifications Button -->
      <div style="margin-top: 2rem; text-align: center;">
        <form action="{{ route('notifications.sample') }}" method="POST">
          @csrf
          <button type="submit" style="background: #f59e0b; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 600; cursor: pointer;">
            Generate Sample Notifications
          </button>
        </form>
      </div>

      <!-- Sample Notifications (hidden by default) -->
      <div class="sample-notifications">
        <div class="notification-list">
          <div class="notification-card unread">
            <div class="notification-header">
              <div class="notification-type">
                <span class="type-icon">📅</span>
                <span class="type-text">Booking</span>
              </div>
              <span class="notification-time">2 menit yang lalu</span>
            </div>
            <h3 class="notification-title">Booking Berhasil!</h3>
            <p class="notification-message">
              Booking lapangan badminton di GOR Badminton Telyu untuk tanggal 15 Januari 2025, pukul 19:00-21:00 telah berhasil dikonfirmasi. Jangan lupa datang tepat waktu dan bawa perlengkapan olahraga Anda!
            </p>
          </div>

          <div class="notification-card">
            <div class="notification-header">
              <div class="notification-type">
                <span class="type-icon">👥</span>
                <span class="type-text">Komunitas</span>
              </div>
              <span class="notification-time">1 jam yang lalu</span>
            </div>
            <h3 class="notification-title">Undangan Main Bareng</h3>
            <p class="notification-message">
              Ahmad Rivaldy mengundang Anda untuk main badminton bersama di Badminton Club Bandung. Waktu: Sabtu, 18 Januari 2025 pukul 16:00. Jangan lewatkan kesempatan main dengan atlet berprestasi!
            </p>
          </div>

          <div class="notification-card">
            <div class="notification-header">
              <div class="notification-type">
                <span class="type-icon">🎁</span>
                <span class="type-text">Promo</span>
              </div>
              <span class="notification-time">3 jam yang lalu</span>
            </div>
            <h3 class="notification-title">Diskon 50% Weekend Special!</h3>
            <p class="notification-message">
              Dapatkan diskon 50% untuk semua booking lapangan tennis di weekend ini! Promo berlaku untuk booking hari Sabtu-Minggu. Gunakan kode: WEEKEND50. Berlaku sampai Minggu, 19 Januari 2025.
            </p>
          </div>

          <div class="notification-card">
            <div class="notification-header">
              <div class="notification-type">
                <span class="type-icon">🏆</span>
                <span class="type-text">Achievement</span>
              </div>
              <span class="notification-time">1 hari yang lalu</span>
            </div>
            <h3 class="notification-title">Naik Level - Tennis Enthusiast!</h3>
            <p class="notification-message">
              Selamat! Anda telah mencapai level "Tennis Enthusiast" setelah menyelesaikan 25 match tennis. Anda mendapat 200 poin bonus dan badge baru. Total poin Anda sekarang: 2,650 poin.
            </p>
          </div>

          <div class="notification-card">
            <div class="notification-header">
              <div class="notification-type">
                <span class="type-icon">💰</span>
                <span class="type-text">Pembayaran</span>
              </div>
              <span class="notification-time">2 hari yang lalu</span>
            </div>
            <h3 class="notification-title">Pembayaran Berhasil</h3>
            <p class="notification-message">
              Pembayaran sebesar Rp 100.000 untuk booking lapangan futsal di Futsal Arena telah berhasil diproses. Invoice dan e-receipt telah dikirim ke email Anda.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Demo Toggle Button -->
  <button class="demo-toggle" onclick="toggleDemo()" title="Lihat Contoh Notifikasi">
    💡
  </button>

  <script>
    let showingSample = false;

    function toggleDemo() {
      showingSample = !showingSample;
      document.body.classList.toggle('show-sample', showingSample);
      
      const toggleBtn = document.querySelector('.demo-toggle');
      toggleBtn.innerHTML = showingSample ? '🔔' : '💡';
      toggleBtn.title = showingSample ? 'Sembunyikan Contoh' : 'Lihat Contoh Notifikasi';
    }

    function switchTab(type) {
      // Remove active class from all tabs
      document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
      });
      
      // Add active class to clicked tab
      event.target.classList.add('active');
      
      // Here you would implement actual filtering logic
      console.log('Switching to tab:', type);
      
      // For demo purposes, you could filter the sample notifications
      if (showingSample) {
        filterNotificationsByType(type);
      }
    }

    function filterNotificationsByType(type) {
      // This would be implemented to show/hide notifications based on type
      console.log('Filtering notifications by:', type);
    }
  </script>
</body>
</html>