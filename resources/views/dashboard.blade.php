<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Lapangin</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background-color: #2c2c2e;
      color: white;
      padding: 2rem;
    }
    .container {
      max-width: 1200px;
      margin: 0 auto;
    }
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
    }
    .logout-btn {
      background-color: #ff6b6b;
      color: white;
      padding: 0.5rem 1rem;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      text-decoration: none;
    }
    .logout-btn:hover {
      background-color: #ff5252;
    }
    .success {
      color: #4caf50;
      font-size: 14px;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Welcome, {{ Auth::user()->name }}!</h1>
      <form action="{{ url('/logout') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit" class="logout-btn">Logout</button>
      </form>
    </div>
    
    @if(session('success'))
      <div class="success">{{ session('success') }}</div>
    @endif
    
    <div class="content">
      <p>Email: {{ Auth::user()->email }}</p>
      <p>Member since: {{ Auth::user()->created_at->format('F j, Y') }}</p>
    </div>
  </div>
</body>
</html>
