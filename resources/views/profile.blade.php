<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Profile - Lapangin</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    html, body {
      font-family: 'Inter', sans-serif !important;
      background-color: #1a1a1a !important;
      color: white !important;
      height: 100vh;
      width: 100vw;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      margin: 0;
      padding: 0;
    }
    
    /* Sidebar */
    .sidebar {
      width: 250px;
      min-width: 250px;
      background-color: #2c2c2e !important;
      padding: 2rem 0;
      display: flex;
      flex-direction: column;
      border-right: 1px solid #404040;
      height: 100vh;
      position: sticky;
      top: 0;
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
      color: #999 !important;
      font-weight: 500;
    }
    
    .nav-item:hover {
      background-color: #404040 !important;
      color: white !important;
    }
    
    .nav-item.active {
      background-color: #f59e0b !important;
      color: white !important;
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
      color: #999 !important;
      font-weight: 500;
      font-family: 'Inter', sans-serif;
      font-size: 1rem;
      border: none;
      background: none;
      width: 100%;
      text-align: left;
    }
    
    .user-item:hover {
      background-color: #404040 !important;
      color: white !important;
    }
    
    .user-item.active {
      background-color: #f59e0b !important;
      color: white !important;
    }
    
    .user-item .icon {
      margin-right: 0.75rem;
      font-size: 1.1rem;
    }
    
    /* Main Content */
    .main-content {
      flex: 1;
      background-color: #1a1a1a !important;
      overflow-y: auto;
      overflow-x: hidden;
      min-width: 0;
      width: calc(100vw - 250px);
      height: 100vh;
    }
    
    .header {
      background-color: #2c2c2e !important;
      padding: 1.5rem 2rem;
      border-bottom: 1px solid #404040;
    }
    
    .header h1 {
      font-size: 1.75rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
      color: white !important;
    }
    
    .header p {
      color: #999 !important;
      font-size: 0.9rem;
    }
    
    /* Content */
    .content {
      padding: 2rem;
      max-width: none;
      width: 100%;
      background-color: #1a1a1a !important;
      box-sizing: border-box;
    }
    
    /* Profile Header */
    .profile-header {
      background-color: #2c2c2e !important;
      border-radius: 16px;
      padding: 2rem;
      margin-bottom: 2rem;
      border: 1px solid #404040;
      text-align: center;
      position: relative;
      width: 100%;
      box-sizing: border-box;
    }
    
    .avatar-section {
      margin-bottom: 1.5rem;
    }
    
    .avatar {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      background: linear-gradient(135deg, #f59e0b, #d97706) !important;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 3rem;
      font-weight: bold;
      margin: 0 auto 1rem;
      position: relative;
      cursor: pointer;
      transition: all 0.2s ease;
      color: white !important;
    }
    
    .avatar:hover {
      transform: scale(1.05);
    }
    
    .avatar-upload {
      position: absolute;
      bottom: 0;
      right: 0;
      background-color: #3b82f6 !important;
      color: white !important;
      border: none;
      border-radius: 50%;
      width: 36px;
      height: 36px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      font-size: 1rem;
      transition: all 0.2s ease;
    }
    
    .avatar-upload:hover {
      background-color: #2563eb !important;
    }
    
    .profile-name {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
      color: white !important;
    }
    
    .profile-email {
      color: #999 !important;
      margin-bottom: 0.5rem;
    }
    
    .verification-status {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.5rem 1rem;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 500;
    }
    
    .verification-status.verified {
      background-color: rgba(34, 197, 94, 0.2) !important;
      color: #22c55e !important;
      border: 1px solid rgba(34, 197, 94, 0.3);
    }
    
    .verification-status.unverified {
      background-color: rgba(239, 68, 68, 0.2) !important;
      color: #ef4444 !important;
      border: 1px solid rgba(239, 68, 68, 0.3);
    }
    
    /* Tabs */
    .profile-tabs {
      display: flex;
      background-color: #2c2c2e !important;
      border-radius: 12px;
      padding: 0.5rem;
      margin-bottom: 2rem;
      border: 1px solid #404040;
      width: 100%;
      box-sizing: border-box;
    }
    
    .tab-btn {
      flex: 1;
      padding: 0.75rem 1rem;
      background: none;
      border: none;
      color: #999 !important;
      font-weight: 500;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.2s ease;
    }
    
    .tab-btn.active {
      background-color: #f59e0b !important;
      color: white !important;
    }
    
    .tab-btn:hover:not(.active) {
      color: white !important;
      background-color: #404040 !important;
    }
    
    /* Tab Content */
    .tab-content {
      display: none;
    }
    
    .tab-content.active {
      display: block;
    }
    
    /* Form Styles */
    .form-section {
      background: linear-gradient(145deg, #2c2c2e, #2a2a2c) !important;
      border-radius: 16px;
      padding: 2rem;
      margin-bottom: 2rem;
      border: 1px solid #404040;
      width: 100%;
      box-sizing: border-box;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
      transition: all 0.3s ease;
    }
    
    .form-section:hover {
      border-color: #f59e0b;
      box-shadow: 0 6px 20px rgba(245, 158, 11, 0.1);
    }
    
    .form-section h3 {
      font-size: 1.3rem;
      font-weight: 700;
      margin-bottom: 1.5rem;
      color: #f59e0b !important;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      padding-bottom: 0.5rem;
      border-bottom: 2px solid #404040;
    }
    
    /* Alert Styles */
    .alert {
      padding: 1rem 1.5rem;
      border-radius: 12px;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      position: relative;
      animation: slideIn 0.5s ease-out;
    }
    
    .alert-success {
      background: linear-gradient(145deg, #059669, #047857);
      border: 1px solid #10b981;
      color: white;
      box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
    }
    
    .alert-icon {
      font-size: 1.2rem;
      line-height: 1;
    }
    
    .alert-message {
      flex: 1;
      font-weight: 500;
    }
    
    .alert-close {
      background: none;
      border: none;
      color: white;
      font-size: 1.5rem;
      cursor: pointer;
      padding: 0;
      width: 24px;
      height: 24px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      transition: background-color 0.2s ease;
    }
    
    .alert-close:hover {
      background-color: rgba(255, 255, 255, 0.1);
    }
    
    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    @keyframes slideOut {
      from {
        opacity: 1;
        transform: translateY(0);
      }
      to {
        opacity: 0;
        transform: translateY(-20px);
      }
    }
    
    .form-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 1.5rem;
      width: 100%;
      box-sizing: border-box;
    }
    
    .form-group {
      margin-bottom: 1.5rem;
    }
    
    .form-group label {
      display: block;
      margin-bottom: 0.75rem;
      font-weight: 600;
      color: #e5e5e5 !important;
      font-size: 0.95rem;
    }
    
    .form-group input,
    .form-group select,
    .form-group textarea {
      width: 100%;
      padding: 1rem;
      background: linear-gradient(145deg, #1a1a1a, #1e1e1e) !important;
      border: 2px solid #404040;
      border-radius: 12px;
      color: white !important;
      font-size: 0.95rem;
      transition: all 0.3s ease;
      box-sizing: border-box;
      font-family: 'Inter', sans-serif;
    }
    
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
      outline: none;
      border-color: #f59e0b !important;
      box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
      transform: translateY(-1px);
    }
    
    .form-group input:hover,
    .form-group select:hover,
    .form-group textarea:hover {
      border-color: #525252;
    }
    
    .form-group textarea {
      min-height: 120px;
      resize: vertical;
      line-height: 1.5;
    }
    
    .form-group select {
      cursor: pointer;
    }
    
    .form-group select option {
      background-color: #1a1a1a;
      color: white;
      padding: 0.5rem;
    }
    
    /* Buttons */
    .btn {
      padding: 1rem 2rem;
      border: none;
      border-radius: 12px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      font-size: 0.95rem;
      font-family: 'Inter', sans-serif;
      text-transform: none;
      letter-spacing: 0.5px;
    }
    
    .btn-primary {
      background: linear-gradient(135deg, #f59e0b, #d97706) !important;
      color: white !important;
      box-shadow: 0 4px 15px rgba(245, 158, 11, 0.2);
    }
    
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);
      background: linear-gradient(135deg, #d97706, #b45309) !important;
    }
    
    .btn-secondary {
      background: linear-gradient(145deg, #404040, #525252) !important;
      color: white !important;
      box-shadow: 0 4px 15px rgba(64, 64, 64, 0.2);
    }
    
    .btn-secondary:hover {
      background: linear-gradient(145deg, #525252, #6b7280) !important;
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(82, 82, 82, 0.3);
    }
    
    .btn-danger {
      background-color: #ef4444 !important;
      color: white !important;
    }
    
    .btn-danger:hover {
      background-color: #dc2626 !important;
    }
    
    .btn-success {
      background-color: #22c55e !important;
      color: white !important;
    }
    
    .btn-success:hover {
      background-color: #16a34a !important;
    }
    
    /* Form Actions */
    .form-actions {
      display: flex;
      gap: 1.5rem;
      justify-content: flex-end;
      margin-top: 2rem;
      padding-top: 1.5rem;
      border-top: 2px solid #404040;
    }
    
    @media (max-width: 768px) {
      .form-actions {
        flex-direction: column;
        gap: 1rem;
      }
      
      .form-actions .btn {
        width: 100%;
      }
    }
    
    /* Stats Cards */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1.5rem;
      margin-bottom: 2rem;
      width: 100%;
      box-sizing: border-box;
    }
    
    .stat-card {
      background-color: #2c2c2e !important;
      padding: 1.5rem;
      border-radius: 12px;
      text-align: center;
      border: 1px solid #404040;
      transition: transform 0.2s ease;
    }
    
    .stat-card:hover {
      transform: translateY(-2px);
    }
    
    .stat-number {
      font-size: 2rem;
      font-weight: 700;
      color: #f59e0b !important;
      margin-bottom: 0.5rem;
    }
    
    .stat-label {
      color: #999 !important;
      font-size: 0.9rem;
    }
    
    /* Security Section */
    .security-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 1rem;
      background-color: #1a1a1a !important;
      border-radius: 8px;
      margin-bottom: 1rem;
      border: 1px solid #404040;
    }
    
    .security-info {
      flex: 1;
    }
    
    .security-title {
      font-weight: 600;
      margin-bottom: 0.25rem;
      color: white !important;
    }
    
    .security-description {
      color: #999 !important;
      font-size: 0.8rem;
    }
    
    /* Activity Log */
    .activity-item {
      display: flex;
      align-items: center;
      padding: 1rem;
      background-color: #1a1a1a !important;
      border-radius: 8px;
      margin-bottom: 0.75rem;
      border: 1px solid #404040;
    }
    
    .activity-icon {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background-color: #f59e0b !important;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 1rem;
      font-size: 1.1rem;
    }
    
    .activity-content {
      flex: 1;
    }
    
    .activity-title {
      font-weight: 600;
      margin-bottom: 0.25rem;
      color: white !important;
    }
    
    .activity-time {
      color: #999 !important;
      font-size: 0.8rem;
    }
    
    /* Force Dark Theme */
    button {
      color: inherit !important;
    }
    
    /* App Container */
    .app-container {
      display: flex;
      width: 100vw;
      min-height: 100vh;
      background-color: #1a1a1a !important;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
      .sidebar {
        width: 70px;
        min-width: 70px;
      }
      
      .main-content {
        width: calc(100vw - 70px);
      }
      
      .nav-item span:not(.icon),
      .user-item span:not(.icon) {
        display: none;
      }
      
      .content {
        padding: 1rem;
      }
      
      .profile-header {
        padding: 1.5rem;
      }
      
      .avatar {
        width: 100px;
        height: 100px;
        font-size: 2.5rem;
      }
      
      .form-grid {
        grid-template-columns: 1fr;
      }
      
      .stats-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      
      .profile-tabs {
        flex-direction: row;
        overflow-x: auto;
      }
      
      .tab-btn {
        text-align: center;
        white-space: nowrap;
        min-width: 120px;
      }
    }
    
    @media (max-width: 1200px) {
      .content {
        padding: 1.5rem;
      }
      
      .stats-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      
      .main-content {
        width: calc(100vw - 250px);
      }
    }
    
    @media (max-width: 1024px) {
      .content {
        padding: 1rem;
      }
      
      .profile-header {
        padding: 1.5rem;
      }
      
      .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
      }
      
      .form-grid {
        grid-template-columns: 1fr;
      }
    }
    
    @media (min-width: 1400px) {
      .content {
        max-width: 1400px;
        margin: 0 auto;
      }
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
      .form-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
      }
      
      .form-section {
        padding: 1.5rem;
        margin-bottom: 1.5rem;
      }
      
      .form-section h3 {
        font-size: 1.1rem;
      }
      
      .sidebar {
        width: 200px;
        min-width: 200px;
      }
    }
    
    /* Enhanced Form Animations */
    .form-group {
      position: relative;
    }
    
    .form-group input:not(:placeholder-shown) + label,
    .form-group select:not([value=""]) + label,
    .form-group textarea:not(:placeholder-shown) + label {
      transform: translateY(-8px);
      font-size: 0.85rem;
      color: #f59e0b !important;
    }
    
    /* Placeholder Enhancements */
    .form-group input::placeholder,
    .form-group textarea::placeholder {
      color: #666;
      opacity: 0.8;
    }
    
    /* Focus Effects */
    .form-group.focused {
      transform: scale(1.02);
    }
    
    .form-group.focused label {
      color: #f59e0b !important;
    }
    
    /* Loading State */
    .btn.loading {
      opacity: 0.7;
      cursor: not-allowed;
      position: relative;
    }
    
    .btn.loading::after {
      content: '';
      position: absolute;
      width: 16px;
      height: 16px;
      margin: auto;
      border: 2px solid transparent;
      border-top-color: currentColor;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  </style>
</head>
<body style="background-color: #1a1a1a !important; color: white !important;">
  <div class="app-container">
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
      <a href="{{ route('notifikasi') }}" class="user-item">
        <span class="icon">🔔</span>
        <span>Notification</span>
      </a>
      <a href="{{ route('profile') }}" class="user-item active">
        <span class="icon">👤</span>
        <span>Profile</span>
      </a>
      <form action="{{ url('/logout') }}" method="POST" style="display: inline; width: 100%;">
        @csrf
        <button type="submit" class="user-item" style="background: none; border: none; width: 100%; text-align: left; color: #999 !important;">
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
      <h1>Profile</h1>
      <p>Kelola informasi personal dan pengaturan akun Anda</p>
    </div>

    <!-- Content -->
    <div class="content">
      <!-- Profile Header -->
      <div class="profile-header">
        <div class="avatar-section">
          <div class="avatar" onclick="uploadAvatar()">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            <button class="avatar-upload" title="Ubah foto profil">
              📷
            </button>
          </div>
          <div class="profile-name">{{ Auth::user()->name }}</div>
          <div class="profile-email">{{ Auth::user()->email }}</div>
          <div class="verification-status {{ Auth::user()->email_verified_at ? 'verified' : 'unverified' }}">
            <span>{{ Auth::user()->email_verified_at ? '✓' : '⚠️' }}</span>
            {{ Auth::user()->email_verified_at ? 'Email Terverifikasi' : 'Email Belum Terverifikasi' }}
          </div>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-number">{{ $totalBookings }}</div>
            <div class="stat-label">Total Booking</div>
          </div>
          <div class="stat-card">
            <div class="stat-number">{{ $totalCommunities }}</div>
            <div class="stat-label">Komunitas Diikuti</div>
          </div>
          <div class="stat-card">
            <div class="stat-number">{{ number_format($totalPoints) }}</div>
            <div class="stat-label">Total Poin</div>
          </div>
          <div class="stat-card">
            <div class="stat-number">#{{ $ranking }}</div>
            <div class="stat-label">Ranking</div>
          </div>
        </div>
      </div>

      <!-- Profile Tabs -->
      <div class="profile-tabs">
        <button class="tab-btn active" onclick="switchTab('personal')">Personal Info</button>
        <button class="tab-btn" onclick="switchTab('security')">Keamanan</button>
        <button class="tab-btn" onclick="switchTab('preferences')">Preferensi</button>
        <button class="tab-btn" onclick="switchTab('activity')">Aktivitas</button>
      </div>

      <!-- Personal Info Tab -->
      <div class="tab-content active" id="personal">
        <!-- Success Message -->
        @if(session('success'))
          <div class="alert alert-success" id="successAlert">
            <span class="alert-icon">✅</span>
            <span class="alert-message">{{ session('success') }}</span>
            <button class="alert-close" onclick="closeAlert('successAlert')">&times;</button>
          </div>
        @endif

        <form id="profileForm" method="POST" action="{{ route('profile.update') }}">
          @csrf
          @method('PUT')
          <div class="form-section">
            <h3>📝 Informasi Dasar</h3>
            <div class="form-grid">
              <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" required>
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" required>
              </div>
              <div class="form-group">
                <label for="phone">Nomor Telepon</label>
                <input type="tel" id="phone" name="phone" value="{{ Auth::user()->phone }}" placeholder="+62 812-3456-7890">
              </div>
              <div class="form-group">
                <label for="birthdate">Tanggal Lahir</label>
                <input type="date" id="birthdate" name="birthdate" value="{{ $profile?->birthdate }}">
              </div>
            </div>
          </div>

          <div class="form-section">
            <h3>📍 Alamat</h3>
            <div class="form-grid">
              <div class="form-group">
                <label for="city">Kota</label>
                <select id="city" name="city">
                  <option value="">Pilih Kota</option>
                  <option value="bandung" {{ $profile?->city == 'bandung' ? 'selected' : '' }}>Bandung</option>
                  <option value="jakarta" {{ $profile?->city == 'jakarta' ? 'selected' : '' }}>Jakarta</option>
                  <option value="surabaya" {{ $profile?->city == 'surabaya' ? 'selected' : '' }}>Surabaya</option>
                  <option value="medan" {{ $profile?->city == 'medan' ? 'selected' : '' }}>Medan</option>
                  <option value="yogyakarta" {{ $profile?->city == 'yogyakarta' ? 'selected' : '' }}>Yogyakarta</option>
                </select>
              </div>
              <div class="form-group">
                <label for="district">Kecamatan</label>
                <input type="text" id="district" name="district" value="{{ $profile?->district }}" placeholder="Contoh: Coblong">
              </div>
              <div class="form-group" style="grid-column: 1 / -1;">
                <label for="address">Alamat Lengkap</label>
                <textarea id="address" name="address" placeholder="Masukkan alamat lengkap Anda">{{ $profile?->address }}</textarea>
              </div>
            </div>
          </div>

          <div class="form-section">
            <h3>🏃‍♂️ Preferensi Olahraga</h3>
            <div class="form-grid">
              <div class="form-group">
                <label for="favorite_sport">Olahraga Favorit</label>
                <select id="favorite_sport" name="favorite_sport">
                  <option value="">Pilih Olahraga</option>
                  <option value="badminton" {{ $profile?->favorite_sport == 'badminton' ? 'selected' : '' }}>Badminton</option>
                  <option value="futsal" {{ $profile?->favorite_sport == 'futsal' ? 'selected' : '' }}>Futsal</option>
                  <option value="tennis" {{ $profile?->favorite_sport == 'tennis' ? 'selected' : '' }}>Tennis</option>
                  <option value="basketball" {{ $profile?->favorite_sport == 'basketball' ? 'selected' : '' }}>Basketball</option>
                  <option value="volleyball" {{ $profile?->favorite_sport == 'volleyball' ? 'selected' : '' }}>Volleyball</option>
                </select>
              </div>
              <div class="form-group">
                <label for="skill_level">Level Skill</label>
                <select id="skill_level" name="skill_level">
                  <option value="">Pilih Level</option>
                  <option value="beginner" {{ $profile?->skill_level == 'beginner' ? 'selected' : '' }}>Pemula</option>
                  <option value="intermediate" {{ $profile?->skill_level == 'intermediate' ? 'selected' : '' }}>Menengah</option>
                  <option value="advanced" {{ $profile?->skill_level == 'advanced' ? 'selected' : '' }}>Mahir</option>
                  <option value="expert" {{ $profile?->skill_level == 'expert' ? 'selected' : '' }}>Expert</option>
                </select>
              </div>
              <div class="form-group" style="grid-column: 1 / -1;">
                <label for="bio">Bio</label>
                <textarea id="bio" name="bio" placeholder="Ceritakan tentang diri Anda dan passion olahraga Anda">{{ $profile?->bio }}</textarea>
              </div>
            </div>
          </div>

          <div class="form-actions">
            <button type="button" class="btn btn-secondary" onclick="resetForm()">
              <span>🔄</span>
              Reset
            </button>
            <button type="submit" class="btn btn-primary">
              <span>💾</span>
              Simpan Perubahan
            </button>
          </div>
        </form>
      </div>

      <!-- Security Tab -->
      <div class="tab-content" id="security">
        <div class="form-section">
          <h3>🔐 Keamanan Akun</h3>
          
          <div class="security-item">
            <div class="security-info">
              <div class="security-title">Verifikasi Email</div>
              <div class="security-description">
                {{ Auth::user()->email_verified_at ? 'Email Anda sudah terverifikasi' : 'Verifikasi email untuk keamanan akun' }}
              </div>
            </div>
            @if(!Auth::user()->email_verified_at)
              <form method="POST" action="{{ route('verification.send') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-primary" onclick="sendVerificationEmail(); return false;">
                  <span>📧</span>
                  Kirim Verifikasi
                </button>
              </form>
            @else
              <span class="verification-status verified">
                <span>✓</span>
                Terverifikasi
              </span>
            @endif
          </div>

          <div class="security-item">
            <div class="security-info">
              <div class="security-title">Ubah Password</div>
              <div class="security-description">Update password untuk keamanan yang lebih baik</div>
            </div>
            <button class="btn btn-secondary" onclick="showPasswordForm()">
              <span>🔑</span>
              Ubah Password
            </button>
          </div>

          <div class="security-item">
            <div class="security-info">
              <div class="security-title">Two-Factor Authentication</div>
              <div class="security-description">Tambahkan lapisan keamanan ekstra untuk akun Anda</div>
            </div>
            <button class="btn btn-secondary" onclick="setup2FA()">
              <span>🛡️</span>
              Setup 2FA
            </button>
          </div>

          <div class="security-item">
            <div class="security-info">
              <div class="security-title">Download Data</div>
              <div class="security-description">Download semua data akun Anda</div>
            </div>
            <button class="btn btn-secondary" onclick="downloadData()">
              <span>📥</span>
              Download
            </button>
          </div>

          <div class="security-item">
            <div class="security-info">
              <div class="security-title">Hapus Akun</div>
              <div class="security-description">Hapus akun dan semua data secara permanen</div>
            </div>
            <button class="btn btn-danger" onclick="deleteAccount()">
              <span>🗑️</span>
              Hapus Akun
            </button>
          </div>
        </div>
      </div>

      <!-- Preferences Tab -->
      <div class="tab-content" id="preferences">
        <div class="form-section">
          <h3>🔔 Notifikasi</h3>
          <div class="form-grid">
            <div class="form-group">
              <label style="display: flex; align-items: center; gap: 0.5rem; color: #ccc !important;">
                <input type="checkbox" checked style="width: auto !important;">
                Notifikasi Booking
              </label>
            </div>
            <div class="form-group">
              <label style="display: flex; align-items: center; gap: 0.5rem; color: #ccc !important;">
                <input type="checkbox" checked style="width: auto !important;">
                Notifikasi Komunitas
              </label>
            </div>
            <div class="form-group">
              <label style="display: flex; align-items: center; gap: 0.5rem; color: #ccc !important;">
                <input type="checkbox" style="width: auto !important;">
                Notifikasi Promo
              </label>
            </div>
            <div class="form-group">
              <label style="display: flex; align-items: center; gap: 0.5rem; color: #ccc !important;">
                <input type="checkbox" checked style="width: auto !important;">
                Email Newsletter
              </label>
            </div>
          </div>
        </div>

        <div class="form-section">
          <h3>🎨 Tampilan</h3>
          <div class="form-grid">
            <div class="form-group">
              <label for="theme">Tema</label>
              <select id="theme" name="theme">
                <option value="dark" selected>Dark Mode</option>
                <option value="light">Light Mode</option>
                <option value="auto">Auto</option>
              </select>
            </div>
            <div class="form-group">
              <label for="language">Bahasa</label>
              <select id="language" name="language">
                <option value="id" selected>Bahasa Indonesia</option>
                <option value="en">English</option>
              </select>
            </div>
          </div>
        </div>

        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
          <button type="button" class="btn btn-primary">
            <span>💾</span>
            Simpan Preferensi
          </button>
        </div>
      </div>

      <!-- Activity Tab -->
      <div class="tab-content" id="activity">
        <div class="form-section">
          <h3>📊 Aktivitas Terakhir</h3>
          
          <div class="activity-item">
            <div class="activity-icon">📅</div>
            <div class="activity-content">
              <div class="activity-title">Booking Lapangan Badminton</div>
              <div class="activity-time">2 jam yang lalu</div>
            </div>
          </div>

          <div class="activity-item">
            <div class="activity-icon">👥</div>
            <div class="activity-content">
              <div class="activity-title">Bergabung dengan Badminton Club Bandung</div>
              <div class="activity-time">1 hari yang lalu</div>
            </div>
          </div>

          <div class="activity-item">
            <div class="activity-icon">🏆</div>
            <div class="activity-content">
              <div class="activity-title">Naik Level ke Tennis Enthusiast</div>
              <div class="activity-time">3 hari yang lalu</div>
            </div>
          </div>

          <div class="activity-item">
            <div class="activity-icon">💰</div>
            <div class="activity-content">
              <div class="activity-title">Pembayaran Booking Berhasil</div>
              <div class="activity-time">5 hari yang lalu</div>
            </div>
          </div>

          <div class="activity-item">
            <div class="activity-icon">👤</div>
            <div class="activity-content">
              <div class="activity-title">Profile Diupdate</div>
              <div class="activity-time">1 minggu yang lalu</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    function switchTab(tabName) {
      // Remove active class from all tabs and content
      document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
      document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
      
      // Add active class to clicked tab and corresponding content
      event.target.classList.add('active');
      document.getElementById(tabName).classList.add('active');
    }

    function closeAlert(alertId) {
      const alert = document.getElementById(alertId);
      if (alert) {
        alert.style.animation = 'slideOut 0.3s ease-in';
        setTimeout(() => {
          alert.remove();
        }, 300);
      }
    }

    // Auto-hide success alert after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
      const successAlert = document.getElementById('successAlert');
      if (successAlert) {
        setTimeout(() => {
          closeAlert('successAlert');
        }, 5000);
      }
    });

    function uploadAvatar() {
      Swal.fire({
        title: 'Upload Foto Profil',
        text: 'Fitur upload foto akan segera tersedia!',
        icon: 'info',
        background: '#2c2c2e',
        color: '#fff',
        confirmButtonColor: '#f59e0b'
      });
    }

    function updatePersonalInfo(event) {
      event.preventDefault();
      
      Swal.fire({
        title: 'Menyimpan...',
        text: 'Sedang memproses perubahan data',
        icon: 'info',
        background: '#2c2c2e',
        color: '#fff',
        showConfirmButton: false,
        timer: 2000
      }).then(() => {
        Swal.fire({
          title: 'Berhasil!',
          text: 'Data profil berhasil diupdate',
          icon: 'success',
          background: '#2c2c2e',
          color: '#fff',
          confirmButtonColor: '#f59e0b'
        });
      });
    }

    function resetForm() {
      if (confirm('Apakah Anda yakin ingin mereset semua perubahan?')) {
        document.getElementById('profileForm').reset();
        
        // Show success message
        Swal.fire({
          icon: 'info',
          title: 'Form direset',
          text: 'Semua perubahan telah dibatalkan',
          background: '#2c2c2e',
          color: 'white',
          confirmButtonColor: '#f59e0b'
        });
      }
    }
    
    // Add form validation
    document.getElementById('profileForm').addEventListener('submit', function(e) {
      const submitBtn = this.querySelector('button[type="submit"]');
      submitBtn.classList.add('loading');
      submitBtn.disabled = true;
      
      const requiredFields = ['name', 'email'];
      let missingFields = [];
      
      requiredFields.forEach(field => {
        const input = document.getElementById(field);
        if (!input.value.trim()) {
          missingFields.push(field);
        }
      });
      
      if (missingFields.length > 0) {
        e.preventDefault();
        submitBtn.classList.remove('loading');
        submitBtn.disabled = false;
        
        Swal.fire({
          icon: 'error',
          title: 'Data tidak lengkap',
          text: 'Mohon lengkapi semua field yang wajib diisi',
          background: '#2c2c2e',
          color: 'white',
          confirmButtonColor: '#f59e0b'
        });
        return false;
      }
      
      // If validation passes, show loading state
      Swal.fire({
        title: 'Menyimpan...',
        text: 'Mohon tunggu sebentar',
        background: '#2c2c2e',
        color: 'white',
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });
    });
    
    // Add input animations
    document.querySelectorAll('.form-group input, .form-group select, .form-group textarea').forEach(input => {
      input.addEventListener('focus', function() {
        this.parentElement.classList.add('focused');
      });
      
      input.addEventListener('blur', function() {
        this.parentElement.classList.remove('focused');
      });
    });

    function sendVerificationEmail() {
      // Show loading state
      Swal.fire({
        title: 'Mengirim email...',
        text: 'Mohon tunggu sebentar',
        background: '#2c2c2e',
        color: 'white',
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

      // Send POST request to verification.send route
      fetch('{{ route('verification.send') }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}',
          'Accept': 'application/json'
        },
        credentials: 'same-origin'
      })
      .then(response => {
        console.log('Response status:', response.status);
        console.log('Response ok:', response.ok);
        
        // Always try to parse JSON, even for error responses
        return response.json().then(data => {
          console.log('Response data:', data);
          return { status: response.status, ok: response.ok, data: data };
        });
      })
      .then(result => {
        console.log('Final result:', result);
        
        // Check for explicit error in response data
        if (result.data.error) {
          throw new Error(result.data.error);
        }
        
        // Check for success (status 200 and has message)
        if (result.ok && result.data.message) {
          Swal.fire({
            title: 'Email Verifikasi Dikirim!',
            text: result.data.message,
            icon: 'success',
            background: '#2c2c2e',
            color: '#fff',
            confirmButtonColor: '#f59e0b'
          });
        } else {
          // Handle other status codes
          let errorMsg = 'Terjadi kesalahan saat mengirim email verifikasi.';
          if (result.status === 429) {
            errorMsg = 'Terlalu banyak permintaan. Silakan tunggu beberapa saat.';
          } else if (result.status === 422) {
            errorMsg = 'Data tidak valid. Silakan refresh halaman.';
          } else if (result.status >= 500) {
            errorMsg = 'Masalah server. Silakan coba lagi nanti.';
          }
          throw new Error(errorMsg);
        }
      })
      .catch(error => {
        console.error('Email verification error:', error);
        
        let errorMessage = error.message || 'Terjadi kesalahan saat mengirim email verifikasi.';
        
        // Override generic error messages with more helpful ones
        if (error.message && error.message.includes('Failed to fetch')) {
          errorMessage = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
        }
        
        Swal.fire({
          title: 'Gagal Mengirim',
          text: errorMessage,
          icon: 'error',
          background: '#2c2c2e',
          color: '#fff',
          confirmButtonColor: '#f59e0b'
        });
      });
    }

    function showPasswordForm() {
      Swal.fire({
        title: 'Ubah Password',
        html: `
          <div style="text-align: left; margin: 1rem 0;">
            <input type="password" id="current_password" class="swal2-input" placeholder="Password Saat Ini" style="background: #1a1a1a; border: 1px solid #404040; color: white;">
            <input type="password" id="new_password" class="swal2-input" placeholder="Password Baru" style="background: #1a1a1a; border: 1px solid #404040; color: white;">
            <input type="password" id="confirm_password" class="swal2-input" placeholder="Konfirmasi Password Baru" style="background: #1a1a1a; border: 1px solid #404040; color: white;">
          </div>
        `,
        background: '#2c2c2e',
        color: '#fff',
        confirmButtonColor: '#f59e0b',
        confirmButtonText: 'Ubah Password',
        showCancelButton: true,
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            title: 'Berhasil!',
            text: 'Password berhasil diubah',
            icon: 'success',
            background: '#2c2c2e',
            color: '#fff',
            confirmButtonColor: '#f59e0b'
          });
        }
      });
    }

    function setup2FA() {
      Swal.fire({
        title: '2FA Setup',
        text: 'Fitur Two-Factor Authentication akan segera tersedia!',
        icon: 'info',
        background: '#2c2c2e',
        color: '#fff',
        confirmButtonColor: '#f59e0b'
      });
    }

    function downloadData() {
      Swal.fire({
        title: 'Download Data',
        text: 'Data Anda akan disiapkan dan dikirim via email dalam 24 jam',
        icon: 'info',
        background: '#2c2c2e',
        color: '#fff',
        confirmButtonColor: '#f59e0b'
      });
    }

    function deleteAccount() {
      Swal.fire({
        title: 'Hapus Akun?',
        text: 'Tindakan ini tidak dapat dibatalkan! Semua data akan dihapus permanen.',
        icon: 'warning',
        background: '#2c2c2e',
        color: '#fff',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus Akun',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            title: 'Masukkan Password',
            input: 'password',
            inputPlaceholder: 'Masukkan password untuk konfirmasi',
            background: '#2c2c2e',
            color: '#fff',
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Hapus Akun',
            showCancelButton: true,
            inputAttributes: {
              style: 'background: #1a1a1a; border: 1px solid #404040; color: white;'
            }
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire({
                title: 'Akun Dihapus',
                text: 'Akun Anda telah dihapus. Terima kasih telah menggunakan Lapangin.',
                icon: 'success',
                background: '#2c2c2e',
                color: '#fff',
                confirmButtonColor: '#f59e0b'
              });
            }
          });
        }
      });
    }
  </script>
  </div> <!-- Close app-container -->
</body>
</html>