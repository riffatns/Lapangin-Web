# Vercel Deployment Guide untuk Lapangin

## Database Setup (PlanetScale)

1. **Buat PlanetScale Account**: https://planetscale.com
2. **Buat Database Baru**: `lapangin-db`
3. **Generate Branch**: `main`
4. **Connect URL**: Akan mendapat connection string seperti:
   ```
   mysql://username:password@host:port/database?sslaccept=strict
   ```

## Environment Variables di Vercel

Set di Vercel Dashboard → Settings → Environment Variables:

```bash
# App Configuration
APP_NAME=Lapangin
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:JuBsLj/kXUMHle9ybV4BRF9TPWN+pHFj2VMdYlUroZo=

# Database (dari PlanetScale)
DATABASE_HOST=your-host.psdb.cloud
DATABASE_NAME=lapangin-db
DATABASE_USERNAME=your-username
DATABASE_PASSWORD=your-password

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=lapangin.web@gmail.com
MAIL_PASSWORD=sjnh bqyb sgyw nvfa
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=lapangin.web@gmail.com
MAIL_FROM_NAME=Lapangin
```

## Deploy Steps

1. **Push ke GitHub**
2. **Connect Vercel ke GitHub repo**
3. **Set Environment Variables**
4. **Deploy**

## Post-Deploy

1. **Run Migrations**: Via PlanetScale CLI atau manual SQL
2. **Seed Data**: Upload initial data
3. **Test Application**: Registration, login, booking flow

## Important Notes

- Vercel functions have 10s timeout limit
- Use cookie sessions instead of database sessions
- Cache driver set to 'array' for stateless deployment
- File uploads need external storage (AWS S3, Cloudinary)
