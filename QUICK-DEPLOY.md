# Quick Deployment Instructions

## 🚀 Deploy Lapangin to Render.com (5 Steps)

### Step 1: Push to Repository
```bash
git add .
git commit -m "Deploy to Render.com"
git push origin main
```

### Step 2: Go to Render.com
- Open: https://render.com
- Login with GitHub account
- Authorize repository access

### Step 3: Create Database
- Click "New +" → "PostgreSQL"
- Name: `lapangin-db`
- Plan: Free
- Region: Singapore
- Click "Create Database"

### Step 4: Create Web Service  
- Click "New +" → "Web Service"
- Select: `Lapangin-Web` repository
- Branch: `main`
- Environment: **Docker**
- Dockerfile Path: `./Dockerfile`
- (Build dan Start commands otomatis dari Dockerfile)

### Step 5: Set Environment Variables
Either let Render auto-detect from `render.yaml` or set manually:
```
APP_NAME=Lapangin
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=pgsql
(Database variables will be auto-filled from Step 3)
```

### ✅ Done!
Your app will be live at: `https://lapangin-web.onrender.com`

---

## 🔧 If Deployment Fails:

1. **Check Build Logs** in Render dashboard
2. **Database Connection**: Verify DB environment variables
3. **File Permissions**: Build script should be executable (already fixed)

## 🧪 Test After Deployment:

1. Visit your live URL
2. Create a Main Bareng event
3. Test payment system
4. Check My Events dashboard

---

**Need Help?** Check `RENDER-DEPLOYMENT-GUIDE.md` for detailed instructions.