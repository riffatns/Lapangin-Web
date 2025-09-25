<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Event Main Bareng - Lapangin</title>
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
            max-width: 800px;
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

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .form-grid {
            display: grid;
            gap: 25px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 12px 15px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .checkbox-group input[type="checkbox"] {
            width: auto;
            margin: 0;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
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

        .price-section {
            background: rgba(243, 244, 246, 0.5);
            padding: 20px;
            border-radius: 12px;
            margin-top: 10px;
        }

        .skill-section {
            background: rgba(239, 246, 255, 0.8);
            padding: 20px;
            border-radius: 12px;
            margin-top: 10px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        @media (max-width: 768px) {
            body { padding: 10px; }
            .form-row { grid-template-columns: 1fr; }
            .form-actions { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-plus-circle"></i> Buat Event Main Bareng</h1>
            <p>Buat event olahraga dan ajak orang lain untuk bermain bersama</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <div class="form-container">
            <form method="POST" action="{{ route('play-together.store') }}">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="title">Judul Event *</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required
                               placeholder="Contoh: Badminton Sore Hari - Cari Partner">
                        @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Deskripsi Event *</label>
                        <textarea id="description" name="description" required
                                  placeholder="Jelaskan detail event, aturan main, atau hal-hal yang perlu diketahui peserta...">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="sport_id">Olahraga *</label>
                            <select id="sport_id" name="sport_id" required>
                                <option value="">Pilih Olahraga</option>
                                @foreach($sports as $sport)
                                    <option value="{{ $sport->id }}" {{ old('sport_id') == $sport->id ? 'selected' : '' }}>
                                        {{ $sport->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sport_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="venue_id">Lokasi/Venue</label>
                            <select id="venue_id" name="venue_id">
                                <option value="">Pilih Venue (Opsional)</option>
                                @foreach($venues as $venue)
                                    <option value="{{ $venue->id }}" {{ old('venue_id') == $venue->id ? 'selected' : '' }}>
                                        {{ $venue->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('venue_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="location">Lokasi Alternatif</label>
                        <input type="text" id="location" name="location" value="{{ old('location') }}"
                               placeholder="Jika tidak memilih venue, sebutkan lokasi secara manual">
                        @error('location')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="scheduled_date">Tanggal *</label>
                            <input type="date" id="scheduled_date" name="scheduled_date" value="{{ old('scheduled_date') }}" required>
                            @error('scheduled_date')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="scheduled_time">Waktu *</label>
                            <input type="time" id="scheduled_time" name="scheduled_time" value="{{ old('scheduled_time') }}" required>
                            @error('scheduled_time')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="max_participants">Maksimal Peserta *</label>
                            <input type="number" id="max_participants" name="max_participants" value="{{ old('max_participants', 4) }}" 
                                   min="2" max="50" required>
                            @error('max_participants')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="skill_level">Level Skill *</label>
                            <select id="skill_level" name="skill_level" required>
                                <option value="">Pilih Level</option>
                                <option value="beginner" {{ old('skill_level') == 'beginner' ? 'selected' : '' }}>Pemula</option>
                                <option value="intermediate" {{ old('skill_level') == 'intermediate' ? 'selected' : '' }}>Menengah</option>
                                <option value="advanced" {{ old('skill_level') == 'advanced' ? 'selected' : '' }}>Mahir</option>
                                <option value="professional" {{ old('skill_level') == 'professional' ? 'selected' : '' }}>Profesional</option>
                            </select>
                            @error('skill_level')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="price_per_person">Harga per Orang (Rp)</label>
                        <input type="number" id="price_per_person" name="price_per_person" value="{{ old('price_per_person', 0) }}" 
                               min="0" step="1000" placeholder="0 untuk gratis">
                        @error('price_per_person')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('komunitas') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Buat Event
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Auto-set minimum date to today
        document.getElementById('scheduled_date').min = new Date().toISOString().split('T')[0];
        
        // Price formatting
        document.getElementById('price_per_person').addEventListener('input', function(e) {
            let value = e.target.value;
            if (value) {
                // Remove non-digits and format
                value = value.replace(/\D/g, '');
                e.target.value = value;
            }
        });
    </script>
</body>
</html>