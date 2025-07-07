<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lapangin - Get Started</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background-color: #2c2c2e;
      color: white;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    main {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 2rem;
      margin: 20.5rem;
    }
    .logo img {
      height: 40px;
      /* margin-bottom: 4rem; */
    }
    h1 {
      font-size: 3rem;
      margin-bottom: 1rem;
      font-weight: 700;
      color: white;
    }
    h1 span {
      color: #f59e0b;
    }
    p {
      font-size: 1.1rem;
      color: white;
      margin-bottom: 3rem;
      font-weight: 400;
    }
    .buttons {
      display: flex;
      gap: 1rem;
      justify-content: center;
    }
    .buttons a {
      padding: 0.75rem 2rem;
      border-radius: 25px;
      text-decoration: none;
      font-weight: 600;
      font-size: 1rem;
      transition: all 0.3s ease;
      min-width: 100px;
      text-align: center;
    }
    .btn-register {
      background-color: #000;
      color: white;
      border: 2px solid #000;
    }
    .btn-register:hover {
      background-color: #333;
      border-color: #333;
    }
    .btn-login {
      background-color: white;
      color: #000;
      border: 2px solid white;
    }
    .btn-login:hover {
      background-color: #3b82f6;
      border-color: #3b82f6;
      color: white;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
      main {
        padding: 1rem;
      }
      .logo img {
        height: 35px;
        margin-bottom: 3rem;
      }
      h1 {
        font-size: 2.5rem;
      }
      p {
        font-size: 1rem;
        margin-bottom: 2.5rem;
      }
      .buttons {
        flex-direction: column;
        width: 100%;
        max-width: 300px;
      }
      .buttons a {
        width: 100%;
      }
    }
  </style>
</head>
<body>
  <main>
    <div class="logo">
        <img src="{{ asset('img/Lapangin-White.png') }}" alt="Lapangin Logo" style="height: 40px;">
    </div>
    <h1>
    <span>Get started.</span><br>
    Register or log in below.
    </h1>
    <div class="buttons">
      <a href="{{ url('/register') }}" class="btn-register">Register</a>
      <a href="{{ url('/login') }}" class="btn-login">Login</a>
    </div>
  </main>

  <!-- Include Footer Component -->
  @include('components.footer')
</body>
</html>
