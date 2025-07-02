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
      max-width: 400px;
      display: flex;
      flex-direction: column;
    }
    label {
      display: block;
      font-size: 14px;
      margin-bottom: 5px;
      margin-top: 16px;
      text-align: left;
    }
    input, textarea {
      width: 100%;
      padding: 12px 16px;
      border: none;
      border-radius: 8px;
      background-color: #e5e5e5;
      font-size: 16px;
      margin-bottom: 8px;
      box-sizing: border-box;
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
  </style>
</head>
<body>
  <div class="register-container">
    <h1>Register your account</h1>
    <h1>Sign up to access features.</h1>
    
    @if(session('error'))
      <div class="error">{{ session('error') }}</div>
    @endif
    
    <form action="{{ url('/register') }}" method="POST">
      @csrf
      <label for="name">Name</label>
      <input type="text" id="name" name="name" placeholder="Jane Smith" value="{{ old('name') }}" required>
      @error('name')
        <div class="error">{{ $message }}</div>
      @enderror

      <label for="email">Email</label>
      <input type="email" id="email" name="email" placeholder="jane@lapangin.com" value="{{ old('email') }}" required>
      @error('email')
        <div class="error">{{ $message }}</div>
      @enderror

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Your password" required>
      @error('password')
        <div class="error">{{ $message }}</div>
      @enderror

      <label for="confirm_password">Confirm Password</label>
      <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
      @error('confirm_password')
        <div class="error">{{ $message }}</div>
      @enderror

      <button type="submit">Create account.</button>
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
