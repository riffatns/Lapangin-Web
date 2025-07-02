<?php
// filepath: resources/views/login.blade.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Lapangin</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
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
    .login-container {
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
    .subtitle {
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
    input {
      width: 100%;
      padding: 12px 16px;
      border: none;
      border-radius: 8px;
      background-color: #e5e5e5;
      font-size: 16px;
      margin-bottom: 8px;
      box-sizing: border-box;
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
      margin-bottom: 10px;
    }
    .success {
      color: #4caf50;
      font-size: 14px;
      margin-bottom: 10px;
    }
    .link {
      margin-top: 20px;
      text-align: center;
    }
    .link a {
      color: #3b82f6;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h1>Welcome back</h1>
    <p class="subtitle">Sign in to your account</p>
    
    @if(session('error'))
      <div class="error">{{ session('error') }}</div>
    @endif
    
    @if(session('success'))
      <div class="success">{{ session('success') }}</div>
    @endif
    
    <form action="{{ url('/login') }}" method="POST">
      @csrf
      
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

      <button type="submit">Sign in</button>
    </form>
    
    <div class="link">
      <p>Don't have an account? <a href="{{ url('/register') }}">Register here</a></p>
    </div>
  </div>
</body>
</html>