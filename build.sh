#!/bin/bash

echo "Starting Vercel build process..."

# Install PHP dependencies
composer install --optimize-autoloader --no-dev --no-interaction

# Copy production environment
cp .env.production .env

# Clear and optimize Laravel
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Cache for production (if config files exist)
if [ -f "config/app.php" ]; then
    php artisan config:cache
fi

if [ -f "routes/web.php" ]; then
    php artisan route:cache
fi

# Optimize composer autoloader
composer dump-autoload --optimize --classmap-authoritative

echo "Build completed successfully!"
