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
      font-family: 'Inter', sans-serif;
      font-size: 1rem;
      border: none;
      background: none;
      width: 100%;
      text-align: left;
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
      font-size: 14px;
      font-family: 'Inter', sans-serif;
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
      position: relative;
      min-width: 140px;
      text-align: center;
      font-size: 14px;
      font-family: 'Inter', sans-serif;
    }
    
    .location-filter:hover {
      background-color: #525252;
    }
    
    .filter-dropdown {
      position: absolute;
      top: 100%;
      left: 50%;
      transform: translateX(-50%) translateY(-10px);
      background-color: #2c2c2e;
      border: 1px solid #404040;
      border-radius: 6px;
      margin-top: 0.25rem;
      z-index: 1000;
      opacity: 0;
      visibility: hidden;
      transition: all 0.2s ease;
      min-width: 180px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
      white-space: nowrap;
    }

    .filter-dropdown.show {
      opacity: 1;
      visibility: visible;
      transform: translateX(-50%) translateY(0);
    }

    .dropdown-item {
      padding: 0.75rem 1rem;
      cursor: pointer;
      transition: all 0.2s ease;
      color: white;
      border-bottom: 1px solid #404040;
      font-size: 0.9rem;
    }

    .dropdown-item:hover {
      background-color: #404040;
    }

    .dropdown-item:last-child {
      border-bottom: none;
    }

    .dropdown-item.selected {
      background-color: #f59e0b;
      color: white;
    }
    
    /* Filter Summary Bar */
    .filter-summary {
      background-color: #2c2c2e;
      padding: 1rem 2rem;
      border-bottom: 1px solid #404040;
      display: none;
    }
    
    .filter-summary.active {
      display: block;
    }
    
    .filter-summary-content {
      display: flex;
      align-items: center;
      gap: 1rem;
      flex-wrap: wrap;
    }
    
    .filter-summary-label {
      color: #999;
      font-size: 0.9rem;
      font-weight: 500;
    }
    
    .filter-tag {
      background-color: #f59e0b;
      color: white;
      padding: 0.25rem 0.75rem;
      border-radius: 20px;
      font-size: 0.85rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    
    .filter-tag .remove-filter {
      background: none;
      border: none;
      color: white;
      cursor: pointer;
      font-size: 1rem;
      line-height: 1;
      padding: 0;
      margin: 0;
      opacity: 0.8;
    }
    
    .filter-tag .remove-filter:hover {
      opacity: 1;
    }
    
    .clear-all-filters {
      background-color: #404040;
      color: white;
      border: none;
      padding: 0.4rem 1rem;
      border-radius: 6px;
      cursor: pointer;
      font-size: 0.85rem;
      transition: all 0.2s ease;
    }
    
    .clear-all-filters:hover {
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
    
    .field-card-link {
      text-decoration: none;
      color: inherit;
      display: block;
    }
    
    .field-card {
      background-color: #2c2c2e;
      border-radius: 12px;
      overflow: hidden;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      cursor: pointer;
    }
    
    .field-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }
    
    .field-card-link:hover .field-card {
      transform: translateY(-3px);
      box-shadow: 0 12px 30px rgba(245, 158, 11, 0.2);
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
    
    /* Recommendations Section */
    .recommendations-section {
      background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(217, 119, 6, 0.05));
      border: 1px solid rgba(245, 158, 11, 0.2);
      border-radius: 16px;
      padding: 2rem;
      position: relative;
      overflow: hidden;
    }
    
    .recommendations-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: linear-gradient(90deg, #f59e0b, #d97706, #f59e0b);
      border-radius: 16px 16px 0 0;
    }
    
    .recommendation-card {
      transition: all 0.3s ease;
      background: linear-gradient(135deg, rgba(245, 158, 11, 0.05), rgba(44, 44, 46, 1));
    }
    
    .recommendation-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 15px 35px rgba(245, 158, 11, 0.3);
      border-color: #d97706;
    }
    
    .recommendation-badge {
      animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
      0% {
        box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7);
      }
      70% {
        box-shadow: 0 0 0 10px rgba(245, 158, 11, 0);
      }
      100% {
        box-shadow: 0 0 0 0 rgba(245, 158, 11, 0);
      }
    }
    
    .section-header {
      position: relative;
    }
    
    .recommendation-icon {
      box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    }
    
    /* All Fields Section */
    .all-fields-section h2 {
      position: relative;
      padding-left: 1rem;
    }
    
    .all-fields-section h2::before {
      content: '';
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      width: 4px;
      height: 20px;
      background: linear-gradient(135deg, #f59e0b, #d97706);
      border-radius: 2px;
    }
    
    /* Similar Venues Section */
    .similar-section {
      background: linear-gradient(135deg, rgba(139, 92, 246, 0.1), rgba(124, 58, 237, 0.05));
      border: 1px solid rgba(139, 92, 246, 0.2);
      border-radius: 16px;
      padding: 2rem;
      position: relative;
      overflow: hidden;
    }
    
    .similar-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: linear-gradient(90deg, #8b5cf6, #7c3aed, #8b5cf6);
      border-radius: 16px 16px 0 0;
    }
    
    .similar-card {
      transition: all 0.3s ease;
      background: linear-gradient(135deg, rgba(139, 92, 246, 0.05), rgba(44, 44, 46, 1));
    }
    
    .similar-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 15px 35px rgba(139, 92, 246, 0.3);
      border-color: #7c3aed;
    }
    
    .similar-badge {
      animation: match-pulse 2s infinite;
    }
    
    @keyframes match-pulse {
      0% {
        box-shadow: 0 0 0 0 rgba(139, 92, 246, 0.7);
      }
      70% {
        box-shadow: 0 0 0 10px rgba(139, 92, 246, 0);
      }
      100% {
        box-shadow: 0 0 0 0 rgba(139, 92, 246, 0);
      }
    }
    
    .similar-icon {
      box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
    }
    
    .similar-indicator {
      background: linear-gradient(90deg, #8b5cf6, #7c3aed);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      animation: match-glow 1.5s ease-in-out infinite alternate;
    }
    
    @keyframes match-glow {
      0% {
        opacity: 0.8;
        filter: brightness(1);
      }
      100% {
        opacity: 1;
        filter: brightness(1.2);
      }
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
      
      .recommendations-section {
        padding: 1.5rem;
      }
      
      .recommendations-grid {
        grid-template-columns: 1fr;
      }
      
      .similar-section {
        padding: 1.5rem;
      }
      
      .similar-grid {
        grid-template-columns: 1fr;
      }
      
      .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
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
    <!-- Header with filters -->
    <div class="header">
      <div class="filter-tabs">
        <button class="filter-tab {{ $sportFilter === 'all' ? 'active' : '' }}" data-sport="all">All</button>
        @foreach($mainSports as $sport)
          <button class="filter-tab {{ $sportFilter === $sport->slug ? 'active' : '' }}" data-sport="{{ $sport->slug }}">{{ $sport->name }}</button>
        @endforeach
        @if($hasOtherSports)
          <button class="filter-tab {{ $sportFilter === 'other-sports' ? 'active' : '' }}" data-sport="other-sports">Other Sports</button>
        @endif
      </div>
      
      <div class="location-filters">
        <div class="location-filter" style="position: relative;">
          <span id="distance-selected">
            @if($distanceFilter === 'all') Jarak ↕
            @elseif($distanceFilter === 'nearby') Premium & Terdekat
            @elseif($distanceFilter === 'medium') Jarak Menengah
            @elseif($distanceFilter === 'far') Budget Friendly
            @endif
          </span>
          <div class="filter-dropdown" id="distance-dropdown">
            <div class="dropdown-item {{ $distanceFilter === 'all' ? 'selected' : '' }}" data-distance="all">Semua Jarak</div>
            <div class="dropdown-item {{ $distanceFilter === 'nearby' ? 'selected' : '' }}" data-distance="nearby">Premium & Terdekat</div>
            <div class="dropdown-item {{ $distanceFilter === 'medium' ? 'selected' : '' }}" data-distance="medium">Jarak Menengah</div>
            <div class="dropdown-item {{ $distanceFilter === 'far' ? 'selected' : '' }}" data-distance="far">Budget Friendly</div>
          </div>
        </div>
        
        <div class="location-filter" style="position: relative;">
          <span id="location-selected">
            @if($locationFilter === 'all') Lokasi ↕
            @else {{ $locationFilter }}
            @endif
          </span>
          <div class="filter-dropdown" id="location-dropdown">
            <div class="dropdown-item {{ $locationFilter === 'all' ? 'selected' : '' }}" data-location="all">Semua Lokasi</div>
            @foreach($cities as $city)
              <div class="dropdown-item {{ $locationFilter === $city ? 'selected' : '' }}" data-location="{{ $city }}">{{ $city }}</div>
            @endforeach
          </div>
        </div>
      </div>
      
      <div class="search-bar">
        <input type="text" placeholder="Search..." id="search-input" value="{{ $search }}">
      </div>
    </div>

    <!-- Filter Summary Bar -->
    <div class="filter-summary {{ count($activeFilters) > 0 ? 'active' : '' }}">
      <div class="filter-summary-content">
        <span class="filter-summary-label">Active Filters:</span>
        @foreach($activeFilters as $filter)
          <div class="filter-tag">
            <span>{{ $filter['label'] }}</span>
            <button class="remove-filter" data-filter-type="{{ $filter['type'] }}" data-filter-value="{{ $filter['value'] }}">×</button>
          </div>
        @endforeach
        @if(count($activeFilters) > 1)
          <button class="clear-all-filters" id="clear-all-filters">Remove All</button>
        @endif
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

      <!-- Recommended Venues Section - Only show when no filters are applied -->
      @if($recommendedVenues->isNotEmpty() && $sportFilter === 'all' && $locationFilter === 'all' && $distanceFilter === 'all' && !$search)
      <div class="recommendations-section" style="margin-bottom: 3rem;">
        <div class="section-header" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
          <div class="recommendation-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706); padding: 0.75rem; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
            <span style="font-size: 1.2rem;">⭐</span>
          </div>
          <div>
            <h2 style="font-size: 1.25rem; font-weight: 600; margin: 0; color: white;">Rekomendasi Untuk Anda</h2>
            <p style="color: #999; font-size: 0.9rem; margin: 0;">
              @if(Auth::user()->profile?->favorite_sport)
                Berdasarkan preferensi olahraga favorit Anda: {{ Auth::user()->profile->favoriteSport?->name }}
              @else
                Lapangan dengan rating terbaik - <a href="{{ route('profile') }}" style="color: #f59e0b;">Atur preferensi olahraga</a> untuk rekomendasi personal
              @endif
            </p>
          </div>
        </div>
        
        <div class="recommendations-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
          @foreach($recommendedVenues as $venue)
          <a href="{{ route('venue.show', $venue) }}" class="field-card-link">
            <div class="field-card recommendation-card" style="border: 2px solid #f59e0b; position: relative;">
              <div class="recommendation-badge" style="position: absolute; top: 0.75rem; right: 0.75rem; background-color: #f59e0b; color: white; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.75rem; font-weight: 600; z-index: 2;">
                REKOMENDASI
              </div>
              <div class="card-image {{ strtolower($venue->sport->name) }}">
                @if($venue->main_image)
                  @if(str_starts_with($venue->main_image, 'http'))
                    <img src="{{ $venue->main_image }}" 
                         alt="{{ $venue->name }}" 
                         style="width: 100%; height: 100%; object-fit: cover;">
                  @else
                    <img src="{{ asset('img/venues/' . $venue->main_image) }}" 
                         alt="{{ $venue->name }}" 
                         style="width: 100%; height: 100%; object-fit: cover;">
                  @endif
                @endif
                <div class="location-badge">📍 {{ $venue->location }}</div>
              </div>
              <div class="card-content">
                <h3 class="card-title">{{ $venue->name }}</h3>
                <div class="card-rating">
                  <span class="stars">⭐ {{ number_format((float)$venue->rating, 1) }}</span>
                  <span class="rating-text">({{ $venue->total_reviews }})</span>
                </div>
                <div class="card-price">
                  Mulai <span class="price-highlight">Rp {{ number_format((float)$venue->price_per_hour, 0, ',', '.') }}</span>/jam
                </div>
              </div>
            </div>
          </a>
          @endforeach
        </div>
      </div>
      @endif

      <!-- Similar Venues Section - Based on user's booking history -->
      @if($similarVenues->isNotEmpty() && $sportFilter === 'all' && $locationFilter === 'all' && $distanceFilter === 'all' && !$search)
      <div class="similar-section" style="margin-bottom: 3rem;">
        <div class="section-header" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
          <div class="similar-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); padding: 0.75rem; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
            <span style="font-size: 1.2rem;">🎯</span>
          </div>
          <div>
            <h2 style="font-size: 1.25rem; font-weight: 600; margin: 0; color: white;">Sesuai Kebiasaan Anda</h2>
            <p style="color: #999; font-size: 0.9rem; margin: 0;">Berdasarkan lapangan yang sering Anda booking</p>
          </div>
        </div>
        
        <div class="similar-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
          @foreach($similarVenues as $venue)
          <a href="{{ route('venue.show', $venue) }}" class="field-card-link">
            <div class="field-card similar-card" style="border: 2px solid #8b5cf6; position: relative;">
              <div class="similar-badge" style="position: absolute; top: 0.75rem; right: 0.75rem; background-color: #8b5cf6; color: white; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.75rem; font-weight: 600; z-index: 2;">
                COCOK UNTUK ANDA
              </div>
              <div class="card-image {{ strtolower($venue->sport->name) }}">
                @if($venue->main_image)
                  @if(str_starts_with($venue->main_image, 'http'))
                    <img src="{{ $venue->main_image }}" 
                         alt="{{ $venue->name }}" 
                         style="width: 100%; height: 100%; object-fit: cover;">
                  @else
                    <img src="{{ asset('img/venues/' . $venue->main_image) }}" 
                         alt="{{ $venue->name }}" 
                         style="width: 100%; height: 100%; object-fit: cover;">
                  @endif
                @endif
                <div class="location-badge">📍 {{ $venue->location }}</div>
              </div>
              <div class="card-content">
                <h3 class="card-title">{{ $venue->name }}</h3>
                <div class="card-rating">
                  <span class="stars">⭐ {{ number_format((float)$venue->rating, 1) }}</span>
                  <span class="rating-text">({{ $venue->total_reviews }})</span>
                  <span class="similar-indicator" style="margin-left: auto; color: #8b5cf6; font-size: 0.8rem; font-weight: 600;">
                    🎯 MATCH
                  </span>
                </div>
                <div class="card-price">
                  Mulai <span class="price-highlight">Rp {{ number_format((float)$venue->price_per_hour, 0, ',', '.') }}</span>/jam
                </div>
              </div>
            </div>
          </a>
          @endforeach
        </div>
      </div>
      @endif

      <!-- All Fields Section -->
      <div class="all-fields-section">
        <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem; color: white;">Semua Lapangan</h2>

      <!-- Fields Grid -->
      <div class="cards-grid">
        @foreach($venues as $venue)
        <a href="{{ route('venue.show', $venue) }}" class="field-card-link">
          <div class="field-card">
            <div class="card-image {{ strtolower($venue->sport->name) }}">
              @if($venue->main_image)
                @if(str_starts_with($venue->main_image, 'http'))
                  <img src="{{ $venue->main_image }}" 
                       alt="{{ $venue->name }}" 
                       style="width: 100%; height: 100%; object-fit: cover;">
                @else
                  <img src="{{ asset('img/venues/' . $venue->main_image) }}" 
                       alt="{{ $venue->name }}" 
                       style="width: 100%; height: 100%; object-fit: cover;">
                @endif
              @endif
              <div class="location-badge">📍 {{ $venue->location }}</div>
            </div>
            <div class="card-content">
              <h3 class="card-title">{{ $venue->name }}</h3>
              <div class="card-rating">
                <span class="stars">⭐ {{ number_format((float)$venue->rating, 1) }}</span>
                <span class="rating-text">({{ $venue->total_reviews }})</span>
              </div>
              <div class="card-price">
                Mulai <span class="price-highlight">Rp {{ number_format((float)$venue->price_per_hour, 0, ',', '.') }}</span>/jam
              </div>
            </div>
          </div>
        </a>
        @endforeach
      </div>
      </div> <!-- End all-fields-section -->
    </div>
  </div>

  <script>
    // Filter functionality
    document.addEventListener('DOMContentLoaded', function() {
      // Sport filter tabs
      const sportTabs = document.querySelectorAll('.filter-tab');
      sportTabs.forEach(tab => {
        tab.addEventListener('click', function() {
          const sport = this.getAttribute('data-sport');
          updateFilters('sport', sport);
        });
      });

      // Distance dropdown
      const distanceFilter = document.querySelector('#distance-dropdown').parentElement;
      const distanceDropdown = document.querySelector('#distance-dropdown');
      
      distanceFilter.addEventListener('click', function(e) {
        e.stopPropagation();
        distanceDropdown.classList.toggle('show');
        document.querySelector('#location-dropdown').classList.remove('show');
      });

      const distanceItems = document.querySelectorAll('#distance-dropdown .dropdown-item');
      distanceItems.forEach(item => {
        item.addEventListener('click', function() {
          const distance = this.getAttribute('data-distance');
          const text = this.textContent;
          document.querySelector('#distance-selected').textContent = text;
          distanceDropdown.classList.remove('show');
          updateFilters('distance', distance);
        });
      });

      // Location dropdown
      const locationFilter = document.querySelector('#location-dropdown').parentElement;
      const locationDropdown = document.querySelector('#location-dropdown');
      
      locationFilter.addEventListener('click', function(e) {
        e.stopPropagation();
        locationDropdown.classList.toggle('show');
        document.querySelector('#distance-dropdown').classList.remove('show');
      });

      const locationItems = document.querySelectorAll('#location-dropdown .dropdown-item');
      locationItems.forEach(item => {
        item.addEventListener('click', function() {
          const location = this.getAttribute('data-location');
          const text = this.textContent;
          document.querySelector('#location-selected').textContent = text;
          locationDropdown.classList.remove('show');
          updateFilters('location', location);
        });
      });

      // Search functionality
      const searchInput = document.querySelector('#search-input');
      let searchTimeout;
      
      searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
          updateFilters('search', this.value);
        }, 500); // Debounce search
      });

      // Close dropdowns when clicking outside
      document.addEventListener('click', function() {
        document.querySelectorAll('.filter-dropdown').forEach(dropdown => {
          dropdown.classList.remove('show');
        });
      });

      // Filter summary functionality
      const removeFilterButtons = document.querySelectorAll('.remove-filter');
      removeFilterButtons.forEach(button => {
        button.addEventListener('click', function() {
          const filterType = this.getAttribute('data-filter-type');
          const filterValue = this.getAttribute('data-filter-value');
          removeFilter(filterType);
        });
      });

      const clearAllButton = document.getElementById('clear-all-filters');
      if (clearAllButton) {
        clearAllButton.addEventListener('click', function() {
          clearAllFilters();
        });
      }

      // Remove filter function
      function removeFilter(filterType) {
        const url = new URL(window.location);
        url.searchParams.delete(filterType);
        
        // Add loading state
        document.querySelector('.cards-grid').style.opacity = '0.5';
        
        // Navigate to new URL
        window.location.href = url.toString();
      }

      // Clear all filters function
      function clearAllFilters() {
        const url = new URL(window.location);
        url.searchParams.delete('sport');
        url.searchParams.delete('location');
        url.searchParams.delete('distance');
        url.searchParams.delete('search');
        
        // Add loading state
        document.querySelector('.cards-grid').style.opacity = '0.5';
        
        // Navigate to new URL
        window.location.href = url.toString();
      }

      // Update filters function
      function updateFilters(filterType, value) {
        const url = new URL(window.location);
        
        if (value === 'all' || value === '') {
          url.searchParams.delete(filterType);
        } else {
          url.searchParams.set(filterType, value);
        }
        
        // Add loading state
        document.querySelector('.cards-grid').style.opacity = '0.5';
        
        // Navigate to new URL
        window.location.href = url.toString();
      }

      // Smooth loading animation
      const cards = document.querySelectorAll('.field-card');
      cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
          card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
          card.style.opacity = '1';
          card.style.transform = 'translateY(0)';
        }, index * 100);
      });
    });
  </script>
</body>
</html>
