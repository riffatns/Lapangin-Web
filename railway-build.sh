#!/bin/bash

echo "Starting Railway build process..."

# Copy production environment file
cp .env.production .env

# Install dependencies
echo "Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev

# Clear and cache config
echo "Caching Laravel configurations..."
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
echo "Running database migrations..."
php artisan migrate --force

# Seed database with essential data
echo "Seeding database..."
php artisan db:seed --force --class=DatabaseSeeder

echo "Railway build completed successfully!"
