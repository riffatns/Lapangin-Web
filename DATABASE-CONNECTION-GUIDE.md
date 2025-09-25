# 🗄️ Database Connection Guide

## 📋 Langkah 1: Ambil Data Database dari Render.com

1. **Login ke Render.com Dashboard**
2. **Klik PostgreSQL database** yang sudah Anda buat
3. **Di halaman database, copy informasi berikut:**

### Data yang Dibutuhkan:
```
External Database URL: postgres://username:password@host:port/database
Internal Database URL: postgres://username:password@internal-host:port/database
Database: nama_database
Username: username_database  
Password: password_database
Host: hostname (dari External URL)
Port: 5432
```

## 🔧 Langkah 2: Update File Konfigurasi

### A. Update `render.yaml`

Ganti bagian database di file `render.yaml` dengan data dari Render:

```yaml
envVars:
  # ... existing vars ...
  - key: DB_HOST
    value: "HOSTNAME_DARI_EXTERNAL_URL"
  - key: DB_PORT  
    value: "5432"
  - key: DB_DATABASE
    value: "NAMA_DATABASE"
  - key: DB_USERNAME
    value: "USERNAME_DATABASE"
  - key: DB_PASSWORD
    value: "PASSWORD_DATABASE"
```

### B. Contoh Pengisian:

Jika External Database URL Anda:
```
postgres://myuser:mypass123@dpg-abc123-a.oregon-postgres.render.com:5432/mylapangin
```

Maka isi seperti ini:
```yaml
  - key: DB_HOST
    value: "dpg-abc123-a.oregon-postgres.render.com"
  - key: DB_PORT
    value: "5432" 
  - key: DB_DATABASE
    value: "mylapangin"
  - key: DB_USERNAME
    value: "myuser"
  - key: DB_PASSWORD
    value: "mypass123"
```

## 🔧 Langkah 3: Alternative - Environment Variables di Web Service

**Cara lebih mudah:** Set environment variables langsung di Web Service Render:

1. **Buka Web Service** `lapangin-web` di Render dashboard
2. **Go to Environment** tab
3. **Add environment variables:**

```
DB_CONNECTION=pgsql
DB_HOST=your-database-host
DB_PORT=5432
DB_DATABASE=your-database-name
DB_USERNAME=your-username  
DB_PASSWORD=your-password
```

## 🧪 Langkah 4: Test Connection

Setelah deployment, cek logs untuk memastikan database terkoneksi:

1. **Di Render Dashboard** → Web Service → Logs
2. **Look for:** 
   ```
   ✅ Database migration completed
   ✅ Seeding database
   ✅ Laravel application ready!
   ```

## 🔍 Files yang Sudah Dikonfigurasi:

### ✅ `config/database.php`
```php
'pgsql' => [
    'driver' => 'pgsql',
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '5432'),
    'database' => env('DB_DATABASE', 'laravel'),
    'username' => env('DB_USERNAME', 'root'),
    'password' => env('DB_PASSWORD', ''),
    // ... PostgreSQL settings
],
```

### ✅ `Dockerfile`
```dockerfile
# PostgreSQL extensions installed
RUN docker-php-ext-install pdo pdo_pgsql pgsql
```

### ✅ `docker-entrypoint.sh`
```bash
# Database connection check
until php artisan migrate:status > /dev/null 2>&1; do
    echo "Database not ready, waiting..."
    sleep 5
done
```

## 🚨 Troubleshooting

### Jika Connection Gagal:

1. **Check Host:** Pastikan menggunakan **External Database URL**
2. **Check Port:** Biasanya 5432 untuk PostgreSQL
3. **Check SSL:** Render PostgreSQL butuh SSL connection
4. **Check Firewall:** Database harus accessible dari web service

### Log Errors:
```bash
# Di Render Dashboard → Service → Logs
SQLSTATE[08006] [7] could not connect to server
```

**Solution:** Double-check DB_HOST, DB_USERNAME, DB_PASSWORD

## ✅ Next Steps After Database Connected:

1. **Deploy Web Service** dengan Docker environment
2. **Monitor build logs** untuk database migration
3. **Test aplikasi** di live URL
4. **Verify features:** Main Bareng, Payment, Chat

---

**Need help with specific database details? Share your database connection info (hide password) and I'll help configure it!** 🚀