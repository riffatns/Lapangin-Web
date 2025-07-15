#!/bin/bash

echo "🚀 Railway Startup with Debug Output"

# Function to log with timestamp
log_with_time() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1"
}

log_with_time "=== Railway Startup Debug ==="

# Show environment variables
log_with_time "Environment Variables:"
env | grep -E "(MYSQL|DB_|RAILWAY)" | sort | while read line; do
    log_with_time "  $line"
done

# Test database connections
log_with_time "=== Database Connection Tests ==="

# Test 1: Railway Private Domain
if [ -n "$RAILWAY_PRIVATE_DOMAIN" ] && [ -n "$MYSQL_ROOT_PASSWORD" ]; then
    log_with_time "Testing Railway Private Domain connection..."
    php -r "
        try {
            \$pdo = new PDO('mysql:host={$RAILWAY_PRIVATE_DOMAIN};port=3306;dbname=railway', 'root', '{$MYSQL_ROOT_PASSWORD}', [PDO::ATTR_TIMEOUT => 10]);
            echo '[' . date('Y-m-d H:i:s') . '] ✅ Railway connection: SUCCESS\n';
        } catch(Exception \$e) {
            echo '[' . date('Y-m-d H:i:s') . '] ❌ Railway connection: ' . \$e->getMessage() . '\n';
        }
    "
else
    log_with_time "❌ Railway variables not available"
fi

# Test 2: MySQL* variables
if [ -n "$MYSQLHOST" ] && [ -n "$MYSQLPASSWORD" ]; then
    log_with_time "Testing MySQL* variables connection..."
    php -r "
        try {
            \$pdo = new PDO('mysql:host={$MYSQLHOST};port={$MYSQLPORT};dbname={$MYSQLDATABASE}', '{$MYSQLUSER}', '{$MYSQLPASSWORD}', [PDO::ATTR_TIMEOUT => 10]);
            echo '[' . date('Y-m-d H:i:s') . '] ✅ MySQL* connection: SUCCESS\n';
        } catch(Exception \$e) {
            echo '[' . date('Y-m-d H:i:s') . '] ❌ MySQL* connection: ' . \$e->getMessage() . '\n';
        }
    "
else
    log_with_time "❌ MySQL* variables not available"
fi

# Generate APP_KEY if missing
if [ -z "$APP_KEY" ]; then
    log_with_time "🔑 Generating application key..."
    php artisan key:generate --force --no-interaction
    log_with_time "✅ Application key generated"
fi

# Try to connect with Laravel
log_with_time "=== Laravel Database Test ==="
php artisan tinker --execute="
    try {
        DB::connection()->getPdo();
        echo '[' . date('Y-m-d H:i:s') . '] ✅ Laravel DB connection: SUCCESS\n';
    } catch(Exception \$e) {
        echo '[' . date('Y-m-d H:i:s') . '] ❌ Laravel DB connection: ' . \$e->getMessage() . '\n';
    }
" 2>/dev/null || log_with_time "❌ Laravel tinker failed"

# If database connection works, try migration
if php artisan tinker --execute="DB::connection()->getPdo();" 2>/dev/null; then
    log_with_time "✅ Database connected! Running migrations..."
    php artisan migrate --force --no-interaction
    
    # Check if seeding needed
    USER_COUNT=$(php artisan tinker --execute="echo App\Models\User::count();" 2>/dev/null | tail -n1 || echo "0")
    if [ "$USER_COUNT" = "0" ] || [ "$USER_COUNT" = "" ]; then
        log_with_time "🌱 Seeding database..."
        php artisan db:seed --force --no-interaction
    fi
else
    log_with_time "❌ Database connection failed - starting without database"
    export SESSION_DRIVER=file
    export CACHE_DRIVER=file
fi

# Clear and cache configurations
log_with_time "⚡ Caching configurations..."
php artisan config:cache 2>/dev/null || log_with_time "Config cache skipped"
php artisan route:cache 2>/dev/null || log_with_time "Route cache skipped"
php artisan view:cache 2>/dev/null || log_with_time "View cache skipped"

# Start the server
log_with_time "🌐 Starting Laravel server on port ${PORT:-8000}..."
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
