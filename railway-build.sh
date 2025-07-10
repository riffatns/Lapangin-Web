#!/bin/bash

echo "Starting Railway build process..."

# Create .env from example if not exists
if [ ! -f .env ]; then
    echo "Creating .env from .env.example..."
    cp .env.example .env
fi

# Install dependencies
echo "Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev

# Clear and cache config (if possible)
echo "Caching Laravel configurations..."
php artisan config:clear
php artisan config:cache || echo "Config cache skipped"
php artisan route:cache || echo "Route cache skipped"
php artisan view:cache || echo "View cache skipped"

echo "Railway build completed successfully!"
