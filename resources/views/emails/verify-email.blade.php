<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Email - Lapangin</title>
    <style>
        body {
            font-family: 'Inter', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            text-align: center;
            padding: 2rem;
        }
        
        .header h1 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 700;
        }
        
        .header p {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
        }
        
        .content {
            padding: 2rem;
        }
        
        .icon {
            text-align: center;
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        
        .message {
            text-align: center;
            margin-bottom: 2rem;
            color: #555;
            line-height: 1.8;
        }
        
        .cta-button {
            text-align: center;
            margin: 2rem 0;
        }
        
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            text-decoration: none;
            padding: 1rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            transition: transform 0.2s ease;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #f59e0b;
            padding: 1rem;
            margin: 1.5rem 0;
            border-radius: 0 8px 8px 0;
        }
        
        .footer {
            background-color: #2c2c2e;
            color: white;
            text-align: center;
            padding: 1.5rem;
            font-size: 0.9rem;
        }
        
        .footer a {
            color: #f59e0b;
            text-decoration: none;
        }
        
        .link-text {
            word-break: break-all;
            font-size: 0.9rem;
            color: #666;
            margin-top: 1rem;
            padding: 1rem;
            background-color: #f8f9fa;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>🏟️ Lapangin</h1>
            <p>Platform Booking Lapangan Olahraga Terpercaya</p>
        </div>
        
        <div class="content">
            <div class="icon">✉️</div>
            
            <h2 style="text-align: center; color: #2c2c2e; margin-bottom: 1rem;">
                Verifikasi Email Anda
            </h2>
            
            <div class="message">
                <p>Halo <strong>{{ $user->name }}</strong>,</p>
                <p>Terima kasih telah mendaftar di Lapangin! Untuk melengkapi proses pendaftaran dan mengamankan akun Anda, silakan verifikasi alamat email Anda dengan mengklik tombol di bawah ini:</p>
            </div>
            
            <div class="cta-button">
                <a href="{{ $verificationUrl }}" class="btn">
                    🔐 Verifikasi Email Saya
                </a>
            </div>
            
            <div class="info-box">
                <strong>🛡️ Mengapa verifikasi email penting?</strong>
                <ul style="margin: 0.5rem 0 0 1rem; padding-left: 0;">
                    <li>Mengamankan akun Anda dari penyalahgunaan</li>
                    <li>Memastikan Anda menerima notifikasi booking</li>
                    <li>Mengaktifkan fitur pemulihan password</li>
                    <li>Memberikan akses penuh ke semua fitur Lapangin</li>
                </ul>
            </div>
            
            <p style="text-align: center; color: #666; font-size: 0.9rem; margin-top: 2rem;">
                Jika tombol di atas tidak berfungsi, Anda dapat menyalin dan menempelkan link berikut ke browser Anda:
            </p>
            
            <div class="link-text">
                {{ $verificationUrl }}
            </div>
            
            <p style="text-align: center; color: #666; font-size: 0.9rem; margin-top: 1.5rem;">
                <strong>⏰ Link ini akan kedaluwarsa dalam 60 menit</strong><br>
                Jika Anda tidak meminta verifikasi ini, abaikan email ini.
            </p>
        </div>
        
        <div class="footer">
            <p>
                <strong>Lapangin</strong> - Booking Lapangan Olahraga Made Easy<br>
                📞 Butuh bantuan? Hubungi kami di <a href="mailto:support@lapangin.com">support@lapangin.com</a>
            </p>
            <p style="margin-top: 1rem; font-size: 0.8rem; opacity: 0.8;">
                © {{ date('Y') }} Lapangin. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
