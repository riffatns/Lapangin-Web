#!/bin/bash
set -e

echo "=== Laravel Setup ==="

# Ensure .env file exists
if [ ! -f .env ]; then
    echo "Creating .env file..."
    cp .env.example .env
fi

# Wait for database to be ready
echo "Waiting for database..."
sleep 10

# Generate app key if not exists in .env
if ! grep -q "APP_KEY=" .env || [ -z "$(grep APP_KEY= .env | cut -d'=' -f2)" ]; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Run migrations
echo "Running database migrations..."
php artisan migrate --force

# Seed database
echo "Seeding database..."
php artisan db:seed --force || echo "Seeding completed or skipped"

# Cache optimization for production
echo "Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=== Starting Apache ==="
exec apache2-foreground
