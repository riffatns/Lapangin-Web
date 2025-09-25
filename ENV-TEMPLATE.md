# 📋 Environment Variables Template

## Copy data dari PostgreSQL database Render.com Anda:

```yaml
# Untuk render.yaml file:
envVars:
  - key: DB_HOST
    value: "PASTE_YOUR_DATABASE_HOST_HERE"
  - key: DB_PORT
    value: "5432"
  - key: DB_DATABASE
    value: "PASTE_YOUR_DATABASE_NAME_HERE"
  - key: DB_USERNAME
    value: "PASTE_YOUR_USERNAME_HERE"
  - key: DB_PASSWORD
    value: "PASTE_YOUR_PASSWORD_HERE"
```

## Atau set langsung di Render Web Service Environment tab:

```
DB_CONNECTION=pgsql
DB_HOST=PASTE_YOUR_DATABASE_HOST_HERE
DB_PORT=5432
DB_DATABASE=PASTE_YOUR_DATABASE_NAME_HERE
DB_USERNAME=PASTE_YOUR_USERNAME_HERE
DB_PASSWORD=PASTE_YOUR_PASSWORD_HERE
```

## 🔍 Cara Ambil Data dari Render Database:

1. **Login Render.com** → Dashboard
2. **Click PostgreSQL database** yang sudah dibuat
3. **Copy dari section "Connections":**
   - External Database URL: `postgres://user:pass@host:port/db`
   - Breakdown jadi:
     - Host: `host` part
     - Database: `db` part
     - Username: `user` part  
     - Password: `pass` part

## 📝 Example:

Jika External Database URL:
```
postgres://lapangin_user:abc123xyz@dpg-cm1234-a.singapore-postgres.render.com:5432/lapangin_db
```

Maka:
- **DB_HOST**: `dpg-cm1234-a.singapore-postgres.render.com`
- **DB_DATABASE**: `lapangin_db`
- **DB_USERNAME**: `lapangin_user`
- **DB_PASSWORD**: `abc123xyz`
- **DB_PORT**: `5432`

---

**Paste your database details and update the files accordingly!** 🗄️