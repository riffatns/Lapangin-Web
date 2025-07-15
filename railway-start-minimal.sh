#!/bin/bash

echo "🚀 Minimal Railway Start"

# Show environment
echo "=== Environment Variables ==="
env | grep -E "(APP_|DB_|MYSQL|RAILWAY)" | sort

# Test database connection
echo "=== Database Test ==="
php -r "
try {
    new PDO('mysql:host=127.0.0.1;port=3306;dbname=lapangin_db', 'root', '');
    echo 'Database: OK' . PHP_EOL;
} catch(Exception \$e) {
    echo 'Database: ERROR - ' . \$e->getMessage() . PHP_EOL;
}
"

# Generate APP_KEY if missing
if [ -z "$APP_KEY" ]; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force --no-interaction
    echo "✅ Application key generated"
fi

# Clear cache
echo "🧹 Clearing cache..."
php artisan config:clear 2>/dev/null || echo "Config clear skipped"
php artisan route:clear 2>/dev/null || echo "Route clear skipped"
php artisan view:clear 2>/dev/null || echo "View clear skipped"
php artisan cache:clear 2>/dev/null || echo "Cache clear skipped"

# Test Laravel before starting
echo "🔍 Testing Laravel..."
php debug-web-error.php

# Start server
echo "🌐 Starting Laravel server on port ${PORT:-8000}..."
echo "Access URL: https://web-production-2c24.up.railway.app"

exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
