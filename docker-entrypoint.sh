#!/bin/bash
set -e

echo "🚀 Starting Laravel application..."

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