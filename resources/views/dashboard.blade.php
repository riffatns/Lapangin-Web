<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Lapangin</title>
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
    
    .logo h2 {
      color: white;
      font-size: 1.5rem;
      font-weight: 700;
      margin-left: 0.5rem;
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
      padding: 1rem 2rem;
      border-bottom: 1px solid #404040;
      display: flex;
      align-items: center;
      gap: 2rem;
    }
    
    .filter-tabs {
      display: flex;
      gap: 1rem;
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
    
    .location-filters {
      display: flex;
      gap: 1rem;
      margin-left: auto;
    }
    
    .location-filter {
      padding: 0.5rem 1rem;
      background-color: #404040;
      border: none;
      color: white;
      border-radius: 6px;
      cursor: pointer;
      font-weight: 500;
      transition: all 0.2s ease;
    }
    
    .location-filter:hover {
      background-color: #525252;
    }
    
    .search-bar {
      margin-left: 2rem;
      position: relative;
    }
    
    .search-bar input {
      background-color: #404040;
      border: none;
      padding: 0.5rem 2.5rem 0.5rem 1rem;
      border-radius: 6px;
      color: white;
      font-size: 0.9rem;
      width: 250px;
    }
    
    .search-bar input::placeholder {
      color: #999;
    }
    
    /* Content Area */
    .content {
      padding: 2rem;
    }
    
    .cards-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 1.5rem;
      margin-top: 1rem;
    }
    
    .field-card {
      background-color: #2c2c2e;
      border-radius: 12px;
      overflow: hidden;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .field-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }
    
    .card-image {
      height: 180px;
      background: linear-gradient(135deg, #f59e0b, #d97706);
      position: relative;
      overflow: hidden;
    }
    
    .card-image.badminton {
      background: linear-gradient(135deg, #10b981, #059669);
    }
    
    .card-image.futsal {
      background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    }
    
    .card-image.tennis {
      background: linear-gradient(135deg, #ef4444, #dc2626);
    }
    
    .card-image.basketball {
      background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    }
    
    .card-image.volleyball {
      background: linear-gradient(135deg, #f59e0b, #d97706);
    }
    
    .location-badge {
      position: absolute;
      bottom: 1rem;
      left: 1rem;
      background-color: rgba(0, 0, 0, 0.7);
      color: white;
      padding: 0.25rem 0.75rem;
      border-radius: 12px;
      font-size: 0.8rem;
      font-weight: 500;
    }
    
    .card-content {
      padding: 1.25rem;
    }
    
    .card-title {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 0.75rem;
      color: white;
    }
    
    .card-rating {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      margin-bottom: 0.75rem;
    }
    
    .stars {
      color: #f59e0b;
      font-size: 0.9rem;
    }
    
    .rating-text {
      color: #999;
      font-size: 0.85rem;
    }
    
    .card-price {
      color: white;
      font-weight: 600;
      font-size: 1rem;
    }
    
    .price-highlight {
      color: #f59e0b;
    }
    
    .welcome-section {
      margin-bottom: 2rem;
    }
    
    .welcome-title {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
    }
    
    .welcome-subtitle {
      color: #999;
      font-size: 1rem;
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
      
      .header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
      }
      
      .search-bar {
        margin-left: 0;
      }
      
      .cards-grid {
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
    <!-- Header with filters -->
    <div class="header">
      <div class="filter-tabs">
        <button class="filter-tab active">All</button>
        <button class="filter-tab">Badminton</button>
        <button class="filter-tab">Mini Soccer</button>
        <button class="filter-tab">Tennis</button>
        <button class="filter-tab">Futsal</button>
        <button class="filter-tab">Other Sports</button>
      </div>
      
      <div class="location-filters">
        <button class="location-filter">Jarak ↕</button>
        <button class="location-filter">Lokasi ↕</button>
      </div>
      
      <div class="search-bar">
        <input type="text" placeholder="Search...">
      </div>
    </div>

    <!-- Content -->
    <div class="content">
      <div class="welcome-section">
        <h1 class="welcome-title">Welcome back, {{ Auth::user()->name }}!</h1>
        <p class="welcome-subtitle">Find and book your favorite sports field</p>
      </div>

      @if(session('success'))
        <div style="background-color: #059669; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
          {{ session('success') }}
        </div>
      @endif

      <!-- Fields Grid -->
      <div class="cards-grid">
        @foreach($venues as $venue)
        <div class="field-card">
          <div class="card-image {{ strtolower($venue->sport->name) }}">
            <div class="location-badge">📍 {{ $venue->location }}</div>
          </div>
          <div class="card-content">
            <h3 class="card-title">{{ $venue->name }}</h3>
            <div class="card-rating">
              <span class="stars">⭐ {{ number_format($venue->rating, 1) }}</span>
              <span class="rating-text">({{ $venue->total_reviews }})</span>
            </div>
            <div class="card-price">
              Mulai <span class="price-highlight">Rp {{ number_format($venue->price_per_hour, 0, ',', '.') }}</span>/jam
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</body>
</html>
