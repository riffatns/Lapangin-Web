# 🗄️ Database Setup Guide untuk Render.com

## Step-by-Step Database Connection

### 1. **Create Database Service di Render**

1. **Login ke Render.com** → Dashboard
2. **Click "New +"** → Select **"PostgreSQL"**
3. **Configure Database:**
   ```
   Name: lapangin-db
   Database Name: lapangin
   User: lapangin_user
   Plan: Free
   Region: Singapore
   ```
4. **Click "Create Database"** 
5. **Wait** sampai status "Available" (hijau)

### 2. **Get Database Connection Details**

Setelah database dibuat, catat info ini dari Render dashboard:

```
Internal Database URL: postgres://user:password@host:port/database
External Database URL: postgres://user:password@external-host:port/database

Host: dpg-xxxxxxxxx-a.singapore-postgres.render.com
Database: lapangin
Username: lapangin_user
Password: [auto-generated]
Port: 5432
```

### 3. **Environment Variables (Auto-Configured)**

File `render.yaml` sudah dikonfigurasi untuk auto-connect:

```yaml
envVars:
  - key: DB_CONNECTION
    value: pgsql
  - key: DB_HOST
    fromDatabase:
      name: lapangin-db        # ← Harus sama dengan nama database service!
      property: host
  - key: DB_PORT
    fromDatabase:
      name: lapangin-db
      property: port
  - key: DB_DATABASE
    fromDatabase:
      name: lapangin-db
      property: database
  - key: DB_USERNAME
    fromDatabase:
      name: lapangin-db
      property: user
  - key: DB_PASSWORD
    fromDatabase:
      name: lapangin-db
      property: password
```

### 4. **Create Web Service**

Setelah database ready:

1. **Click "New +"** → **"Web Service"**
2. **Repository:** `Lapangin-Web`
3. **Environment:** **Docker**
4. **Dockerfile Path:** `./Dockerfile`

**Important:** Render akan otomatis connect database jika nama service database sama dengan yang di `render.yaml`!

### 5. **Manual Environment Variables (Jika Auto-Config Gagal)**

Jika auto-config tidak bekerja, set manual di Web Service settings:

```
APP_NAME=Lapangin
APP_ENV=production
APP_DEBUG=false
APP_KEY=[Generate New]
DB_CONNECTION=pgsql
DB_HOST=[dari database service]
DB_PORT=5432
DB_DATABASE=lapangin
DB_USERNAME=[dari database service]
DB_PASSWORD=[dari database service]
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

### 6. **Verify Database Connection**

Setelah deployment, check logs:

1. **Go to Web Service** → **Logs**
2. **Look for:**
   ```
   ✅ Database connection successful!
   🗄️ Running database migrations...
   🌱 Seeding database...
   ✅ Docker deployment completed successfully!
   ```

### 7. **Troubleshooting Database Issues**

#### Problem: "Database not ready, waiting..."
**Solution:**
- Check database service status (must be "Available")
- Verify environment variables in web service
- Check database name matches in `render.yaml`

#### Problem: Migration failed
**Solution:**
```bash
# Via Render Shell (Web Service → Shell)
php artisan migrate:fresh --force
php artisan db:seed --force
```

#### Problem: Connection timeout
**Solution:**
- Database dan Web Service harus di region yang sama
- Check internal vs external database URL

### 8. **Database Access (Optional)**

Untuk connect dari local development:

```bash
# Install PostgreSQL client
# Connect menggunakan External Database URL
psql "postgres://username:password@external-host:port/database"

# Atau via GUI tools (pgAdmin, DBeaver):
Host: external-host
Port: 5432
Database: lapangin
Username: lapangin_user
Password: [dari Render dashboard]
```

## ✅ Checklist Database Setup:

- [ ] PostgreSQL service created di Render
- [ ] Database status "Available" (hijau)
- [ ] Web service environment: Docker
- [ ] Database name di `render.yaml` match dengan service name
- [ ] Environment variables configured (auto atau manual)
- [ ] Deployment logs show successful database connection
- [ ] Migrations ran successfully
- [ ] Application accessible via Render URL

---

**Database connection akan auto-configured jika nama service database di render.yaml sama dengan yang dibuat di Render dashboard!** 🎯