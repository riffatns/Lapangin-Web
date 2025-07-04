# Testing Scripts untuk Lapangin Booking System

Folder ini berisi berbagai script untuk testing fitur booking system.

## File yang Tersedia

### 1. `create_test_bookings.php`
Script sederhana untuk membuat booking test untuk tanggal 4 dan 5 Juli 2025.

**Cara Pakai:**
```bash
php testing/create_test_bookings.php
```

### 2. `create_comprehensive_test_bookings.php`
Script lengkap untuk membuat berbagai skenario test booking:
- Booking untuk hari ini (beberapa slot sudah lewat)
- Booking untuk besok dan lusa
- Booking dengan durasi berbeda (1-3 jam)
- Booking di waktu yang berbeda (pagi, siang, sore, malam)

**Cara Pakai:**
```bash
php testing/create_comprehensive_test_bookings.php
```

### 3. `clean_test_bookings.php`
Script untuk menghapus semua booking test dari database.

**Cara Pakai:**
```bash
php testing/clean_test_bookings.php
```

### 4. `test_booking_status.php`
Script untuk menampilkan laporan status booking dan melakukan simulasi test API endpoint.

**Cara Pakai:**
```bash
php testing/test_booking_status.php
```

## Skenario Testing

### Test Case 1: Slot Status Hari Ini
1. Jalankan `create_comprehensive_test_bookings.php`
2. Buka halaman detail venue
3. Verifikasi:
   - Slot yang sudah lewat tampil abu-abu (past)
   - Slot yang sudah dibooking tampil merah (booked)
   - Slot yang tersedia tampil normal

### Test Case 2: Dynamic Date Change
1. Di halaman detail venue, ubah tanggal booking
2. Verifikasi:
   - Slot status berubah sesuai tanggal yang dipilih
   - Loading state tampil saat AJAX request
   - Error handling jika request gagal

### Test Case 3: Multi-Slot Booking
1. Pilih beberapa slot waktu yang tersedia
2. Verifikasi:
   - Durasi dan harga terupdate otomatis
   - Slot yang dipilih tampil dengan highlight
   - Booking berhasil dengan semua slot tersimpan

### Test Case 4: Error Scenarios
1. Coba klik slot yang sudah dibooking
2. Coba klik slot yang sudah lewat
3. Verifikasi alert/popup error tampil

## Fitur yang Ditest

### ✅ Implemented
- [x] Multiple slot selection (1-hour slots)
- [x] Dynamic price calculation based on selected slots
- [x] Visual distinction for slot status (available/booked/past)
- [x] AJAX update when booking date changes
- [x] Real-time slot availability from database
- [x] Responsive booking card layout
- [x] Error handling for unavailable slots
- [x] Booking submission with multiple slots

### 🔄 Next Steps
- [ ] Payment integration
- [ ] Email notifications
- [ ] Booking confirmation page
- [ ] Admin booking management
- [ ] Booking history with filters
- [ ] Mobile app optimization

## Database Schema

Booking model menggunakan field:
- `selected_time_slots`: Array JSON berisi slot waktu yang dipilih
- `duration_hours`: Total durasi dalam jam
- `booking_date`: Tanggal booking
- `status`: Status booking (confirmed, cancelled, pending)

## API Endpoints

### GET `/venue/{venue}/booking-data`
Parameter:
- `date`: Tanggal yang ingin dicek (Y-m-d format)

Response:
```json
{
  "timeSlots": {...},
  "bookedSlots": [...],
  "pastSlots": [...],
  "selectedDate": "2025-07-03",
  "today": "2025-07-03",
  "currentTime": "14:30"
}
```

## Troubleshooting

### Jika slot tidak update saat ganti tanggal:
1. Check browser console untuk error JavaScript
2. Verify CSRF token tersedia di meta tag
3. Check Laravel log untuk error di backend
4. Test API endpoint langsung di browser

### Jika booking gagal:
1. Check semua required field terisi
2. Verify booking_code unique
3. Check database constraint dan validation
4. Test dengan data minimal dulu

## Environment Requirements

- PHP 8.1+
- Laravel 10+
- MySQL/SQLite database
- Browser dengan JavaScript enabled
