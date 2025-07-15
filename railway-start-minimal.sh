#!/bin/bash

echo "🚀 Minimal Railway Start (Skip DB Check)"

# Show environment
echo "=== Environment Variables ==="
env | grep -E "(MYSQL|DB_|RAILWAY)" | sort

# Generate APP_KEY if missing
if [ -z "$APP_KEY" ]; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force --no-interaction
    echo "✅ Application key generated"
fi

# Clear cache without database
echo "🧹 Clearing cache..."
php artisan config:clear 2>/dev/null || echo "Config clear skipped"
php artisan route:clear 2>/dev/null || echo "Route clear skipped"
php artisan view:clear 2>/dev/null || echo "View clear skipped"

# Start server without database setup
echo "🌐 Starting Laravel server (DB setup skipped)..."
echo "Port: ${PORT:-8000}"

# Set session driver to file instead of database
export SESSION_DRIVER=file
export CACHE_DRIVER=file

exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
