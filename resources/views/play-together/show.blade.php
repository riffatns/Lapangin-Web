<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $playTogether->title }} - Detail Event</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .back-nav {
            margin-bottom: 20px;
        }

        .back-nav a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: white;
            text-decoration: none;
            font-weight: 500;
            padding: 10px 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .back-nav a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .event-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .event-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #6366f1, #8b5cf6, #ec4899);
        }

        .event-title {
            font-size: 2.2rem;
            color: #2c3e50;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .event-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #4b5563;
            font-weight: 500;
        }

        .meta-item i {
            color: #6366f1;
            width: 20px;
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-active { background: #dcfce7; color: #166534; }
        .status-full { background: #fef3c7; color: #92400e; }
        .status-completed { background: #f3f4f6; color: #374151; }
        .status-cancelled { background: #fef2f2; color: #dc2626; }

        .main-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .content-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 1.4rem;
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .description {
            line-height: 1.6;
            color: #4b5563;
            font-size: 1.05rem;
            margin-bottom: 25px;
        }

        .info-grid {
            display: grid;
            gap: 15px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #374151;
        }

        .info-value {
            color: #6b7280;
            font-weight: 500;
        }

        .participants-section {
            margin-bottom: 30px;
        }

        .participants-grid {
            display: grid;
            gap: 15px;
        }

        .participant-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            background: rgba(243, 244, 246, 0.7);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .participant-card:hover {
            background: rgba(229, 231, 235, 0.8);
            transform: translateY(-2px);
        }

        .participant-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .participant-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .participant-details h4 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .participant-details p {
            color: #6b7280;
            font-size: 0.9rem;
        }

        .participant-badge {
            padding: 4px 8px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .organizer-badge { background: #fef3c7; color: #92400e; }
        .member-badge { background: #dcfce7; color: #166534; }
        .pending-badge { background: #fef2f2; color: #dc2626; }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
            flex: 1;
            justify-content: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
        }

        .btn-secondary {
            background: rgba(107, 114, 128, 0.1);
            color: #4b5563;
            border: 2px solid rgba(107, 114, 128, 0.2);
        }

        .btn-secondary:hover {
            background: rgba(107, 114, 128, 0.2);
            transform: translateY(-1px);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        .chat-section {
            margin-top: 30px;
        }

        .chat-messages {
            max-height: 300px;
            overflow-y: auto;
            background: rgba(249, 250, 251, 0.8);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .chat-message {
            margin-bottom: 15px;
            padding: 10px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .chat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }

        .chat-sender {
            font-weight: 600;
            color: #2c3e50;
        }

        .chat-time {
            font-size: 0.8rem;
            color: #9ca3af;
        }

        .chat-content {
            color: #4b5563;
            line-height: 1.4;
        }

        .chat-form {
            display: flex;
            gap: 10px;
        }

        .chat-input {
            flex: 1;
            padding: 10px 15px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            resize: none;
        }

        .chat-input:focus {
            outline: none;
            border-color: #6366f1;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #9ca3af;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            body { padding: 10px; }
            .main-content { grid-template-columns: 1fr; }
            .event-meta { grid-template-columns: 1fr; }
            .action-buttons { flex-direction: column; }
            .event-title { font-size: 1.8rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="back-nav">
            <a href="{{ route('komunitas') }}">
                <i class="fas fa-arrow-left"></i> Kembali ke Komunitas
            </a>
        </div>

        <div class="event-header">
            <h1 class="event-title">{{ $playTogether->title }}</h1>
            
            <div class="event-meta">
                <div class="meta-item">
                    <i class="fas fa-calendar"></i>
                    {{ \Carbon\Carbon::parse($playTogether->scheduled_date)->format('d M Y') }}
                </div>
                <div class="meta-item">
                    <i class="fas fa-clock"></i>
                    {{ \Carbon\Carbon::parse($playTogether->scheduled_time)->format('H:i') }} WIB
                </div>
                <div class="meta-item">
                    <i class="fas fa-users"></i>
                    {{ $playTogether->participants->count() }}/{{ $playTogether->max_participants }} peserta
                </div>
                <div class="meta-item">
                    <i class="fas fa-trophy"></i>
                    {{ ucfirst($playTogether->skill_level) }}
                </div>
            </div>

            @php
                $isFull = $playTogether->participants->count() >= $playTogether->max_participants;
                $isParticipant = $playTogether->participants->contains('user_id', auth()->id());
                $isOrganizer = $playTogether->organizer_id == auth()->id() && $playTogether->organizer_type == 'App\\Models\\User';
            @endphp

            <div style="margin-top: 15px;">
                @if($playTogether->status == 'active')
                    <span class="status-badge status-active">
                        <i class="fas fa-play-circle"></i> Aktif
                    </span>
                @elseif($playTogether->status == 'full')
                    <span class="status-badge status-full">
                        <i class="fas fa-users"></i> Penuh
                    </span>
                @elseif($playTogether->status == 'completed')
                    <span class="status-badge status-completed">
                        <i class="fas fa-check-circle"></i> Selesai
                    </span>
                @elseif($playTogether->status == 'cancelled')
                    <span class="status-badge status-cancelled">
                        <i class="fas fa-times-circle"></i> Dibatalkan
                    </span>
                @endif
            </div>
        </div>

        <div class="main-content">
            <div class="content-section">
                <h2 class="section-title">
                    <i class="fas fa-info-circle"></i> Detail Event
                </h2>
                
                <div class="description">
                    {{ $playTogether->description }}
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Olahraga</span>
                        <span class="info-value">
                            {{ $playTogether->sport ? $playTogether->sport->name : 'Tidak ditentukan' }}
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Lokasi</span>
                        <span class="info-value">
                            {{ $playTogether->venue ? $playTogether->venue->name : $playTogether->location ?: 'Tidak ditentukan' }}
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Harga per Orang</span>
                        <span class="info-value">
                            @if($playTogether->price_per_person > 0)
                                Rp {{ number_format((float)$playTogether->price_per_person, 0, ',', '.') }}
                            @else
                                Gratis
                            @endif
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Dibuat</span>
                        <span class="info-value">
                            {{ $playTogether->created_at->format('d M Y, H:i') }}
                        </span>
                    </div>
                </div>

                @if(auth()->check() && ($isParticipant || $isOrganizer))
                    <div class="chat-section">
                        <h3 class="section-title">
                            <i class="fas fa-comments"></i> Chat Grup
                        </h3>
                        
                        <div class="chat-messages" id="chatMessages">
                            @forelse($playTogether->chats()->with('user')->latest()->take(10)->get()->reverse() as $chat)
                                <div class="chat-message">
                                    <div class="chat-header">
                                        <span class="chat-sender">{{ $chat->user->name }}</span>
                                        <span class="chat-time">{{ $chat->created_at->format('H:i') }}</span>
                                    </div>
                                    <div class="chat-content">{{ $chat->message }}</div>
                                </div>
                            @empty
                                <div class="empty-state">
                                    <i class="fas fa-comment-slash"></i>
                                    <p>Belum ada pesan</p>
                                </div>
                            @endforelse
                        </div>

                        <form action="{{ route('play-together.chat.send', $playTogether) }}" method="POST" class="chat-form">
                            @csrf
                            <textarea name="message" class="chat-input" placeholder="Tulis pesan..." rows="2" required></textarea>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <div class="content-section">
                <h2 class="section-title">
                    <i class="fas fa-users"></i> Peserta ({{ $playTogether->participants->count() }})
                </h2>

                <div class="participants-grid">
                    <!-- Organizer -->
                    @if($playTogether->organizer)
                        <div class="participant-card">
                            <div class="participant-info">
                                <div class="participant-avatar">
                                    {{ strtoupper(substr($playTogether->organizer->name, 0, 1)) }}
                                </div>
                                <div class="participant-details">
                                    <h4>{{ $playTogether->organizer->name }}</h4>
                                    <p>Organizer</p>
                                </div>
                            </div>
                            <span class="participant-badge organizer-badge">Organizer</span>
                        </div>
                    @endif

                    <!-- Participants -->
                    @foreach($playTogether->participants as $participant)
                        <div class="participant-card">
                            <div class="participant-info">
                                <div class="participant-avatar">
                                    {{ strtoupper(substr($participant->user->name, 0, 1)) }}
                                </div>
                                <div class="participant-details">
                                    <h4>{{ $participant->user->name }}</h4>
                                    <p>Bergabung {{ $participant->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <span class="participant-badge member-badge">Peserta</span>
                        </div>
                    @endforeach

                    @if($playTogether->participants->count() == 0)
                        <div class="empty-state">
                            <i class="fas fa-user-plus"></i>
                            <p>Belum ada peserta yang bergabung</p>
                        </div>
                    @endif
                </div>

                @auth
                    <div class="action-buttons">
                        @if($isOrganizer)
                            <form action="{{ route('play-together.cancel', $playTogether) }}" method="POST" 
                                  onsubmit="return confirm('Yakin ingin membatalkan event ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" 
                                        {{ $playTogether->status != 'active' ? 'disabled' : '' }}>
                                    <i class="fas fa-times"></i> Batalkan Event
                                </button>
                            </form>
                        @elseif($isParticipant)
                            @if($playTogether->price_per_person > 0)
                                <a href="{{ route('play-together.payment', $playTogether) }}" class="btn btn-success">
                                    <i class="fas fa-credit-card"></i> Payment
                                </a>
                            @endif
                            <form action="{{ route('play-together.leave', $playTogether) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin keluar dari event ini?')" style="flex: 1;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="width: 100%;">
                                    <i class="fas fa-sign-out-alt"></i> Keluar
                                </button>
                            </form>
                        @elseif(!$isFull && $playTogether->status == 'active')
                            <form action="{{ route('play-together.join', $playTogether) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-plus"></i> Bergabung
                                </button>
                            </form>
                        @else
                            <button class="btn btn-secondary" disabled>
                                <i class="fas fa-users"></i> 
                                {{ $isFull ? 'Event Penuh' : 'Event Tidak Aktif' }}
                            </button>
                        @endif
                    </div>
                @else
                    <div class="action-buttons">
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt"></i> Login untuk Bergabung
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <script>
        // Auto-scroll chat to bottom
        const chatMessages = document.getElementById('chatMessages');
        if (chatMessages) {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Auto-refresh chat every 30 seconds
        setInterval(() => {
            if (document.querySelector('.chat-section')) {
                fetch(window.location.href + '/chat')
                    .then(response => response.json())
                    .then(data => {
                        // Update chat messages if needed
                        // Implementation depends on your chat update strategy
                    })
                    .catch(error => console.log('Chat refresh error:', error));
            }
        }, 30000);
    </script>
</body>
</html>