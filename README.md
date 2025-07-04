# 🏟️ Lapangin - Sports Field Booking Platform

![Lapangin Logo](public/img/Lapangin-White.png)

**Lapangin** adalah platform booking lapangan olahraga modern yang memungkinkan pengguna untuk mencari, memesan, dan mengelola reservasi lapangan olahraga dengan mudah. Platform ini mendukung berbagai jenis olahraga seperti futsal, basket, tenis, dan badminton dengan sistem booking yang fleksibel dan user-friendly.

## ✨ Features

### 🎯 Core Booking System
- **Multi-Slot Booking**: Pilih multiple slot waktu 1 jam dalam satu booking
- **Real-Time Availability**: Status slot real-time (tersedia, booked, lewat waktu)
- **Dynamic Pricing**: Kalkulasi harga otomatis berdasarkan durasi
- **Flexible Scheduling**: Booking per jam dengan kontrol waktu yang akurat
- **Smart Time Management**: Pencegahan booking untuk waktu yang sudah lewat

### 🏟️ Venue Management
- **Comprehensive Venue Info**: Detail lengkap venue dengan galeri foto
- **Facility Listings**: Informasi fasilitas yang tersedia (shower, parking, WiFi, dll)
- **Rating & Review System**: Sistem rating dan review terintegrasi dengan database
- **Venue Categories**: Dukungan untuk berbagai jenis lapangan olahraga
- **Location-Based Search**: Pencarian berdasarkan lokasi dan jenis olahraga

### 💳 Payment & Checkout
- **Streamlined Checkout**: Halaman checkout dengan ringkasan booking
- **Payment Methods**: Multiple pilihan metode pembayaran (UI ready)
- **Payment Status Tracking**: Tracking status pembayaran real-time
- **Success Confirmation**: Halaman konfirmasi setelah pembayaran berhasil

### 🔐 User Authentication & Management
- **Secure Registration**: Sistem pendaftaran dengan validasi lengkap
- **Session Management**: Login system dengan session security
- **User Dashboard**: Panel kontrol untuk mengelola booking dan profil
- **Booking History**: Riwayat lengkap semua booking pengguna
- **Order Management**: Kelola status booking (pending, confirmed, completed)

### 🎨 Modern UI/UX
- **Responsive Design**: Optimal di desktop, tablet, dan mobile
- **Dark Theme**: Interface modern dengan dark mode
- **Interactive Components**: Hover effects, smooth transitions, loading states
- **SweetAlert Integration**: Notifikasi yang elegant dan user-friendly
- **Progressive Enhancement**: Experience yang smooth di semua device

## 🛠️ Tech Stack

- **Backend**: Laravel 11.x (PHP 8.2+)
- **Frontend**: Blade Templates, HTML5, CSS3, JavaScript
- **Database**: SQLite (development) / MySQL (production)
- **Authentication**: Laravel Sanctum & Session-based Auth
- **Notifications**: SweetAlert2 for user feedback
- **Styling**: Custom CSS with CSS Grid & Flexbox
- **Icons**: Modern emoji-based iconography
- **Fonts**: Google Fonts (Inter family)
- **Version Control**: Git with organized branch strategy

## 📋 Prerequisites

Pastikan sistem Anda sudah terinstall:

- **PHP** >= 8.2 with extensions (BCMath, Ctype, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML)
- **Composer** >= 2.0
- **Node.js** >= 18.x (untuk asset compilation)
- **SQLite** / **MySQL** (database engine)
- **Git** (untuk version control)

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

### 5. Database Setup & Seeding
```bash
# Create database file (untuk SQLite)
touch database/database.sqlite

# Run migrations untuk membuat tabel
php artisan migrate

# Seed database dengan data sample (venues, sports, dll)
php artisan db:seed

# (Optional) Seed data review/rating untuk testing
php artisan db:seed --class=ReviewSeeder
```
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

### 1. **Landing Page & Registration**
- Kunjungi `http://localhost:8000`
- Klik "Get Started" untuk memulai
- Daftar akun baru atau login dengan akun yang sudah ada

### 2. **Dashboard & Venue Discovery**
- Akses dashboard setelah login berhasil
- Browse venues berdasarkan kategori olahraga
- Filter venues berdasarkan lokasi, harga, atau rating

### 3. **Booking Process**
- Pilih venue yang diinginkan
- Tentukan tanggal booking
- Pilih multiple slot waktu (1 jam per slot)
- Review total harga dan durasi
- Proceed to checkout

### 4. **Payment & Confirmation**
- Review booking summary di halaman checkout
- Pilih metode pembayaran (UI siap, integrasi gateway dalam development)
- Konfirmasi pembayaran
- Terima konfirmasi booking

### 5. **Order Management**
- Kelola semua booking di halaman "Pesanan"
- Track status booking (pending, confirmed, completed)
- Cancel booking jika diperlukan (sesuai kebijakan venue)

## 🎨 Key Pages & Features

### 🏠 Landing Page (`/`)
- Modern hero section dengan value proposition
- Feature showcase dengan animasi
- Call-to-action untuk registrasi
- Responsive footer

### 🚀 Starting Page (`/starting-page`)
- Welcome screen dengan branding
- Clean navigation ke register/login
- Consistent design system

### 📝 Authentication Pages
- **Register** (`/register`): Form pendaftaran dengan validasi real-time
- **Login** (`/login`): Secure login dengan error handling
- **Dashboard** (`/dashboard`): User control panel dengan venue discovery

### �️ Venue Pages
- **Venue Detail** (`/venue/{id}`): Comprehensive venue information dengan booking system
- **Multi-slot Booking**: Interactive time slot selection
- **Real-time Availability**: Dynamic slot status updates
- **Responsive Gallery**: Image gallery dengan thumbnail navigation

### � Checkout Flow
- **Booking Checkout** (`/booking/checkout`): Payment interface dengan booking summary
- **Payment Success** (`/payment/success`): Confirmation page dengan booking details
- **Order History** (`/pesanan`): Complete booking management interface

## 🧪 Testing & Development

### � Testing Scripts (dalam folder `testing/`)
- `create_test_booking.php`: Script untuk membuat booking dummy
- `clean_test_data.php`: Script untuk cleanup data testing
- `test_booking_flow.php`: End-to-end testing booking flow
- `check_ratings.php`: Verifikasi sistem rating dan review

### � Development Commands
```bash
# Run development server
php artisan serve

# Reset database dengan fresh data
php artisan migrate:fresh --seed

# Generate test data
php artisan db:seed --class=ReviewSeeder

# Clear application cache
php artisan optimize:clear
```

## 🔧 Troubleshooting

### Database Issues
```bash
# Reset database dengan data fresh
php artisan migrate:fresh --seed

# Check migration status
php artisan migrate:status

# Repair corrupted database (SQLite)
php artisan migrate:refresh
```

### Cache Issues
```bash
# Clear all application caches
php artisan optimize:clear

# Clear specific caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

### Permission Issues (Linux/Mac)
```bash
# Set proper permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Booking System Issues
```bash
# Reset booking test data
php -f testing/clean_test_data.php

# Regenerate venue ratings
php artisan db:seed --class=ReviewSeeder

# Check time slot calculations
php -f testing/check_ratings.php
```

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 Development Notes

### Branch Strategy
- `main`: Production-ready code dengan semua fitur terintegrasi
- `feature/backend-authentication`: Backend development & API
- `feature/frontend-enhancements`: UI/UX improvements & responsive design

### Code Organization
- **Controllers**: Modular dengan separation of concerns
- **Models**: Eloquent relationships untuk data integrity
- **Views**: Blade components dengan reusable elements
- **Migrations**: Database versioning dengan proper indexing
- **Seeders**: Realistic test data untuk development

### Code Standards
- Follow PSR-12 coding standards
- Use meaningful variable names dan function naming
- Comment complex business logic
- Maintain consistent indentation (2 spaces)
- Use type hints where appropriate

## � Current Status & Features

### ✅ Completed Features
- [x] User authentication & registration system
- [x] Venue discovery dengan filtering
- [x] Multi-slot booking system
- [x] Real-time slot availability checking
- [x] Dynamic pricing calculation
- [x] Rating & review system
- [x] Responsive UI/UX design
- [x] Booking checkout flow (UI ready)
- [x] Payment success confirmation
- [x] Order management & history
- [x] Comprehensive testing scripts

### 🔮 Upcoming Features
- [ ] Real payment gateway integration (Midtrans/GoPay)
- [ ] Email notification system
- [ ] Admin dashboard untuk venue management
- [ ] Advanced filtering & search
- [ ] Booking reminder notifications
- [ ] User favorites & recommendations
- [ ] Mobile app development
- [ ] Multi-language support
- [ ] Booking analytics & reporting

## 📄 License

This project is licensed under the MIT License.

## 👥 Team

**Lapangin Development Team**
- Modern sports field booking platform
- Laravel-based architecture with modern UI/UX
- Full-featured booking system dengan payment integration

---

**Happy Booking! 🏟️⚽🏀🎾🏸**

🌟 **Experience the future of sports field booking with Lapangin!**

For support & feedback: support@lapangin.com
