<!-- Footer -->
<footer class="footer" id="contact">
  <div class="footer-container">
    <div class="footer-content">
      <!-- Logo Section -->
      <div class="footer-section">
        <div class="logo-footer">
          <img src="{{ asset('img/Lapangin-White.png') }}" alt="Lapangin">
        </div>
        <p class="footer-tagline">Platform booking lapangan olahraga terpercaya di Indonesia</p>
        <div class="social-links">
          <a href="#" class="social-link"><i class="fab fa-facebook"></i></a>
          <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
          <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
          <a href="#" class="social-link"><i class="fab fa-whatsapp"></i></a>
        </div>
      </div>

      <!-- Quick Links -->
      <div class="footer-section">
        <h3 class="footer-title">Quick Links</h3>
        <ul class="footer-links">
          <li><a href="{{ url('/') }}">Home</a></li>
          <li><a href="#features">Features</a></li>
          <li><a href="#about">About Us</a></li>
          <li><a href="#venues">Venues</a></li>
        </ul>
      </div>

      <!-- Services -->
      <div class="footer-section">
        <h3 class="footer-title">Services</h3>
        <ul class="footer-links">
          <li><a href="#">Badminton</a></li>
          <li><a href="#">Futsal</a></li>
          <li><a href="#">Basketball</a></li>
          <li><a href="#">Tennis</a></li>
        </ul>
      </div>

      <!-- Contact Info -->
      <div class="footer-section">
        <h3 class="footer-title">Contact Us</h3>
        <div class="contact-info">
          <div class="contact-item">
            <i class="fas fa-map-marker-alt"></i>
            <span>Jl. Telekomunikasi No. 1, Bandung, Jawa Barat 40257</span>
          </div>
          <div class="contact-item">
            <i class="fas fa-phone"></i>
            <span>+62 812-3456-7890</span>
          </div>
          <div class="contact-item">
            <i class="fas fa-envelope"></i>
            <span>info@lapangin.com</span>
          </div>
          <div class="contact-item">
            <i class="fas fa-clock"></i>
            <span>24/7 Customer Support</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
      <div class="footer-bottom-content">
        <p>&copy; 2024 Lapangin. All rights reserved.</p>
        <div class="footer-bottom-links">
          <a href="#">Privacy Policy</a>
          <a href="#">Terms of Service</a>
          <a href="#">Cookie Policy</a>
        </div>
      </div>
    </div>
  </div>
</footer>

<style>
  /* Footer Styles */
  .footer {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    color: #ffffff;
    padding: 4rem 0 0;
    margin-top: auto;
  }

  .footer-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
  }

  .footer-content {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1.5fr;
    gap: 3rem;
    margin-bottom: 3rem;
  }

  .footer-section h3.footer-title {
    color: #f59e0b;
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
  }

  .logo-footer {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
  }

  .logo-footer img {
    height: 50px;
    width: auto;
  }

  .footer-tagline {
    color: #b3b3b3;
    line-height: 1.6;
    margin-bottom: 1.5rem;
    font-size: 0.95rem;
  }

  .social-links {
    display: flex;
    gap: 1rem;
  }

  .social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(245, 158, 11, 0.1);
    border: 1px solid rgba(245, 158, 11, 0.3);
    border-radius: 50%;
    color: #f59e0b;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 1.2rem;
  }

  .social-link:hover {
    background: #f59e0b;
    color: #1a1a1a;
    transform: translateY(-2px);
  }

  .footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .footer-links li {
    margin-bottom: 0.75rem;
  }

  .footer-links a {
    color: #b3b3b3;
    text-decoration: none;
    font-size: 0.95rem;
    transition: color 0.3s ease;
  }

  .footer-links a:hover {
    color: #f59e0b;
  }

  .contact-info {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  .contact-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    font-size: 0.95rem;
  }

  .contact-item i {
    color: #f59e0b;
    font-size: 1.1rem;
    margin-top: 0.1rem;
    min-width: 16px;
  }

  .contact-item span {
    color: #b3b3b3;
    line-height: 1.5;
  }

  .footer-bottom {
    border-top: 1px solid #404040;
    padding: 2rem 0;
  }

  .footer-bottom-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
  }

  .footer-bottom p {
    color: #b3b3b3;
    margin: 0;
    font-size: 0.9rem;
  }

  .footer-bottom-links {
    display: flex;
    gap: 2rem;
  }

  .footer-bottom-links a {
    color: #b3b3b3;
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.3s ease;
  }

  .footer-bottom-links a:hover {
    color: #f59e0b;
  }

  /* Responsive Design */
  @media (max-width: 1024px) {
    .footer-content {
      grid-template-columns: 1fr 1fr;
      gap: 2rem;
    }
  }

  @media (max-width: 768px) {
    .footer {
      padding: 3rem 0 0;
    }

    .footer-container {
      padding: 0 1rem;
    }

    .footer-content {
      grid-template-columns: 1fr;
      gap: 2rem;
      text-align: center;
    }

    .footer-bottom-content {
      flex-direction: column;
      text-align: center;
      gap: 1rem;
    }

    .footer-bottom-links {
      flex-direction: column;
      gap: 1rem;
    }

    .social-links {
      justify-content: center;
    }

    .contact-info {
      text-align: left;
      max-width: 300px;
      margin: 0 auto;
    }
  }

  @media (max-width: 480px) {
    .footer-container {
      padding: 0 1rem;
    }

    .logo-footer img {
      height: 40px;
    }

    .contact-item {
      font-size: 0.9rem;
    }

    .social-link {
      width: 35px;
      height: 35px;
      font-size: 1rem;
    }
  }
</style>

<!-- Font Awesome for icons (if not already included) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
