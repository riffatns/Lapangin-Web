<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Komunitas - Lapangin</title>
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
    
    /* Sidebar - Same as dashboard */
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
      padding: 1rem 2rem;
      border-bottom: 1px solid #404040;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    
    .header-left h1 {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 0.25rem;
    }
    
    .header-left p {
      color: #999;
      font-size: 0.9rem;
    }
    
    .create-community-btn {
      background: linear-gradient(135deg, #f59e0b, #d97706);
      color: white;
      padding: 0.75rem 1.5rem;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }
    
    .create-community-btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }
    
    /* Content */
    .content {
      padding: 2rem;
    }
    
    /* Stats Cards */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1rem;
      margin-bottom: 2rem;
    }
    
    .stat-card {
      background-color: #2c2c2e;
      padding: 1.5rem;
      border-radius: 12px;
      text-align: center;
      border: 1px solid #404040;
    }
    
    .stat-number {
      font-size: 2rem;
      font-weight: 700;
      color: #f59e0b;
      margin-bottom: 0.5rem;
    }
    
    .stat-label {
      color: #999;
      font-size: 0.9rem;
    }
    
    /* Tab Navigation */
    .tab-navigation {
      display: flex;
      background-color: #2c2c2e;
      border-radius: 12px;
      padding: 0.5rem;
      margin-bottom: 2rem;
      border: 1px solid #404040;
    }
    
    .tab-btn {
      flex: 1;
      padding: 0.75rem 1rem;
      background: none;
      border: none;
      color: #999;
      font-weight: 500;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.2s ease;
    }
    
    .tab-btn.active {
      background-color: #f59e0b;
      color: white;
    }
    
    .tab-btn:hover:not(.active) {
      color: white;
      background-color: #404040;
    }
    
    /* Community Cards */
    .communities-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 1.5rem;
    }
    
    .community-card {
      background-color: #2c2c2e;
      border-radius: 12px;
      overflow: hidden;
      border: 1px solid #404040;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .community-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }
    
    .community-header {
      background: linear-gradient(135deg, #3b82f6, #1d4ed8);
      padding: 1.5rem;
      position: relative;
      overflow: hidden;
    }
    
    .community-header.badminton {
      background: linear-gradient(135deg, #10b981, #059669);
    }
    
    .community-header.futsal {
      background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    }
    
    .community-header.tennis {
      background: linear-gradient(135deg, #ef4444, #dc2626);
    }
    
    .community-header.basketball {
      background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    }
    
    .community-sport-icon {
      position: absolute;
      right: 1rem;
      top: 1rem;
      font-size: 2rem;
      opacity: 0.3;
    }
    
    .community-name {
      font-size: 1.25rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
    }
    
    .community-description {
      font-size: 0.9rem;
      opacity: 0.9;
      margin-bottom: 1rem;
    }
    
    .community-stats {
      display: flex;
      gap: 1rem;
    }
    
    .community-stat {
      font-size: 0.8rem;
      opacity: 0.8;
    }
    
    .community-content {
      padding: 1.5rem;
    }
    
    .community-features {
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
      margin-bottom: 1.5rem;
    }
    
    .feature-tag {
      background-color: #404040;
      color: #999;
      padding: 0.25rem 0.75rem;
      border-radius: 12px;
      font-size: 0.8rem;
    }
    
    .feature-tag.highlight {
      background-color: #f59e0b;
      color: white;
    }
    
    .community-actions {
      display: flex;
      gap: 0.75rem;
    }
    
    .action-btn {
      flex: 1;
      padding: 0.75rem;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease;
      text-decoration: none;
      text-align: center;
      font-size: 0.9rem;
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
    
    /* User Ranking Section */
    .ranking-section {
      background-color: #2c2c2e;
      border-radius: 12px;
      padding: 1.5rem;
      margin-bottom: 2rem;
      border: 1px solid #404040;
    }
    
    .ranking-header {
      display: flex;
      justify-content: between;
      align-items: center;
      margin-bottom: 1.5rem;
    }
    
    .ranking-title {
      font-size: 1.25rem;
      font-weight: 600;
    }
    
    .user-rank {
      display: flex;
      align-items: center;
      padding: 1rem;
      background-color: #1a1a1a;
      border-radius: 8px;
      margin-bottom: 1rem;
      border: 1px solid #404040;
    }
    
    .rank-number {
      background-color: #f59e0b;
      color: white;
      width: 30px;
      height: 30px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      margin-right: 1rem;
    }
    
    .user-info {
      flex: 1;
    }
    
    .user-name {
      font-weight: 600;
      margin-bottom: 0.25rem;
    }
    
    .user-level {
      color: #999;
      font-size: 0.8rem;
    }
    
    .user-points {
      color: #f59e0b;
      font-weight: 600;
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
      
      .header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
      }
      
      .stats-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      
      .communities-grid {
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
      <a href="{{ route('komunitas') }}" class="nav-item active">
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
      <div class="header-left">
        <h1>Komunitas Olahraga</h1>
        <p>Bergabung dengan komunitas, main bareng, dan raih prestasi!</p>
      </div>
      <a href="#" class="create-community-btn">
        <span>➕</span>
        Buat Komunitas
      </a>
    </div>

    <!-- Content -->
    <div class="content">
      <!-- Stats Overview -->
      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-number">8</div>
          <div class="stat-label">Komunitas Diikuti</div>
        </div>
        <div class="stat-card">
          <div class="stat-number">1,250</div>
          <div class="stat-label">Total Poin</div>
        </div>
        <div class="stat-card">
          <div class="stat-number">42</div>
          <div class="stat-label">Match Dimainkan</div>
        </div>
        <div class="stat-card">
          <div class="stat-number">#15</div>
          <div class="stat-label">Peringkat Global</div>
        </div>
      </div>

      <!-- User Ranking Section -->
      <div class="ranking-section">
        <div class="ranking-header">
          <h2 class="ranking-title">🏆 Top Players This Week</h2>
        </div>
        <div class="user-rank">
          <div class="rank-number">1</div>
          <div class="user-info">
            <div class="user-name">Ahmad Rivaldy</div>
            <div class="user-level">🏸 Badminton Master</div>
          </div>
          <div class="user-points">2,850 pts</div>
        </div>
        <div class="user-rank">
          <div class="rank-number">2</div>
          <div class="user-info">
            <div class="user-name">Sari Indah</div>
            <div class="user-level">⚽ Futsal Champion</div>
          </div>
          <div class="user-points">2,720 pts</div>
        </div>
        <div class="user-rank">
          <div class="rank-number">3</div>
          <div class="user-info">
            <div class="user-name">{{ Auth::user()->name }}</div>
            <div class="user-level">🎾 Tennis Enthusiast</div>
          </div>
          <div class="user-points">2,650 pts</div>
        </div>
      </div>

      <!-- Tab Navigation -->
      <div class="tab-navigation">
        <button class="tab-btn active">Semua Komunitas</button>
        <button class="tab-btn">Komunitas Saya</button>
        <button class="tab-btn">Main Bareng</button>
        <button class="tab-btn">Tournament</button>
      </div>

      <!-- Communities Grid -->
      <div class="communities-grid">
        <!-- Badminton Community -->
        <div class="community-card">
          <div class="community-header badminton">
            <div class="community-sport-icon">🏸</div>
            <div class="community-name">Badminton Club Bandung</div>
            <div class="community-description">Komunitas pecinta badminton untuk semua level, dari pemula hingga advanced!</div>
            <div class="community-stats">
              <span class="community-stat">👥 1,245 members</span>
              <span class="community-stat">🏆 Level Premium</span>
            </div>
          </div>
          <div class="community-content">
            <div class="community-features">
              <span class="feature-tag highlight">Main Bareng</span>
              <span class="feature-tag">Tournament</span>
              <span class="feature-tag">Coaching</span>
              <span class="feature-tag">Weekly Match</span>
            </div>
            <div class="community-actions">
              <a href="#" class="action-btn btn-primary">Gabung</a>
              <a href="#" class="action-btn btn-secondary">Detail</a>
            </div>
          </div>
        </div>

        <!-- Futsal Community -->
        <div class="community-card">
          <div class="community-header futsal">
            <div class="community-sport-icon">⚽</div>
            <div class="community-name">Futsal Warriors</div>
            <div class="community-description">Tim futsal kompetitif dengan jadwal latihan rutin dan turnamen berkala.</div>
            <div class="community-stats">
              <span class="community-stat">👥 892 members</span>
              <span class="community-stat">🏆 Level Gold</span>
            </div>
          </div>
          <div class="community-content">
            <div class="community-features">
              <span class="feature-tag highlight">Tournament</span>
              <span class="feature-tag">Team Practice</span>
              <span class="feature-tag">Strategy</span>
            </div>
            <div class="community-actions">
              <a href="#" class="action-btn btn-primary">Gabung</a>
              <a href="#" class="action-btn btn-secondary">Detail</a>
            </div>
          </div>
        </div>

        <!-- Tennis Community -->
        <div class="community-card">
          <div class="community-header tennis">
            <div class="community-sport-icon">🎾</div>
            <div class="community-name">Tennis Academy</div>
            <div class="community-description">Belajar teknik tennis profesional dengan coach berpengalaman.</div>
            <div class="community-stats">
              <span class="community-stat">👥 567 members</span>
              <span class="community-stat">🏆 Level Silver</span>
            </div>
          </div>
          <div class="community-content">
            <div class="community-features">
              <span class="feature-tag">Coaching</span>
              <span class="feature-tag highlight">Private Lesson</span>
              <span class="feature-tag">Doubles Match</span>
            </div>
            <div class="community-actions">
              <a href="#" class="action-btn btn-primary">Gabung</a>
              <a href="#" class="action-btn btn-secondary">Detail</a>
            </div>
          </div>
        </div>

        <!-- Basketball Community -->
        <div class="community-card">
          <div class="community-header basketball">
            <div class="community-sport-icon">🏀</div>
            <div class="community-name">Streetball Legends</div>
            <div class="community-description">Komunitas basket streetball dengan culture hip-hop dan skill tinggi.</div>
            <div class="community-stats">
              <span class="community-stat">👥 734 members</span>
              <span class="community-stat">🏆 Level Platinum</span>
            </div>
          </div>
          <div class="community-content">
            <div class="community-features">
              <span class="feature-tag">Street Game</span>
              <span class="feature-tag highlight">3v3 Battle</span>
              <span class="feature-tag">Skills Challenge</span>
            </div>
            <div class="community-actions">
              <a href="#" class="action-btn btn-primary">Gabung</a>
              <a href="#" class="action-btn btn-secondary">Detail</a>
            </div>
          </div>
        </div>

        <!-- Multi Sport Community -->
        <div class="community-card">
          <div class="community-header">
            <div class="community-sport-icon">🏅</div>
            <div class="community-name">Multi Sports Hub</div>
            <div class="community-description">Komunitas untuk semua jenis olahraga, dari voli, ping pong, hingga martial arts.</div>
            <div class="community-stats">
              <span class="community-stat">👥 2,156 members</span>
              <span class="community-stat">🏆 Level Diamond</span>
            </div>
          </div>
          <div class="community-content">
            <div class="community-features">
              <span class="feature-tag">Multi Sport</span>
              <span class="feature-tag highlight">Cross Training</span>
              <span class="feature-tag">Friendly Match</span>
              <span class="feature-tag">Events</span>
            </div>
            <div class="community-actions">
              <a href="#" class="action-btn btn-primary">Gabung</a>
              <a href="#" class="action-btn btn-secondary">Detail</a>
            </div>
          </div>
        </div>

        <!-- Beginner Community -->
        <div class="community-card">
          <div class="community-header badminton">
            <div class="community-sport-icon">🌟</div>
            <div class="community-name">Pemula Semangat</div>
            <div class="community-description">Khusus untuk pemula yang ingin belajar berbagai olahraga dengan santai dan fun!</div>
            <div class="community-stats">
              <span class="community-stat">👥 1,890 members</span>
              <span class="community-stat">🏆 Level Bronze</span>
            </div>
          </div>
          <div class="community-content">
            <div class="community-features">
              <span class="feature-tag highlight">Beginner Friendly</span>
              <span class="feature-tag">Basic Training</span>
              <span class="feature-tag">Fun Games</span>
            </div>
            <div class="community-actions">
              <a href="#" class="action-btn btn-primary">Gabung</a>
              <a href="#" class="action-btn btn-secondary">Detail</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>