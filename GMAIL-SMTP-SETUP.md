# 📧 Gmail SMTP Configuration Guide

## ⚙️ Konfigurasi yang Sudah Dibuat:

Konfigurasi `.env` sudah diubah untuk Gmail SMTP:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-gmail@gmail.com        # ← Ganti dengan email Gmail Anda
MAIL_PASSWORD=your-app-password-here      # ← Ganti dengan App Password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@lapangin.com"
MAIL_FROM_NAME="Lapangin"
```

## 🔐 Cara Mendapatkan App Password Gmail:

### Step 1: Enable 2-Factor Authentication
1. Buka [Google Account Settings](https://myaccount.google.com/)
2. Klik **Security** di sidebar kiri
3. Scroll ke **2-Step Verification**
4. Follow instruksi untuk enable 2FA (wajib!)

### Step 2: Generate App Password
1. Setelah 2FA aktif, kembali ke **Security**
2. Cari **App passwords** atau **2-Step Verification**
3. Klik **App passwords**
4. Pilih **Mail** sebagai app type
5. Pilih **Other (custom name)** sebagai device
6. Ketik nama: **Lapangin Laravel App**
7. Klik **Generate**
8. **Copy 16-digit password** yang muncul

### Step 3: Update .env File
Ganti nilai di `.env`:
```env
MAIL_USERNAME=email-gmail-anda@gmail.com
MAIL_PASSWORD=abcd efgh ijkl mnop  # App password 16 digit
```

## 🧪 Test Email Setelah Setup:

Jalankan test script:
```bash
php test_nabil_email.php
```

## ⚠️ Important Notes:

1. **JANGAN gunakan password Gmail biasa** - harus App Password!
2. **2FA wajib aktif** untuk bisa generate App Password
3. **Port 587** untuk TLS (recommended)
4. **Port 465** untuk SSL (alternative)
5. **MAIL_FROM_ADDRESS** bisa tetap `noreply@lapangin.com`

## 🔄 Jika Ada Error:

1. **"Invalid credentials"** → Check App Password
2. **"Connection timeout"** → Check firewall/internet
3. **"SMTP Error"** → Try port 465 dengan SSL
4. **"Authentication failed"** → Pastikan 2FA aktif

## 🎯 Alternative SMTP Providers:

Jika Gmail bermasalah, bisa gunakan:
- **Mailtrap** (untuk testing) ✅ Sudah tested
- **SendGrid** (untuk production)
- **Mailgun** (untuk production)
- **Amazon SES** (untuk production)

## ✅ Ready to Use!

Setelah update username/password, sistem email verification akan langsung bekerja dengan Gmail SMTP!
