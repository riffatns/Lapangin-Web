#!/bin/bash
set -e

echo "🚀 Starting Laravel application..."

# Create .env file from environment variables
echo "📝 Creating .env file from environment variables..."
cat > .env << EOF
APP_NAME="${APP_NAME:-Lapangin}"
APP_ENV="${APP_ENV:-production}"
APP_KEY="${APP_KEY}"
APP_DEBUG="${APP_DEBUG:-false}"
APP_TIMEZONE=UTC
APP_URL="${APP_URL:-http://localhost}"

LOG_CHANNEL="${LOG_CHANNEL:-stderr}"
LOG_LEVEL="${LOG_LEVEL:-error}"

DB_CONNECTION="${DB_CONNECTION:-pgsql}"
DB_HOST="${DB_HOST}"
DB_PORT="${DB_PORT:-5432}"
DB_DATABASE="${DB_DATABASE}"
DB_USERNAME="${DB_USERNAME}"
DB_PASSWORD="${DB_PASSWORD}"

SESSION_DRIVER="${SESSION_DRIVER:-database}"
SESSION_LIFETIME="${SESSION_LIFETIME:-120}"

CACHE_STORE="${CACHE_STORE:-database}"
QUEUE_CONNECTION="${QUEUE_CONNECTION:-database}"

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
MAIL_MAILER=log
EOF

echo "✅ .env file created successfully!"

# Generate APP_KEY if not set
echo "🔑 Generating application key..."
php artisan key:generate --force

# Create storage link
echo "🔗 Creating storage link..."
php artisan storage:link --force

# Wait for database to be ready with PostgreSQL
echo "⏳ Waiting for PostgreSQL database connection..."
max_attempts=30
attempt=1

while [ $attempt -le $max_attempts ]; do
    if php artisan migrate:status --database=pgsql > /dev/null 2>&1; then
        echo "✅ Database connection successful!"
        break
    else
        echo "Database not ready, attempt $attempt/$max_attempts..."
        sleep 10
        attempt=$((attempt + 1))
    fi
done

if [ $attempt -gt $max_attempts ]; then
    echo "⚠️ Database connection failed after $max_attempts attempts, proceeding anyway..."
fi

# Run database migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force --database=pgsql

# Seed essential data
echo "🌱 Seeding database..."
php artisan db:seed --class=SportsSeeder --force || echo "⚠️ Sports seeder not found or failed, continuing..."
php artisan db:seed --class=VenueSeeder --force || echo "⚠️ Venue seeder not found or failed, continuing..."

# Clear and cache configuration
echo "⚡ Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions
echo "🔒 Setting permissions..."
chmod -R 775 storage bootstrap/cache

echo "✅ Laravel application ready!"

# Start Apache
exec apache2-foreground