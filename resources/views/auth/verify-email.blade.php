<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - Lapangin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1a1a1a, #2c2c2e);
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        .verification-container {
            background: linear-gradient(145deg, #2c2c2e, #2a2a2c);
            border-radius: 20px;
            padding: 3rem;
            max-width: 500px;
            width: 100%;
            text-align: center;
            border: 1px solid #404040;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        .email-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
        }
        
        .title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #f59e0b;
        }
        
        .message {
            color: #ccc;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .email-address {
            background: #1a1a1a;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            font-weight: 600;
            color: #f59e0b;
            border: 1px solid #404040;
        }
        
        .btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 1rem;
            margin: 0.5rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.2);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);
        }
        
        .btn-secondary {
            background: linear-gradient(145deg, #404040, #525252);
            color: white;
        }
        
        .btn-secondary:hover {
            background: linear-gradient(145deg, #525252, #6b7280);
            transform: translateY(-2px);
        }
        
        .alert {
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .alert-success {
            background: linear-gradient(145deg, #059669, #047857);
            border: 1px solid #10b981;
            color: white;
        }
        
        .footer-text {
            margin-top: 2rem;
            color: #666;
            font-size: 0.9rem;
        }
        
        .loading {
            opacity: 0.7;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="verification-container">
        <div class="email-icon">📧</div>
        <h1 class="title">Verifikasi Email Anda</h1>
        <p class="message">
            Terima kasih telah mendaftar! Sebelum memulai, bisakah Anda memverifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan melalui email? Jika Anda tidak menerima email tersebut, kami dengan senang hati akan mengirimkan yang lain.
        </p>
        
        <div class="email-address">
            {{ Auth::user()->email }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success">
                <span>✅</span>
                <span>Link verifikasi baru telah dikirim ke alamat email Anda!</span>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                <span>✅</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}" id="resendForm">
            @csrf
            <button type="submit" class="btn btn-primary" id="resendBtn">
                <span>📧</span>
                Kirim Ulang Email Verifikasi
            </button>
        </form>

        <a href="{{ route('profile') }}" class="btn btn-secondary">
            <span>👤</span>
            Kembali ke Profile
        </a>

        <p class="footer-text">
            Tidak menerima email? Periksa folder spam Anda atau coba kirim ulang.
        </p>
    </div>

    <script>
        document.getElementById('resendForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('resendBtn');
            btn.classList.add('loading');
            btn.disabled = true;
            btn.innerHTML = '<span>⏳</span> Mengirim...';
            
            // Re-enable after 5 seconds to prevent spam
            setTimeout(() => {
                btn.classList.remove('loading');
                btn.disabled = false;
                btn.innerHTML = '<span>📧</span> Kirim Ulang Email Verifikasi';
            }, 5000);
        });

        // Show success message if email was sent
        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                background: '#2c2c2e',
                color: '#fff',
                confirmButtonColor: '#f59e0b'
            });
        @endif
    </script>
</body>
</html>
