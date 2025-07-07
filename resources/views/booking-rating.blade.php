<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Beri Rating - Lapangin</title>
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
      min-height: 100vh;
      padding: 2rem;
    }
    
    .container {
      max-width: 600px;
      margin: 0 auto;
    }
    
    .header {
      display: flex;
      align-items: center;
      margin-bottom: 2rem;
    }
    
    .back-btn {
      background: #404040;
      border: none;
      color: white;
      padding: 0.75rem;
      border-radius: 8px;
      cursor: pointer;
      margin-right: 1rem;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s ease;
    }
    
    .back-btn:hover {
      background: #525252;
    }
    
    h1 {
      font-size: 1.5rem;
      font-weight: 600;
    }
    
    .rating-card {
      background-color: #2c2c2e;
      border-radius: 12px;
      padding: 2rem;
      border-left: 4px solid #f59e0b;
    }
    
    .venue-info {
      text-align: center;
      margin-bottom: 2rem;
      padding-bottom: 2rem;
      border-bottom: 1px solid #404040;
    }
    
    .venue-info h2 {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
    }
    
    .booking-info {
      color: #999;
      font-size: 0.9rem;
    }
    
    .rating-section {
      margin-bottom: 2rem;
    }
    
    .rating-section h3 {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 1rem;
      color: #f59e0b;
    }
    
    .stars-container {
      display: flex;
      justify-content: center;
      gap: 0.5rem;
      margin-bottom: 1rem;
    }
    
    .star {
      font-size: 2rem;
      color: #404040;
      cursor: pointer;
      transition: all 0.2s ease;
      user-select: none;
    }
    
    .star:hover,
    .star.active {
      color: #f59e0b;
      transform: scale(1.1);
    }
    
    .rating-text {
      text-align: center;
      color: #999;
      font-size: 0.9rem;
      margin-bottom: 1rem;
    }
    
    .review-section {
      margin-bottom: 2rem;
    }
    
    .review-section h3 {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 1rem;
      color: #f59e0b;
    }
    
    .review-textarea {
      width: 100%;
      min-height: 120px;
      background-color: #404040;
      border: 1px solid #525252;
      border-radius: 8px;
      padding: 1rem;
      color: white;
      font-family: 'Inter', sans-serif;
      font-size: 0.9rem;
      resize: vertical;
    }
    
    .review-textarea:focus {
      outline: none;
      border-color: #f59e0b;
    }
    
    .review-textarea::placeholder {
      color: #999;
    }
    
    .form-actions {
      display: flex;
      gap: 1rem;
      justify-content: center;
    }
    
    .action-btn {
      padding: 0.75rem 1.5rem;
      border: none;
      border-radius: 8px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s ease;
      text-decoration: none;
      display: inline-block;
      text-align: center;
      font-family: 'Inter', sans-serif;
    }
    
    .btn-primary {
      background-color: #f59e0b;
      color: white;
    }
    
    .btn-primary:hover {
      background-color: #d97706;
    }
    
    .btn-primary:disabled {
      background-color: #404040;
      cursor: not-allowed;
    }
    
    .btn-secondary {
      background-color: #404040;
      color: white;
    }
    
    .btn-secondary:hover {
      background-color: #525252;
    }
    
    .error-message {
      background-color: #dc2626;
      color: white;
      padding: 1rem;
      border-radius: 8px;
      margin-bottom: 2rem;
    }
    
    .success-message {
      background-color: #059669;
      color: white;
      padding: 1rem;
      border-radius: 8px;
      margin-bottom: 2rem;
    }
    
    .rating-labels {
      display: flex;
      justify-content: space-between;
      font-size: 0.8rem;
      color: #666;
      margin-top: 0.5rem;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <a href="{{ route('booking.detail', $booking->id) }}" class="back-btn">
        ← 
      </a>
      <h1>Beri Rating & Review</h1>
    </div>

    @if($errors->any())
      <div class="error-message">
        <ul style="margin: 0; padding-left: 1rem;">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @if(session('success'))
      <div class="success-message">
        {{ session('success') }}
      </div>
    @endif

    <div class="rating-card">
      <div class="venue-info">
        <h2>{{ $booking->venue->name }}</h2>
        <div class="booking-info">
          {{ $booking->booking_date->format('d M Y') }} • {{ $booking->start_time }} - {{ $booking->end_time }}
        </div>
      </div>

      <form action="{{ route('booking.rating.submit', $booking->id) }}" method="POST">
        @csrf
        
        <div class="rating-section">
          <h3>Berikan Rating Anda</h3>
          <div class="stars-container">
            <span class="star" data-rating="1">★</span>
            <span class="star" data-rating="2">★</span>
            <span class="star" data-rating="3">★</span>
            <span class="star" data-rating="4">★</span>
            <span class="star" data-rating="5">★</span>
          </div>
          <div class="rating-labels">
            <span>Sangat Buruk</span>
            <span>Buruk</span>
            <span>Biasa</span>
            <span>Bagus</span>
            <span>Sangat Bagus</span>
          </div>
          <div class="rating-text" id="rating-text">Pilih rating untuk lapangan ini</div>
          <input type="hidden" name="rating" id="rating-input" value="{{ old('rating') }}">
        </div>

        <div class="review-section">
          <h3>Review (Opsional)</h3>
          <textarea 
            name="review" 
            class="review-textarea" 
            placeholder="Bagikan pengalaman Anda menggunakan lapangan ini..."
            maxlength="500">{{ old('review') }}</textarea>
        </div>

        <div class="form-actions">
          <button type="submit" class="action-btn btn-primary" id="submit-btn" disabled>Kirim Rating</button>
          <a href="{{ route('booking.detail', $booking->id) }}" class="action-btn btn-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>

  <script>
    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('rating-input');
    const ratingText = document.getElementById('rating-text');
    const submitBtn = document.getElementById('submit-btn');
    
    const ratingTexts = {
      1: 'Sangat buruk - Tidak merekomendasikan',
      2: 'Buruk - Banyak kekurangan',
      3: 'Biasa saja - Cukup memuaskan',
      4: 'Bagus - Merekomendasikan',
      5: 'Sangat bagus - Sangat merekomendasikan!'
    };

    // Set initial rating if exists
    const initialRating = ratingInput.value;
    if (initialRating) {
      updateStars(parseInt(initialRating));
    }

    stars.forEach((star, index) => {
      star.addEventListener('click', () => {
        const rating = index + 1;
        updateStars(rating);
        ratingInput.value = rating;
        ratingText.textContent = ratingTexts[rating];
        submitBtn.disabled = false;
      });

      star.addEventListener('mouseenter', () => {
        const rating = index + 1;
        highlightStars(rating);
      });

      star.addEventListener('mouseleave', () => {
        const currentRating = parseInt(ratingInput.value) || 0;
        highlightStars(currentRating);
      });
    });

    function updateStars(rating) {
      stars.forEach((star, index) => {
        if (index < rating) {
          star.classList.add('active');
        } else {
          star.classList.remove('active');
        }
      });
    }

    function highlightStars(rating) {
      stars.forEach((star, index) => {
        if (index < rating) {
          star.style.color = '#f59e0b';
        } else {
          star.style.color = '#404040';
        }
      });
    }
  </script>
</body>
</html>
