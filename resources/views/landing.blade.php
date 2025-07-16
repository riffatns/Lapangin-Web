<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lapangin - Book Your Field</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background-color: #2c2c2e;
      color: white;
    }
    header {
      position: sticky;
      top: 1rem; /* Beri jarak dari atas */
      z-index: 1000;
      display: flex;
      justify-content: space-between;
      align-items: center;
      width: 1550px; /* Lebar sesuai Figma */
      height: 64px; /* Tinggi sesuai Figma */
      padding: 0 2rem; /* Padding horizontal untuk konten */
      background: rgba(255, 255, 255, 0.95); /* Semi-transparent white */
      backdrop-filter: blur(10px); /* Glassmorphism effect */
      -webkit-backdrop-filter: blur(10px); /* Safari support */
      margin: 1rem auto; /* Auto margin untuk center */
      border-radius: 10px;
      border: 1px solid rgba(255, 255, 255, 0.2); /* Subtle border */
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
      box-sizing: border-box; /* Include padding dalam width calculation */
    }
    /* More transparent when scrolled */
    header.scrolled {
      top: 1rem; /* Sedikit lebih jauh dari atas ketika scrolled */
      margin: 1rem auto; /* Margin tetap sama seperti default */
      width: 1550px; /* Tetap sama saat scroll */
      height: 64px; /* Tetap sama saat scroll */
      background: rgba(255, 255, 255, 0.6); /* Much more transparent when scrolled */
      backdrop-filter: blur(15px); /* Stronger blur when scrolled */
      -webkit-backdrop-filter: blur(15px);
      border-radius: 10px; /* Tetap sama seperti default */
      border: 1px solid rgba(255, 255, 255, 0.15); /* More subtle border */
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); /* Much softer shadow */
    }
    .logo {
      font-size: 1.5rem;
      font-weight: bold;
      color: #2c2c2e;
      display: flex;
      align-items: center;
      margin-top: 2px; /* Move logo down slightly */
    }

    .logo img {
      filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.15));
      /* Atau jika ingin lebih kuat: */
      /* filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2)); */
    }
    .nav-center {
      display: flex;
      gap: 2rem;
    }
    .nav-center a {
      color: #666;
      text-decoration: none;
      font-weight: 600;
      padding: 0.5rem 1rem;
      border-radius: 15px;
      transition: all 0.3s ease;
    }
    .nav-center a:hover {
      background-color: #f0f0f0;
      color: #2c2c2e;
    }
    .social-icons {
      display: flex;
      gap: 1rem;
      align-items: center;
    }
    .social-icons a {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      background-color: #f5f5f5;
      display: flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      color: #666;
      font-size: 18px;
      transition: all 0.3s ease;
    }
    .social-icons a:hover {
      background-color: #e0e0e0;
      color: #2c2c2e;
    }
    .hero {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 4rem 2rem;
      margin: 8rem 0;
      gap: 4rem;
      min-height: 500px;
    }
    .hero-images {
      position: relative;
      width: 600px;
      height: 400px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .hero-images img {
      position: absolute;
      object-fit: cover;
      background: transparent; /* Remove any background */
      transition: transform 0.3s ease;
    }
    /* Style untuk gambar Football (gambar pertama) */
    .hero-images img:first-child {
      width: 400px;
      height: 400px;
      top: 150px;
      left: -200px; /* Posisi kiri sedikit ke kiri */
      z-index: 1;
      background: transparent;
      mix-blend-mode: normal; /* Ensure proper blending */
    }
    /* Style untuk gambar Basketball (gambar kedua) */
    .hero-images img:last-child {
      width: 630px;
      height: 630px;
      /*top: 0;*/
      right: 0;
      z-index: 2;
      background: transparent;
      mix-blend-mode: normal; /* Ensure proper blending */
    }
    .hero-images img:hover {
      transform: scale(1.05);
    }
    .hero-text {
      max-width: 500px;
      flex-shrink: 0;
    }
    .hero-text h1 {
      font-size: 2rem;
      margin-bottom: 1rem;
    }
    .hero-text a {
      display: inline-block;
      margin-top: 1rem;
      background: white;
      color: #2c2c2e;
      padding: 0.5rem 1rem;
      border-radius: 20px;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
    }
    .hero-text a:hover {
      background: #3b82f6;
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
    .cards {
      display: flex;
      justify-content: center;
      gap: 2rem;
      margin: 12rem;
    }
    .card-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      max-width: 310px;
    }
    .card {
      width: 310px;
      height: 310px;
      background: white;
      border-radius: 12px;
      margin-bottom: 1rem;
      box-sizing: border-box;
    }
    .card-text {
      text-align: center;
      max-width: 280px;
    }
    .card-text h3 {
      color: white;
      font-size: 1.25rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
      margin-top: 0;
    }
    .card-text p {
      color: #bbb;
      font-size: 0.9rem;
      margin: 0;
      line-height: 1.4;
    }
    .cta {
      text-align: center;
      margin: 16rem 2rem;
    }
    .cta h2 {
      color: #3b82f6;
      margin-bottom: 0.5rem;
    }
    .cta a {
      display: inline-block;
      background: white;
      color: #2c2c2e;
      padding: 0.5rem 1rem;
      border-radius: 20px;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
    }
    .cta a:hover {
      background: #3b82f6;
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
    
    /* Responsive Design */
    @media (max-width: 1024px) {
      header {
        width: 90%; /* Responsive width untuk layar lebih kecil */
        max-width: 960px; /* Tetap maksimal 960px */
        margin: 1rem auto;
      }
      header.scrolled {
        width: 90%;
        max-width: 960px;
        margin: 1rem auto; /* Margin tetap sama */
      }
    }

    @media (max-width: 768px) {
      header {
        width: 95%;
        height: auto; /* Height auto untuk mobile */
        min-height: 64px; /* Minimal height */
        padding: 0.75rem 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
      }
      header.scrolled {
        width: 95%;
        height: auto;
        min-height: 64px;
      }
      .nav-center {
        order: 3;
        width: 100%;
        justify-content: center;
        margin-top: 0.5rem;
      }
      .nav-center a {
        font-size: 0.9rem;
        padding: 0.25rem 0.75rem;
      }
      .social-icons a {
        width: 30px;
        height: 30px;
        font-size: 16px;
      }
      .hero {
        flex-direction: column;
        gap: 2rem;
        padding: 2rem 1rem;
      }
      .hero-images {
        width: 300px;
        height: 250px;
      }
      /* Style responsive untuk gambar Football */
      .hero-images img:first-child {
        width: 180px;
        height: 180px;
        top: 40px;
        left: 20px;
      }
      /* Style responsive untuk gambar Basketball */
      .hero-images img:last-child {
        width: 200px;
        height: 200px;
        top: 0;
        right: 20px;
      }
      .hero-text {
        text-align: center;
        max-width: 100%;
      }
      .hero-text h1 {
        font-size: 1.5rem;
      }
      .cards {
        flex-direction: column;
        align-items: center;
        gap: 2rem;
        margin: 2rem 1rem;
      }
      .card-container {
        max-width: 100%;
      }
      .card {
        width: 100%;
        max-width: 300px;
        height: 250px;
      }
      .card-text {
        max-width: 100%;
      }
      .card-text h3 {
        font-size: 1.1rem;
      }
      .card-text p {
        font-size: 0.85rem;
      }
    }
  </style>
</head>
<body>
  <header>
    <div class="logo">
        <img src="{{ asset('img/Lapangin-Black.png') }}" alt="Lapangin Logo" style="height: 40px;">
    </div>
    <nav class="nav-center">
      <a href="#book-now" onclick="smoothScrollTo('book-now')">Book Now</a>
      <a href="#features" onclick="smoothScrollTo('features')">Features</a>
      <a href="#contact" onclick="smoothScrollTo('contact')">Contact</a>
    </nav>
    <div class="social-icons">
      <a href="#" title="Instagram" aria-label="Instagram">
        <i class="fab fa-instagram"></i>
      </a>
      <a href="#" title="Website" aria-label="Website">
        <i class="fas fa-globe"></i>
      </a>
      <a href="#" title="Twitter" aria-label="Twitter">
        <i class="fab fa-twitter"></i>
      </a>
    </div>
  </header>

  <section class="hero" id="book-now">
    <div class="hero-images">
      <img src="{{ asset('img/Football-Anime.png') }}" alt="Football" />
      <img src="{{ asset('img/Basketball-Anime.png') }}" alt="Basketball" />
    </div>
    <div class="hero-text">
        <h1>Book Your Field. <br /><span style="color:#f59e0b">Reserve, play, and win.</span></h1>
        <a href="{{ url('/starting-page') }}">Get Started</a>
    </div>
  </section>

  <section class="cards" id="features">
    <div class="card-container">
      <div class="card"></div>
      <div class="card-text">
        <h3>Easy booking.</h3>
        <p>Find and reserve any sports field in seconds—football, tennis, more.</p>
      </div>
    </div>
    <div class="card-container">
      <div class="card"></div>
      <div class="card-text">
        <h3>Flexible times.</h3>
        <p>Book by the hour or for full days, whenever it fits your schedule.</p>
      </div>
    </div>
    <div class="card-container">
      <div class="card"></div>
      <div class="card-text">
        <h3>Best prices.</h3>
        <p>Competitive rates with seasonal offers for every field.</p>
      </div>
    </div>
  </section>

  <section class="cta">
    <h1><span style="color:#3b82f6; font-size: 2rem;">Ready to play?</span><br />
    <span style="font-size: 2rem;">Book your spot on the field now.</span></h1>
    <a href="{{ url('/starting-page') }}">Book a field</a>
  </section>

  <!-- Include Footer Component -->
  @include('components.footer')

  <script>
    // Smooth scroll function
    function smoothScrollTo(elementId) {
      event.preventDefault(); // Prevent default anchor behavior
      const element = document.getElementById(elementId);
      if (element) {
        element.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    }

    // Add scroll effect to header (if needed for transparency)
    window.addEventListener('scroll', function() {
      const header = document.querySelector('header');
      if (window.scrollY > 100) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    });
  </script>
</body>
</html>
