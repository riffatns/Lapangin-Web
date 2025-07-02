# 🏟️ Lapangin - Sports Field Booking Platform

![Lapangin Logo](public/img/Lapangin-Black.png)

Lapangin adalah platform booking lapangan olahraga yang memudahkan pengguna untuk mencari, memesan, dan mengelola reservasi lapangan olahraga seperti sepak bola, basket, tenis, dan badminton.

## ✨ Features

### 🎯 Core Features
- **Easy Booking**: Cari dan pesan lapangan olahraga dalam hitungan detik
- **Flexible Times**: Booking per jam atau full day sesuai jadwal Anda
- **Best Prices**: Harga kompetitif dengan penawaran musiman
- **Multi Sports**: Mendukung berbagai jenis lapangan (Football, Basketball, Tennis, Badminton)

### 🔐 Authentication System
- **User Registration**: Pendaftaran akun dengan validasi lengkap
- **User Login**: Sistem login dengan session management
- **Dashboard**: Panel pengguna untuk mengelola booking
- **Profile Management**: Kelola informasi profil pengguna

### 🎨 User Interface
- **Responsive Design**: Tampilan optimal di desktop dan mobile
- **Modern UI**: Design clean dengan animasi smooth
- **Interactive Elements**: Button hover effects dan feedback visual
- **SweetAlert Integration**: Notifikasi yang user-friendly

## 🛠️ Tech Stack

- **Backend**: Laravel 11.x
- **Frontend**: Blade Templates, HTML5, CSS3
- **Database**: SQLite (default) / MySQL
- **Authentication**: Laravel's built-in Auth
- **Notifications**: SweetAlert2
- **Icons**: Emoji-based icons
- **Fonts**: Google Fonts (Inter)

## 📋 Prerequisites

Pastikan sistem Anda sudah terinstall:

- **PHP** >= 8.2
- **Composer** >= 2.0
- **Node.js** >= 18.x (optional, untuk asset compilation)
- **SQLite** / **MySQL** (database)

## 🚀 Installation & Setup

### 1. Clone Repository
```bash
git clone <repository-url>
cd Lapangin
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install NPM dependencies (optional)
npm install
```

### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Configuration

Edit file `.env` untuk konfigurasi database:

**Untuk SQLite (Recommended for development):**
```env
DB_CONNECTION=sqlite
DB_DATABASE=/full/path/to/database/database.sqlite
```

**Untuk MySQL:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lapangin
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Database Migration
```bash
# Create database file (untuk SQLite)
touch database/database.sqlite

# Run migrations
php artisan migrate

# (Optional) Seed database dengan data sample
php artisan db:seed
```

### 6. Storage Link (Optional)
```bash
php artisan storage:link
```

## ▶️ How to Run

### Development Server
```bash
# Start Laravel development server
php artisan serve

# Aplikasi akan berjalan di: http://localhost:8000
```

### Production Deployment
```bash
# Optimize untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Compile assets (jika menggunakan Vite)
npm run build
```

## 📱 Usage Guide

### 1. **Landing Page**
- Kunjungi `http://localhost:8000`
- Klik "Get Started" untuk memulai

### 2. **Registration**
- Klik "Register" di starting page
- Isi form pendaftaran dengan lengkap
- Setelah berhasil, akan muncul SweetAlert dan redirect ke login

### 3. **Login**
- Gunakan email dan password yang sudah didaftarkan
- Setelah login berhasil akan redirect ke dashboard

### 4. **Dashboard**
- Kelola profil dan lihat booking history
- Access menu booking lapangan

## 📁 Project Structure

```
Lapangin/
├── app/
│   ├── Http/Controllers/
│   │   └── AuthController.php          # Authentication logic
│   └── Models/
│       └── User.php                    # User model
├── database/
│   ├── migrations/                     # Database migrations
│   └── database.sqlite                 # SQLite database file
├── public/
│   └── img/                           # Application images
│       ├── Lapangin-Black.png
│       ├── Lapangin-White.png
│       ├── Football-Anime.png
│       └── Basketball-Anime.png
├── resources/
│   └── views/
│       ├── landing.blade.php          # Main landing page
│       ├── startingpage.blade.php     # Get started page
│       ├── register.blade.php         # Registration form
│       ├── login.blade.php            # Login form
│       └── dashboard.blade.php        # User dashboard
├── routes/
│   ├── web.php                        # Web routes
│   └── api.php                        # API routes (future)
└── README.md                          # This file
```

## 🎨 UI Pages

### 🏠 Landing Page (`/`)
- Hero section dengan gambar olahraga
- Feature cards (Easy booking, Flexible times, Best prices)
- Call-to-action section
- Footer dengan informasi perusahaan

### 🚀 Starting Page (`/starting-page`)
- Welcome message
- Tombol Register dan Login
- Footer yang konsisten

### 📝 Register Page (`/register`)
- Form pendaftaran dengan validasi
- SweetAlert notification saat berhasil
- Auto-redirect ke login page

### 🔑 Login Page (`/login`)
- Form login dengan error handling
- Redirect ke dashboard setelah berhasil

### 📊 Dashboard (`/dashboard`)
- Welcome message dengan nama user
- Informasi akun
- Tombol logout

## 🔧 Troubleshooting

### Database Issues
```bash
# Reset database
php artisan migrate:fresh

# Check migration status
php artisan migrate:status
```

### Permission Issues (Linux/Mac)
```bash
# Set proper permissions
chmod -R 755 storage bootstrap/cache
```

### Clear Cache
```bash
# Clear all caches
php artisan optimize:clear

# Clear specific cache
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 Development Notes

### Branch Strategy
- `main`: Production-ready code
- `feature/backend-authentication`: Backend development
- `feature/frontend-improvements`: UI/UX enhancements

### Code Style
- Follow PSR-12 coding standards
- Use meaningful variable names
- Add comments for complex logic

## 🔮 Future Enhancements

- [ ] Real-time booking system
- [ ] Payment gateway integration
- [ ] Mobile app development
- [ ] Admin dashboard
- [ ] Booking calendar
- [ ] Email notifications
- [ ] Review and rating system
- [ ] Multi-language support

## 📄 License

This project is licensed under the MIT License.

## 👥 Team

**Lapangin Development Team**
- Modern sports field booking platform
- Laravel-based architecture
- Clean and responsive UI/UX

---

**Happy Booking! 🏟️⚽🏀🎾🏸**

For support, please contact: support@lapangin.com
