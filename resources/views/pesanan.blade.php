<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pesanan - Lapangin</title>
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
    
    .header-title {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
    }
    
    .header-subtitle {
      color: #999;
      font-size: 1rem;
    }
    
    /* Content Area */
    .content {
      padding: 2rem;
    }
    
    .filter-section {
      margin-bottom: 2rem;
    }
    
    .filter-tabs {
      display: flex;
      gap: 1rem;
      margin-bottom: 1.5rem;
    }
    
    .filter-tab {
      padding: 0.5rem 1rem;
      background: none;
      border: none;
      color: #999;
      cursor: pointer;
      border-radius: 6px;
      font-weight: 500;
      transition: all 0.2s ease;
    }
    
    .filter-tab.active {
      background-color: #f59e0b;
      color: white;
    }
    
    .filter-tab:hover:not(.active) {
      color: white;
      background-color: #404040;
    }
    
    /* Empty State */
    .empty-state {
      text-align: center;
      padding: 4rem 2rem;
      background-color: #2c2c2e;
      border-radius: 12px;
      border: 2px dashed #404040;
    }
    
    .empty-icon {
      font-size: 4rem;
      margin-bottom: 1rem;
      opacity: 0.5;
    }
    
    .empty-title {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
      color: #999;
    }
    
    .empty-subtitle {
      color: #666;
      margin-bottom: 2rem;
      line-height: 1.5;
    }
    
    .empty-action {
      background-color: #f59e0b;
      color: white;
      padding: 0.75rem 1.5rem;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease;
      text-decoration: none;
      display: inline-block;
    }
    
    .empty-action:hover {
      background-color: #d97706;
      transform: translateY(-1px);
    }
    
    /* Order Cards */
    .orders-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
      gap: 1.5rem;
    }
    
    .order-card {
      background-color: #2c2c2e;
      border-radius: 12px;
      padding: 1.5rem;
      border-left: 4px solid #f59e0b;
      transition: all 0.2s ease;
    }
    
    .order-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }
    
    .order-header {
      display: flex;
      justify-content: between;
      align-items: flex-start;
      margin-bottom: 1rem;
    }
    
    .order-title {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 0.25rem;
    }
    
    .order-status {
      padding: 0.25rem 0.75rem;
      border-radius: 12px;
      font-size: 0.8rem;
      font-weight: 500;
      margin-left: auto;
    }
    
    .status-upcoming {
      background-color: rgba(59, 130, 246, 0.2);
      color: #60a5fa;
    }
    
    .status-completed {
      background-color: rgba(16, 185, 129, 0.2);
      color: #34d399;
    }
    
    .status-cancelled {
      background-color: rgba(239, 68, 68, 0.2);
      color: #f87171;
    }
    
    .order-details {
      margin-bottom: 1rem;
    }
    
    .detail-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 0.5rem;
      color: #999;
      font-size: 0.9rem;
    }
    
    .detail-value {
      color: white;
      font-weight: 500;
    }
    
    .order-actions {
      display: flex;
      gap: 0.75rem;
      margin-top: 1rem;
    }
    
    .action-btn {
      padding: 0.5rem 1rem;
      border: none;
      border-radius: 6px;
      font-size: 0.9rem;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s ease;
      text-decoration: none;
    }
    
    .btn-primary {
      background-color: #f59e0b;
      color: white;
    }
    
    .btn-primary:hover {
      background-color: #d97706;
    }
    
    .btn-secondary {
      background-color: #404040;
      color: white;
    }
    
    .btn-secondary:hover {
      background-color: #525252;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
      .sidebar {
        width: 70px;
      }
      
      .logo h2,
      .nav-item span,
      .user-item span {
        display: none;
      }
      
      .orders-grid {
        grid-template-columns: 1fr;
      }
      
      .empty-state {
        padding: 2rem 1rem;
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
      <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <span class="icon">🏠</span>
        <span>Home</span>
      </a>
      <a href="{{ route('pesanan') }}" class="nav-item {{ request()->routeIs('pesanan') ? 'active' : '' }}">
        <span class="icon">📋</span>
        <span>Pesanan</span>
      </a>
      <a href="{{ route('komunitas') }}" class="nav-item">
        <span class="icon">👥</span>
        <span>Komunitas</span>
      </a>
    </div>
    
    <div class="user-section">
      <a href="{{ route('notifikasi') }}" class="nav-item {{ request()->routeIs('notifikasi') ? 'active' : '' }}">
        <span class="icon">🔔</span>
        <span>Notification Settings</span>
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
      <h1 class="header-title">Pesanan Saya</h1>
      <p class="header-subtitle">Kelola jadwal booking lapangan Anda</p>
    </div>

    <!-- Content -->
    <div class="content">
      <!-- Filter Section -->
      <div class="filter-section">
        <div class="filter-tabs">
          <button class="filter-tab active">Semua</button>
          <button class="filter-tab">Upcoming</button>
          <button class="filter-tab">Completed</button>
          <button class="filter-tab">Cancelled</button>
        </div>
      </div>

      @if(session('success'))
        <div style="background-color: #059669; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
          {{ session('success') }}
        </div>
      @endif

      <!-- Orders Content -->
      @php
        // Simulasi data - di aplikasi nyata ini akan dari database
        $orders = []; // Kosong untuk simulasi empty state
        
        // Contoh data jika ada pesanan:
        // $orders = [
        //   [
        //     'id' => 1,
        //     'field_name' => 'GOR Badminton Telyu',
        //     'date' => '2025-07-05',
        //     'time' => '14:00 - 16:00',
        //     'duration' => '2 jam',
        //     'price' => 100000,
        //     'status' => 'upcoming'
        //   ]
        // ];
      @endphp

      @if(empty($orders))
        <!-- Empty State -->
        <div class="empty-state">
          <div class="empty-icon">📅</div>
          <h2 class="empty-title">Belum Ada Jadwal Booking</h2>
          <p class="empty-subtitle">
            Anda belum memiliki jadwal booking lapangan saat ini.<br>
            Mulai booking lapangan favorit Anda untuk bermain bersama teman-teman!
          </p>
          <a href="{{ route('dashboard') }}" class="empty-action">
            Cari Lapangan
          </a>
        </div>
      @else
        <!-- Orders Grid -->
        <div class="orders-grid">
          @foreach($orders as $order)
            <div class="order-card">
              <div class="order-header">
                <div>
                  <h3 class="order-title">{{ $order['field_name'] }}</h3>
                  <div class="order-status status-{{ $order['status'] }}">
                    @if($order['status'] == 'upcoming')
                      Akan Datang
                    @elseif($order['status'] == 'completed')
                      Selesai
                    @else
                      Dibatalkan
                    @endif
                  </div>
                </div>
              </div>
              
              <div class="order-details">
                <div class="detail-row">
                  <span>Tanggal:</span>
                  <span class="detail-value">{{ date('d M Y', strtotime($order['date'])) }}</span>
                </div>
                <div class="detail-row">
                  <span>Waktu:</span>
                  <span class="detail-value">{{ $order['time'] }}</span>
                </div>
                <div class="detail-row">
                  <span>Durasi:</span>
                  <span class="detail-value">{{ $order['duration'] }}</span>
                </div>
                <div class="detail-row">
                  <span>Total:</span>
                  <span class="detail-value">Rp {{ number_format($order['price'], 0, ',', '.') }}</span>
                </div>
              </div>
              
              <div class="order-actions">
                @if($order['status'] == 'upcoming')
                  <button class="action-btn btn-primary">Lihat Detail</button>
                  <button class="action-btn btn-secondary">Batalkan</button>
                @else
                  <button class="action-btn btn-secondary">Lihat Detail</button>
                @endif
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </div>
</body>
</html>
