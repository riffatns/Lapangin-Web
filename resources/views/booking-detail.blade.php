<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Booking - Lapangin</title>
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
      max-width: 800px;
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
    
    .booking-card {
      background-color: #2c2c2e;
      border-radius: 12px;
      padding: 2rem;
      border-left: 4px solid #f59e0b;
      margin-bottom: 2rem;
    }
    
    .booking-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 2rem;
    }
    
    .venue-info h2 {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
    }
    
    .sport-type {
      background-color: rgba(245, 158, 11, 0.2);
      color: #f59e0b;
      padding: 0.25rem 0.75rem;
      border-radius: 12px;
      font-size: 0.8rem;
      font-weight: 500;
      display: inline-block;
    }
    
    .status {
      padding: 0.5rem 1rem;
      border-radius: 12px;
      font-size: 0.9rem;
      font-weight: 500;
      text-align: center;
    }
    
    .status-pending {
      background-color: rgba(245, 158, 11, 0.2);
      color: #f59e0b;
    }
    
    .status-confirmed {
      background-color: rgba(16, 185, 129, 0.2);
      color: #34d399;
    }
    
    .status-completed {
      background-color: rgba(16, 185, 129, 0.2);
      color: #34d399;
    }
    
    .status-cancelled {
      background-color: rgba(239, 68, 68, 0.2);
      color: #f87171;
    }
    
    .booking-details {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 2rem;
      margin-bottom: 2rem;
    }
    
    .detail-section {
      background-color: #404040;
      padding: 1.5rem;
      border-radius: 8px;
    }
    
    .detail-section h3 {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 1rem;
      color: #f59e0b;
    }
    
    .detail-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 0.75rem;
      color: #999;
    }
    
    .detail-value {
      color: white;
      font-weight: 500;
    }
    
    .time-slots {
      background-color: #404040;
      padding: 1.5rem;
      border-radius: 8px;
      margin-bottom: 2rem;
    }
    
    .time-slots h3 {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 1rem;
      color: #f59e0b;
    }
    
    .slots-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
      gap: 0.5rem;
    }
    
    .slot {
      background-color: #2c2c2e;
      padding: 0.75rem;
      border-radius: 6px;
      text-align: center;
      font-size: 0.9rem;
      font-weight: 500;
      border: 2px solid #f59e0b;
    }
    
    .actions {
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
    
    .btn-danger {
      background-color: #dc2626;
      color: white;
    }
    
    .btn-danger:hover {
      background-color: #b91c1c;
    }
    
    .rating-section {
      background-color: #404040;
      padding: 1.5rem;
      border-radius: 8px;
      margin-bottom: 2rem;
    }
    
    .rating-display {
      display: flex;
      align-items: center;
      gap: 1rem;
    }
    
    .stars {
      display: flex;
      gap: 0.25rem;
    }
    
    .star {
      color: #f59e0b;
      font-size: 1.25rem;
    }
    
    .star.empty {
      color: #404040;
    }
    
    .review-text {
      margin-top: 1rem;
      padding: 1rem;
      background-color: #2c2c2e;
      border-radius: 6px;
      font-style: italic;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <a href="{{ route('pesanan') }}" class="back-btn">
        ← 
      </a>
      <h1>Detail Booking</h1>
    </div>

    <div class="booking-card">
      <div class="booking-header">
        <div class="venue-info">
          <h2>{{ $booking->venue->name }}</h2>
          <span class="sport-type">{{ $booking->venue->sport->name }}</span>
        </div>
        <div class="status status-{{ $booking->status }}">
          @if($booking->status == 'pending')
            Menunggu Pembayaran
          @elseif($booking->status == 'confirmed')
            Dikonfirmasi
          @elseif($booking->status == 'completed')
            Selesai
          @else
            Dibatalkan
          @endif
        </div>
      </div>

      <div class="booking-details">
        <div class="detail-section">
          <h3>Informasi Booking</h3>
          <div class="detail-row">
            <span>Kode Booking:</span>
            <span class="detail-value">{{ $booking->booking_code }}</span>
          </div>
          <div class="detail-row">
            <span>Tanggal:</span>
            <span class="detail-value">{{ $booking->booking_date->format('d M Y') }}</span>
          </div>
          <div class="detail-row">
            <span>Waktu:</span>
            <span class="detail-value">{{ $booking->start_time }} - {{ $booking->end_time }}</span>
          </div>
          <div class="detail-row">
            <span>Durasi:</span>
            <span class="detail-value">{{ $booking->duration_hours }} jam</span>
          </div>
        </div>

        <div class="detail-section">
          <h3>Informasi Lapangan</h3>
          <div class="detail-row">
            <span>Nama Lapangan:</span>
            <span class="detail-value">{{ $booking->venue->name }}</span>
          </div>
          <div class="detail-row">
            <span>Lokasi:</span>
            <span class="detail-value">{{ $booking->venue->location }}</span>
          </div>
          <div class="detail-row">
            <span>Harga per jam:</span>
            <span class="detail-value">Rp {{ number_format((float)$booking->venue->price_per_hour, 0, ',', '.') }}</span>
          </div>
          <div class="detail-row">
            <span>Total Harga:</span>
            <span class="detail-value">Rp {{ number_format((float)$booking->total_price, 0, ',', '.') }}</span>
          </div>
        </div>
      </div>

      @if($booking->selected_time_slots && is_array($booking->selected_time_slots))
      <div class="time-slots">
        <h3>Slot Waktu Dipilih</h3>
        <div class="slots-grid">
          @foreach($booking->selected_time_slots as $slot)
            <div class="slot">{{ $slot }}</div>
          @endforeach
        </div>
      </div>
      @endif

      @if($booking->status == 'completed' && $booking->rating)
      <div class="rating-section">
        <h3 style="color: #f59e0b; margin-bottom: 1rem;">Rating & Review Anda</h3>
        <div class="rating-display">
          <div class="stars">
            @for($i = 1; $i <= 5; $i++)
              <span class="star {{ $i <= $booking->rating ? '' : 'empty' }}">★</span>
            @endfor
          </div>
          <span class="detail-value">{{ $booking->rating }}/5</span>
        </div>
        @if($booking->review)
        <div class="review-text">
          "{{ $booking->review }}"
        </div>
        @endif
      </div>
      @endif

      <div class="actions">
        @if($booking->status == 'pending')
          <a href="{{ route('booking.pay-now', $booking->id) }}" class="action-btn btn-primary">Bayar Sekarang</a>
          <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="action-btn btn-danger" onclick="return confirm('Yakin ingin membatalkan booking ini?')">Batalkan Booking</button>
          </form>
        @elseif($booking->status == 'confirmed')
          <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="action-btn btn-danger" onclick="return confirm('Yakin ingin membatalkan booking ini?')">Batalkan Booking</button>
          </form>
        @elseif($booking->status == 'completed' && !$booking->rating)
          <a href="{{ route('booking.rating', $booking->id) }}" class="action-btn btn-primary">Beri Rating</a>
        @endif
        
        <a href="{{ route('pesanan') }}" class="action-btn btn-secondary">Kembali ke Pesanan</a>
      </div>
    </div>
  </div>
</body>
</html>
