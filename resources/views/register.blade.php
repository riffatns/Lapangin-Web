<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register - Lapangin</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <!-- SweetAlert2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <style>
    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background-color: #2c2c2e;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }
    .register-container {
      width: 100%;
      max-width: 600px;
      padding: 32px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    h1 {
      font-size: 40px;
      font-weight: 700;
      margin-bottom: 8px;
      text-align: center;
    }
    h2 {
      font-size: 16px;
      font-weight: 400;
      color: #b3b3b3;
      margin-bottom: 32px;
      text-align: center;
    }
    form {
      width: 100%;
      max-width: 500px;
      display: flex;
      flex-direction: column;
    }
    
    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }
    
    .form-group {
      display: flex;
      flex-direction: column;
    }
    
    .form-group.full-width {
      grid-column: 1 / -1;
    }
    label {
      display: block;
      font-size: 14px;
      margin-bottom: 5px;
      text-align: left;
      font-weight: 500;
    }
    input, textarea, select {
      width: 100%;
      padding: 12px 16px;
      border: none;
      border-radius: 8px;
      background-color: #e5e5e5;
      font-size: 16px;
      margin-bottom: 8px;
      box-sizing: border-box;
      color: #333;
    }
    select {
      cursor: pointer;
    }
    textarea {
      resize: none;
      height: 100px;
    }
    button {
      width: 100%;
      padding: 12px 16px;
      margin-top: 24px;
      background-color: black;
      color: white;
      font-weight: 600;
      font-size: 16px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }
    button:hover {
      background-color: #333;
    }
    .error {
      color: #ff6b6b;
      font-size: 14px;
      margin-top: 4px;
    }
    
    .success {
      color: #51cf66;
      font-size: 14px;
      margin-top: 4px;
    }
    
    .section-title {
      color: #f59e0b;
      font-size: 18px;
      font-weight: 600;
      margin: 20px 0 10px 0;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="register-container">
    <h1>Daftar Akun Baru</h1>
    <h2>Lengkapi data diri untuk mengakses semua fitur Lapangin</h2>
    
    @if(session('error'))
      <div class="error">{{ session('error') }}</div>
    @endif
    
    <form action="{{ url('/register') }}" method="POST">
      @csrf
      
      <!-- Data Pribadi -->
      <div class="section-title">📝 Data Pribadi</div>
      <div class="form-grid">
        <div class="form-group">
          <label for="name">Nama Lengkap</label>
          <input type="text" id="name" name="name" placeholder="Ahmad Rivaldy" value="{{ old('name') }}" required>
          @error('name')
            <div class="error">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="ahmad@lapangin.com" value="{{ old('email') }}" required>
          @error('email')
            <div class="error">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label for="phone">Nomor Telepon</label>
          <input type="tel" id="phone" name="phone" placeholder="+62 812-3456-7890" value="{{ old('phone') }}" required>
          @error('phone')
            <div class="error">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label for="birthdate">Tanggal Lahir</label>
          <input type="date" id="birthdate" name="birthdate" value="{{ old('birthdate') }}" required>
          @error('birthdate')
            <div class="error">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <!-- Lokasi & Preferensi -->
      <div class="section-title">📍 Lokasi & Preferensi Olahraga</div>
      <div class="form-grid">
        <div class="form-group">
          <label for="city">Kota</label>
          <select id="city" name="city" required>
            <option value="">Pilih Kota</option>
            <option value="bandung" {{ old('city') == 'bandung' ? 'selected' : '' }}>Bandung</option>
            <option value="jakarta" {{ old('city') == 'jakarta' ? 'selected' : '' }}>Jakarta</option>
            <option value="surabaya" {{ old('city') == 'surabaya' ? 'selected' : '' }}>Surabaya</option>
            <option value="medan" {{ old('city') == 'medan' ? 'selected' : '' }}>Medan</option>
            <option value="yogyakarta" {{ old('city') == 'yogyakarta' ? 'selected' : '' }}>Yogyakarta</option>
          </select>
          @error('city')
            <div class="error">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label for="favorite_sport">Olahraga Favorit</label>
          <select id="favorite_sport" name="favorite_sport" required>
            <option value="">Pilih Olahraga</option>
            <option value="badminton" {{ old('favorite_sport') == 'badminton' ? 'selected' : '' }}>Badminton</option>
            <option value="futsal" {{ old('favorite_sport') == 'futsal' ? 'selected' : '' }}>Futsal</option>
            <option value="tennis" {{ old('favorite_sport') == 'tennis' ? 'selected' : '' }}>Tennis</option>
            <option value="basketball" {{ old('favorite_sport') == 'basketball' ? 'selected' : '' }}>Basketball</option>
            <option value="volleyball" {{ old('favorite_sport') == 'volleyball' ? 'selected' : '' }}>Volleyball</option>
          </select>
          @error('favorite_sport')
            <div class="error">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <!-- Keamanan Akun -->
      <div class="section-title">🔒 Keamanan Akun</div>
      <div class="form-grid">
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" required>
          @error('password')
            <div class="error">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label for="confirm_password">Konfirmasi Password</label>
          <input type="password" id="confirm_password" name="confirm_password" placeholder="Ulangi password" required>
          @error('confirm_password')
            <div class="error">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <!-- Bio Singkat -->
      <div class="section-title">📝 Tentang Anda (Opsional)</div>
      <div class="form-group full-width">
        <label for="bio">Bio Singkat</label>
        <textarea id="bio" name="bio" placeholder="Ceritakan sedikit tentang diri Anda dan pengalaman olahraga...">{{ old('bio') }}</textarea>
        @error('bio')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit">Daftar Sekarang</button>
      
      <div style="text-align: center; margin-top: 16px;">
        <span style="color: #b3b3b3;">Sudah punya akun? </span>
        <a href="{{ url('/login') }}" style="color: #f59e0b; text-decoration: none;">Login di sini</a>
      </div>
    </form>
  </div>

  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  @if(session('success'))
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Registration Successful!',
      text: 'Your account has been created successfully. Redirecting to login page...',
      confirmButtonColor: '#3b82f6',
      timer: 3000,
      timerProgressBar: true,
      allowOutsideClick: false,
      showConfirmButton: false
    }).then((result) => {
      window.location.href = "{{ url('/login') }}";
    });
  </script>
  @endif

</body>
</html>
