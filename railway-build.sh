#!/bin/bash

# Install dependencies
composer install --optimize-autoloader --no-dev

# Clear and cache config
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force

# Seed database if needed
php artisan db:seed --force --class=DatabaseSeeder

echo "Build completed successfully!"
