# Lapangin - Render.com Deployment Guide

## Persiapan Deployment

### 1. Persiapan Repository Git
Pastikan kode sudah di push ke GitHub/GitLab:
```bash
git add .
git commit -m "Prepare for Render deployment"
git push origin main
```

### 2. Account Render.com
- Daftar di https://render.com
- Connect GitHub/GitLab account Anda

## Deployment Steps (Web Interface - Recommended)

### Method 1: Deploy via Render Dashboard

1. **Login ke Render.com:**
   - Buka https://render.com
   - Login dengan GitHub/GitLab account

2. **Create New Web Service:**
   - Click "New +" → "Web Service"
   - Connect your repository (Lapangin-Web)
   - Branch: `main`

3. **Configure Service:**
   ```
   Name: lapangin-web
   Environment: PHP
   Region: Singapore
   Branch: main
   Build Command: ./build.sh
   Start Command: php artisan serve --host=0.0.0.0 --port=$PORT
   ```

4. **Create Database:**
   - Click "New +" → "MySQL"
   - Name: `lapangin-db`
   - Plan: Free
   - Region: Singapore

5. **Configure Environment Variables:**
   Render akan auto-detect dari `render.yaml`, atau set manual:
   ```
   APP_NAME=Lapangin
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY=[Generate new]
   LOG_CHANNEL=stderr
   SESSION_DRIVER=database
   CACHE_STORE=database
   QUEUE_CONNECTION=database
   DB_CONNECTION=mysql
   DB_HOST=[Auto from database]
   DB_PORT=[Auto from database] 
   DB_DATABASE=[Auto from database]
   DB_USERNAME=[Auto from database]
   DB_PASSWORD=[Auto from database]
   ```

6. **Deploy:**
   - Click "Create Web Service"
   - Render akan otomatis build dan deploy

### Method 2: Blueprint Deployment (Otomatis)

1. **Gunakan render.yaml:**
   - File `render.yaml` sudah dikonfigurasi lengkap
   - Push ke repository Git Anda
   - Di Render dashboard, pilih "Blueprint"
   - Select repository dan deploy

## Struktur File Deployment

```
Lapangin-Web/
├── render.yaml          # Konfigurasi deployment Render
├── build.sh            # Script build Laravel untuk Render
├── composer.json       # Dependencies PHP
├── package.json        # Dependencies Node.js (jika ada)
└── ...
```

## Environment Variables yang Diperlukan

Sudah dikonfigurasi otomatis di `render.yaml`:

- `APP_KEY` - Generated otomatis
- `DB_*` - Dikonfigurasi otomatis dari database service
- `APP_ENV=production`
- `APP_DEBUG=false`
- `LOG_CHANNEL=stderr`
- `SESSION_DRIVER=database`
- `CACHE_STORE=database`

## Build Process

Build script (`build.sh`) akan menjalankan:

1. `composer install --optimize-autoloader --no-dev`
2. `php artisan key:generate --force`
3. `php artisan migrate --force`
4. `php artisan db:seed --force`
5. `php artisan config:cache`
6. `php artisan route:cache`
7. `php artisan view:cache`
8. Set file permissions

## Monitoring Deployment

1. **Check deployment status:**
   ```bash
   render service list
   ```

2. **View logs:**
   ```bash
   render service logs lapangin-web
   ```

3. **Monitor database:**
   ```bash
   render service logs lapangin-db
   ```

## Post-Deployment

### Verify Functionality
Setelah deployment berhasil, test fitur-fitur utama:

1. **Main Bareng System:**
   - Buat event Main Bareng baru
   - Join event sebagai participant
   - Upload bukti pembayaran
   - Chat dalam event

2. **Payment System:**
   - Process pembayaran
   - Upload proof of payment
   - Status tracking

3. **User Dashboard:**
   - My Events (Organized vs Joined)
   - Profile management
   - Notifications

### Troubleshooting

**Jika deployment gagal:**

1. **Check logs:**
   ```bash
   render service logs lapangin-web --tail
   ```

2. **Common issues:**
   - Database connection: Periksa environment variables DB_*
   - File permissions: Build script sudah handle ini
   - Memory limits: Upgrade plan jika diperlukan

3. **Manual fixes:**
   ```bash
   # Clear cache jika ada masalah
   render exec lapangin-web -- php artisan cache:clear
   render exec lapangin-web -- php artisan config:clear
   
   # Re-run migrations jika diperlukan
   render exec lapangin-web -- php artisan migrate:fresh --seed --force
   ```

## Step-by-Step Deployment (Detailed)

### Langkah 1: Push ke Repository
```bash
# Pastikan semua perubahan sudah di commit
git status
git add .
git commit -m "Ready for Render deployment - Laravel app with Main Bareng system"
git push origin main
```

### Langkah 2: Setup di Render.com

1. **Buka browser dan pergi ke:** https://render.com
2. **Sign up/Login** dengan GitHub account
3. **Connect Repository:**
   - Authorize Render untuk akses GitHub
   - Select repository: `Lapangin-Web`

### Langkah 3: Create Database Service

1. **Di Render Dashboard:**
   - Click "New +" → "PostgreSQL"
   - Name: `lapangin-db`
   - Database Name: `lapangin`
   - User: `lapangin_user`
   - Region: `Singapore`
   - Plan: `Free`
   - Click "Create Database"

2. **Catat Database Info** (akan digunakan nanti):
   - Host, Port, Database Name, Username, Password

### Langkah 4: Create Web Service

1. **Di Render Dashboard:**
   - Click "New +" → "Web Service"
   - Connect repository: `Lapangin-Web`
   - Branch: `main`

2. **Service Configuration:**
   ```
   Name: lapangin-web
   Environment: PHP
   Region: Singapore
   Branch: main
   Root Directory: (leave blank)
   Build Command: chmod +x build.sh && ./build.sh
   Start Command: php artisan serve --host=0.0.0.0 --port=$PORT
   ```

3. **Environment Variables:**
   Add these manually (atau biarkan auto-detect dari render.yaml):
   ```
   APP_NAME=Lapangin
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY=base64:GENERATE_NEW_KEY
   LOG_CHANNEL=stderr
   LOG_LEVEL=error
   SESSION_DRIVER=database
   SESSION_LIFETIME=120
   CACHE_STORE=database
   QUEUE_CONNECTION=database
   DB_CONNECTION=pgsql
   DB_HOST=[dari database service]
   DB_PORT=[dari database service]
   DB_DATABASE=lapangin
   DB_USERNAME=[dari database service]
   DB_PASSWORD=[dari database service]
   ```

4. **Create Service** - Click "Create Web Service"

### Langkah 5: Monitor Deployment

1. **Build Process:** Monitor di Render dashboard
2. **Logs:** Check untuk errors selama build
3. **Testing:** Setelah selesai, test URL yang diberikan

## Troubleshooting Commands (Via Dashboard)

### Jika Build Gagal:
1. Check build logs di Render dashboard
2. Pastikan `build.sh` executable: `chmod +x build.sh`
3. Verify PHP version compatibility

### Jika Database Error:
1. Check environment variables DB_*
2. Verify database service running
3. Check database connection in logs

### Manual Commands (Via Render Shell):
Di Render dashboard → Service → Shell:
```bash
# Clear cache
php artisan cache:clear
php artisan config:clear

# Run migrations
php artisan migrate --force

# Generate key
php artisan key:generate --force
```

## Production Optimization

Setelah deployment berhasil, pertimbangkan:

1. **CDN Setup** - Untuk static assets
2. **Database Optimization** - Index untuk query performance
3. **Caching Strategy** - Redis untuk session/cache yang lebih baik
4. **Monitoring** - Setup error tracking dan performance monitoring
5. **Backup Strategy** - Regular database backups

## Support

- Render Documentation: https://render.com/docs
- Laravel Deployment: https://laravel.com/docs/10.x/deployment
- Render CLI Reference: https://render.com/docs/cli

---

**Ready to deploy!** 🚀