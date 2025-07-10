#!/bin/bash

echo "Starting Railway deployment..."

# Wait for database to be available
echo "Waiting for database connection..."
until php artisan db:monitor; do
    echo "Database not ready, waiting 5 seconds..."
    sleep 5
done

echo "Database connected! Running migrations..."

# Generate app key if not exists
if [ -z "$APP_KEY" ]; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Run migrations
echo "Running database migrations..."
php artisan migrate --force

# Seed database if needed (only on first deploy)
echo "Seeding database (if tables are empty)..."
php artisan db:seed --force || echo "Seeding skipped or failed"

# Cache configurations
echo "Caching Laravel configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting Laravel server..."
php artisan serve --host=0.0.0.0 --port=$PORT
