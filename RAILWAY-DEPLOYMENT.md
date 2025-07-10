# Railway Deployment Guide

## 🚀 Deploy Lapangin to Railway

### Prerequisites
1. Railway account
2. GitHub repository with Lapangin code

### Deploy Steps

1. **Connect Repository**
   - Go to [Railway.app](https://railway.app)
   - Click "Deploy from GitHub repo"
   - Select your Lapangin repository

2. **Add MySQL Database**
   - In Railway dashboard, click "Add Service"
   - Select "Database" → "MySQL"
   - Railway will automatically create MySQL service and set environment variables

3. **Configure Environment Variables**
   Railway will automatically set these database variables:
   - `MYSQLHOST`
   - `MYSQLPORT` 
   - `MYSQLDATABASE`
   - `MYSQLUSER`
   - `MYSQLPASSWORD`

   You need to manually add:
   ```
   APP_KEY=base64:your-generated-key
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://your-app.railway.app
   ```

4. **Generate APP_KEY**
   After first deployment, run in Railway terminal:
   ```bash
   php artisan key:generate --show
   ```
   Copy the generated key to APP_KEY environment variable.

### 🔧 Deployment Process

The deployment uses these files:
- `nixpacks.toml` - Build configuration
- `railway-build.sh` - Build script
- `railway-start.sh` - Startup script

### Process Flow:
1. **Build Phase**: Install composer dependencies
2. **Start Phase**: 
   - Wait for database connection
   - Generate APP_KEY if missing
   - Run migrations
   - Seed database (first time only)
   - Cache configurations
   - Start Laravel server

### 🔍 Troubleshooting

If deployment fails with "Connection refused" error:

1. **Check MySQL Service**
   - Ensure MySQL service is added to your Railway project
   - Go to Railway Dashboard → Add Service → Database → MySQL
   - Wait for MySQL to be fully provisioned (can take 2-3 minutes)

2. **Verify Environment Variables**
   Railway should automatically set these when MySQL is added:
   ```
   MYSQLHOST=xxx.railway.internal
   MYSQLPORT=3306
   MYSQLDATABASE=railway
   MYSQLUSER=root
   MYSQLPASSWORD=xxxxx
   ```

3. **Check Build Logs**
   - Railway dashboard → Deployments → Click on deployment
   - Look for specific error messages
   - Database connection errors usually appear in startup logs

4. **Manual Commands**
   If needed, access Railway terminal and run:
   ```bash
   # Test database connection
   bash check-db.sh
   
   # Manual migration
   php artisan migrate --force
   
   # Manual seeding
   php artisan db:seed --force
   
   # Check environment
   php artisan env
   ```

5. **Common Issues**
   - **"MYSQLHOST not set"**: MySQL service not added or not provisioned
   - **"Connection timeout"**: MySQL service starting up, wait and redeploy
   - **"Access denied"**: Check MYSQLUSER and MYSQLPASSWORD variables
   - **"Unknown database"**: Check MYSQLDATABASE variable

### 🔄 Redeploy Process

If deployment fails:
1. Check that MySQL service exists and is running
2. Wait 2-3 minutes for MySQL to be ready
3. Trigger redeploy from Railway dashboard
4. Monitor logs for specific error messages

### 📱 Access Your App

After successful deployment:
- Your app will be available at: `https://your-app.railway.app`
- Database tables will be created automatically
- Sample data will be seeded

### 🔐 Email Configuration

For production email (Gmail SMTP), add these environment variables:
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-gmail@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-gmail@gmail.com
MAIL_FROM_NAME=Lapangin
```

### 🎯 Domain Setup

To use custom domain:
1. Railway dashboard → Settings → Domains
2. Add your custom domain
3. Update APP_URL environment variable
