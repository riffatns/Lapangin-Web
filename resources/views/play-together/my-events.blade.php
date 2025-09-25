<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Events - Lapangin</title>
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
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 25px 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            color: #2c3e50;
            font-size: 2rem;
            margin-bottom: 5px;
        }

        .header p {
            color: #7f8c8d;
            font-size: 1.1rem;
        }

        .tabs {
            display: flex;
            gap: 0;
            margin-bottom: 30px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 5px;
            backdrop-filter: blur(10px);
        }

        .tab-button {
            flex: 1;
            padding: 15px 20px;
            background: transparent;
            border: none;
            border-radius: 10px;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .tab-button.active {
            background: rgba(255, 255, 255, 0.9);
            color: #2c3e50;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .tab-button:hover:not(.active) {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .event-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .event-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #6366f1, #8b5cf6, #ec4899);
        }

        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .event-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .event-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
            line-height: 1.3;
        }

        .event-sport {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(99, 102, 241, 0.1);
            color: #6366f1;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .event-meta {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 15px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #6b7280;
            font-size: 0.9rem;
        }

        .meta-item i {
            color: #6366f1;
            width: 16px;
        }

        .event-stats {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            margin: 15px 0;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 1.2rem;
            font-weight: 700;
            color: #6366f1;
        }

        .stat-label {
            font-size: 0.8rem;
            color: #9ca3af;
            margin-top: 2px;
        }

        .event-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
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

        .btn-secondary {
            background: rgba(107, 114, 128, 0.1);
            color: #4b5563;
            border: 1px solid rgba(107, 114, 128, 0.2);
        }

        .btn-secondary:hover {
            background: rgba(107, 114, 128, 0.2);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .status-active { background: #dcfce7; color: #166534; }
        .status-full { background: #fef3c7; color: #92400e; }
        .status-completed { background: #f3f4f6; color: #374151; }
        .status-cancelled { background: #fef2f2; color: #dc2626; }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: rgba(255, 255, 255, 0.8);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .empty-state p {
            font-size: 1.1rem;
            margin-bottom: 25px;
        }

        .create-event-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            text-decoration: none;
            padding: 15px 25px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .create-event-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
        }

        @media (max-width: 768px) {
            body { padding: 10px; }
            .events-grid { grid-template-columns: 1fr; }
            .tabs { flex-direction: column; }
            .event-actions { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-calendar-alt"></i> My Events</h1>
            <p>Kelola event yang Anda buat dan event yang Anda ikuti</p>
        </div>

        <div class="tabs">
            <button class="tab-button active" onclick="switchTab('organized')">
                <i class="fas fa-crown"></i>
                Event Saya ({{ $organizedEvents->count() }})
            </button>
            <button class="tab-button" onclick="switchTab('joined')">
                <i class="fas fa-users"></i>
                Event Diikuti ({{ $joinedEvents->count() }})
            </button>
        </div>

        <!-- Organized Events Tab -->
        <div id="organized" class="tab-content active">
            @if($organizedEvents->count() > 0)
                <div class="events-grid">
                    @foreach($organizedEvents as $event)
                        <div class="event-card">
                            <div class="event-header">
                                <div>
                                    <h3 class="event-title">{{ $event->title }}</h3>
                                    @if($event->sport)
                                        <span class="event-sport">
                                            {{ $event->sport->icon ?? '🏃' }} {{ $event->sport->name }}
                                        </span>
                                    @endif
                                </div>
                                @php
                                    $statusClass = 'status-' . $event->status;
                                    $statusText = ucfirst($event->status);
                                    $statusIcon = $event->status == 'active' ? 'play-circle' : 
                                                 ($event->status == 'completed' ? 'check-circle' : 
                                                 ($event->status == 'cancelled' ? 'times-circle' : 'users'));
                                @endphp
                                <span class="status-badge {{ $statusClass }}">
                                    <i class="fas fa-{{ $statusIcon }}"></i>
                                    {{ $statusText }}
                                </span>
                            </div>

                            <div class="event-meta">
                                <div class="meta-item">
                                    <i class="fas fa-calendar"></i>
                                    {{ \Carbon\Carbon::parse($event->scheduled_date)->format('d M Y') }}
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-clock"></i>
                                    {{ \Carbon\Carbon::parse($event->scheduled_time)->format('H:i') }} WIB
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $event->venue ? $event->venue->name : ($event->location ?? 'Lokasi belum ditentukan') }}
                                </div>
                                @if($event->price_per_person > 0)
                                    <div class="meta-item">
                                        <i class="fas fa-money-bill"></i>
                                        Rp {{ number_format($event->price_per_person, 0, ',', '.') }}/orang
                                    </div>
                                @endif
                            </div>

                            <div class="event-stats">
                                <div class="stat-item">
                                    <div class="stat-number">{{ $event->participants->count() }}</div>
                                    <div class="stat-label">Peserta</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number">{{ $event->max_participants }}</div>
                                    <div class="stat-label">Maks</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number">{{ $event->chats->count() ?? 0 }}</div>
                                    <div class="stat-label">Pesan</div>
                                </div>
                            </div>

                            <div class="event-actions">
                                <a href="{{ route('play-together.show', $event) }}" class="btn btn-primary">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                @if($event->status == 'active')
                                    <form action="{{ route('play-together.cancel', $event) }}" method="POST" 
                                          onsubmit="return confirm('Yakin ingin membatalkan event ini?')" style="flex: 1;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" style="width: 100%;">
                                            <i class="fas fa-times"></i> Batal
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary" disabled>
                                        <i class="fas fa-lock"></i> {{ ucfirst($event->status) }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-calendar-plus"></i>
                    <h3>Belum Ada Event</h3>
                    <p>Anda belum membuat event Main Bareng apapun</p>
                    <a href="{{ route('play-together.create') }}" class="create-event-btn">
                        <i class="fas fa-plus"></i>
                        Buat Event Pertama
                    </a>
                </div>
            @endif
        </div>

        <!-- Joined Events Tab -->
        <div id="joined" class="tab-content">
            @if($joinedEvents->count() > 0)
                <div class="events-grid">
                    @foreach($joinedEvents as $participation)
                        @php $event = $participation->playTogether; @endphp
                        <div class="event-card">
                            <div class="event-header">
                                <div>
                                    <h3 class="event-title">{{ $event->title }}</h3>
                                    @if($event->sport)
                                        <span class="event-sport">
                                            {{ $event->sport->icon ?? '🏃' }} {{ $event->sport->name }}
                                        </span>
                                    @endif
                                </div>
                                @php
                                    $statusClass = 'status-' . $event->status;
                                    $statusText = ucfirst($event->status);
                                    $statusIcon = $event->status == 'active' ? 'play-circle' : 
                                                 ($event->status == 'completed' ? 'check-circle' : 
                                                 ($event->status == 'cancelled' ? 'times-circle' : 'users'));
                                @endphp
                                <span class="status-badge {{ $statusClass }}">
                                    <i class="fas fa-{{ $statusIcon }}"></i>
                                    {{ $statusText }}
                                </span>
                            </div>

                            <div class="event-meta">
                                <div class="meta-item">
                                    <i class="fas fa-calendar"></i>
                                    {{ \Carbon\Carbon::parse($event->scheduled_date)->format('d M Y') }}
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-clock"></i>
                                    {{ \Carbon\Carbon::parse($event->scheduled_time)->format('H:i') }} WIB
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $event->venue ? $event->venue->name : ($event->location ?? 'Lokasi belum ditentukan') }}
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-user-crown"></i>
                                    Organizer: {{ $event->organizer ? $event->organizer->name : 'Unknown' }}
                                </div>
                                @if($event->price_per_person > 0)
                                    <div class="meta-item">
                                        <i class="fas fa-money-bill"></i>
                                        Rp {{ number_format($event->price_per_person, 0, ',', '.') }}/orang
                                    </div>
                                @endif
                            </div>

                            <div class="event-stats">
                                <div class="stat-item">
                                    <div class="stat-number">{{ $event->participants->count() }}</div>
                                    <div class="stat-label">Peserta</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number">{{ $event->max_participants }}</div>
                                    <div class="stat-label">Maks</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number">{{ $participation->created_at->diffInDays() }}</div>
                                    <div class="stat-label">Hari lalu</div>
                                </div>
                            </div>

                            <div class="event-actions">
                                <a href="{{ route('play-together.show', $event) }}" class="btn btn-primary">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                @if($event->status == 'active' && $participation->status == 'joined')
                                    <form action="{{ route('play-together.leave', $event) }}" method="POST" 
                                          onsubmit="return confirm('Yakin ingin keluar dari event ini?')" style="flex: 1;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" style="width: 100%;">
                                            <i class="fas fa-sign-out-alt"></i> Keluar
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary" disabled>
                                        <i class="fas fa-info-circle"></i> {{ ucfirst($participation->status) }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-user-friends"></i>
                    <h3>Belum Ikut Event</h3>
                    <p>Anda belum bergabung dengan event Main Bareng apapun</p>
                    <a href="{{ route('komunitas') }}" class="create-event-btn">
                        <i class="fas fa-search"></i>
                        Cari Event
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        function switchTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Remove active class from all tab buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active');
            });
            
            // Show selected tab content
            document.getElementById(tabName).classList.add('active');
            
            // Add active class to clicked tab button
            event.target.classList.add('active');
        }
    </script>
</body>
</html>