<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Bareng - Lapangin</title>
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

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .page-title h1 {
            color: #2c3e50;
            font-size: 2rem;
            margin-bottom: 5px;
        }

        .page-title p {
            color: #7f8c8d;
            font-size: 1.1rem;
        }

        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
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
            border: 2px solid rgba(107, 114, 128, 0.2);
        }

        .btn-secondary:hover {
            background: rgba(107, 114, 128, 0.2);
            transform: translateY(-1px);
        }

        .filters-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .filter-group {
            position: relative;
        }

        .filter-group label {
            display: block;
            margin-bottom: 8px;
            color: #374151;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .filter-group select,
        .filter-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 0.95rem;
            background: white;
            transition: all 0.3s ease;
        }

        .filter-group select:focus,
        .filter-group input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .search-box {
            position: relative;
            grid-column: 1 / -1;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }

        .search-box input {
            padding-left: 45px;
        }

        .filter-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
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
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
        }

        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .event-header {
            padding: 20px 25px 15px;
            position: relative;
        }

        .event-sport {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .event-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
            line-height: 1.3;
        }

        .event-organizer {
            color: #6b7280;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .event-details {
            padding: 0 25px 15px;
        }

        .event-info {
            display: grid;
            gap: 10px;
            margin-bottom: 15px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #4b5563;
            font-size: 0.9rem;
        }

        .info-item i {
            width: 16px;
            color: #6366f1;
        }

        .event-description {
            color: #6b7280;
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .event-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 25px;
            background: rgba(243, 244, 246, 0.5);
            border-top: 1px solid rgba(229, 231, 235, 0.5);
        }

        .participants-info {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #374151;
            font-size: 0.9rem;
        }

        .participants-count {
            display: flex;
            align-items: center;
            gap: 4px;
            background: rgba(99, 102, 241, 0.1);
            color: #6366f1;
            padding: 4px 8px;
            border-radius: 8px;
            font-weight: 600;
        }

        .skill-level {
            padding: 4px 8px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: capitalize;
        }

        .skill-beginner { background: #dbeafe; color: #1d4ed8; }
        .skill-intermediate { background: #fef3c7; color: #d97706; }
        .skill-advanced { background: #fecaca; color: #dc2626; }
        .skill-professional { background: #e5e7eb; color: #374151; }

        .event-price {
            font-weight: 700;
            color: #059669;
            font-size: 1.1rem;
        }

        .event-footer {
            padding: 15px 25px;
            display: flex;
            gap: 10px;
        }

        .btn-event {
            flex: 1;
            text-align: center;
            padding: 10px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-view {
            background: rgba(99, 102, 241, 0.1);
            color: #6366f1;
            border: 2px solid rgba(99, 102, 241, 0.2);
        }

        .btn-view:hover {
            background: rgba(99, 102, 241, 0.2);
        }

        .btn-join {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .btn-join:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .empty-state i {
            font-size: 4rem;
            color: #d1d5db;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            color: #374151;
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #6b7280;
            margin-bottom: 25px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 30px;
        }

        .pagination a,
        .pagination span {
            padding: 10px 15px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            text-decoration: none;
            color: #374151;
            transition: all 0.3s ease;
        }

        .pagination a:hover {
            background: #6366f1;
            color: white;
            transform: translateY(-1px);
        }

        .pagination .active {
            background: #6366f1;
            color: white;
        }

        @media (max-width: 768px) {
            body { padding: 10px; }
            
            .header-content {
                flex-direction: column;
                text-align: center;
            }
            
            .filters-grid {
                grid-template-columns: 1fr;
            }
            
            .events-grid {
                grid-template-columns: 1fr;
            }
            
            .filter-actions {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <div class="page-title">
                    <h1><i class="fas fa-users-between-lines"></i> Main Bareng</h1>
                    <p>Temukan teman bermain olahraga di sekitar Anda</p>
                </div>
                <div class="header-actions">
                    <a href="{{ route('play-together.my-events') }}" class="btn btn-secondary">
                        <i class="fas fa-calendar-check"></i> Event Saya
                    </a>
                    <a href="{{ route('play-together.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Buat Event
                    </a>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <form method="GET" action="{{ route('play-together.index') }}" class="filters-section">
            <div class="filters-grid">
                <div class="filter-group">
                    <label for="sport_id">Olahraga</label>
                    <select name="sport_id" id="sport_id">
                        <option value="">Semua Olahraga</option>
                        @foreach($sports as $sport)
                            <option value="{{ $sport->id }}" {{ request('sport_id') == $sport->id ? 'selected' : '' }}>
                                {{ $sport->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label for="venue_id">Lokasi</label>
                    <select name="venue_id" id="venue_id">
                        <option value="">Semua Lokasi</option>
                        @foreach($venues as $venue)
                            <option value="{{ $venue->id }}" {{ request('venue_id') == $venue->id ? 'selected' : '' }}>
                                {{ $venue->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label for="date">Tanggal</label>
                    <input type="date" name="date" id="date" value="{{ request('date') }}">
                </div>

                <div class="filter-group">
                    <label for="skill_level">Level Skill</label>
                    <select name="skill_level" id="skill_level">
                        <option value="">Semua Level</option>
                        <option value="beginner" {{ request('skill_level') == 'beginner' ? 'selected' : '' }}>Pemula</option>
                        <option value="intermediate" {{ request('skill_level') == 'intermediate' ? 'selected' : '' }}>Menengah</option>
                        <option value="advanced" {{ request('skill_level') == 'advanced' ? 'selected' : '' }}>Mahir</option>
                        <option value="professional" {{ request('skill_level') == 'professional' ? 'selected' : '' }}>Profesional</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="max_cost">Budget Maksimal</label>
                    <input type="number" name="max_cost" id="max_cost" placeholder="Rp 0" value="{{ request('max_cost') }}">
                </div>

                <div class="filter-group search-box">
                    <label for="search">Cari Event</label>
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" id="search" placeholder="Cari berdasarkan judul atau deskripsi..." value="{{ request('search') }}">
                </div>
            </div>

            <div class="filter-actions">
                <a href="{{ route('play-together.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Reset
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </div>
        </form>

        <!-- Events Grid -->
        @if($events->count() > 0)
            <div class="events-grid">
                @foreach($events as $event)
                    <div class="event-card">
                        <div class="event-header">
                            <div class="event-sport">
                                <i class="fas fa-{{ $event->sport->icon ?? 'running' }}"></i>
                                {{ $event->sport->name }}
                            </div>
                            <h3 class="event-title">{{ $event->title }}</h3>
                            <div class="event-organizer">
                                <i class="fas fa-user-crown"></i>
                                {{ $event->organizer->name }}
                            </div>
                        </div>

                        <div class="event-details">
                            <div class="event-info">
                                <div class="info-item">
                                    <i class="fas fa-calendar"></i>
                                    <span>{{ $event->scheduled_time->format('d M Y, H:i') }}</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $event->venue->name }}</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-clock"></i>
                                    <span>{{ $event->duration_hours }}h durasi</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-trophy"></i>
                                    <span class="skill-level skill-{{ $event->required_skill_level }}">
                                        {{ ucfirst($event->required_skill_level) }}
                                    </span>
                                </div>
                            </div>

                            <p class="event-description">{{ $event->description }}</p>
                        </div>

                        <div class="event-meta">
                            <div class="participants-info">
                                <div class="participants-count">
                                    <i class="fas fa-users"></i>
                                    <span>{{ $event->participants->count() }}/{{ $event->max_participants }}</span>
                                </div>
                            </div>
                            
                            <div class="event-price">
                                @if($event->is_paid_event)
                                    Rp {{ number_format($event->price_per_person, 0, ',', '.') }}
                                @else
                                    Gratis
                                @endif
                            </div>
                        </div>

                        <div class="event-footer">
                            <a href="{{ route('play-together.show', $event->id) }}" class="btn-event btn-view">
                                <i class="fas fa-eye"></i> Lihat Detail
                            </a>
                            @if($event->participants->count() < $event->max_participants)
                                <a href="{{ route('play-together.show', $event->id) }}" class="btn-event btn-join">
                                    <i class="fas fa-handshake"></i> Bergabung
                                </a>
                            @else
                                <span class="btn-event" style="background: #f3f4f6; color: #9ca3af;">
                                    <i class="fas fa-users"></i> Penuh
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="pagination">
                {{ $events->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-calendar-times"></i>
                <h3>Belum Ada Event</h3>
                <p>Tidak ada event "Main Bareng" yang tersedia saat ini.</p>
                <a href="{{ route('play-together.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Buat Event Pertama
                </a>
            </div>
        @endif
    </div>

    <script>
        // Auto-submit form when filters change
        document.querySelectorAll('select[name], input[name="date"], input[name="max_cost"]').forEach(element => {
            element.addEventListener('change', function() {
                this.form.submit();
            });
        });

        // Debounced search
        let searchTimeout;
        document.getElementById('search').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                this.form.submit();
            }, 500);
        });
    </script>
</body>
</html>