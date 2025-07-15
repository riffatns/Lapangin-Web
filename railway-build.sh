#!/bin/bash

echo "Starting Railway build process..."

# Install dependencies
echo "Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev

# Clear any cached configs to avoid conflicts
echo "Clearing cached configurations..."
php artisan config:clear || echo "Config clear skipped"
php artisan route:clear || echo "Route clear skipped" 
php artisan view:clear || echo "View clear skipped"
php artisan cache:clear || echo "Cache clear skipped"

# Run debug during build
echo "Running debug analysis..."
bash railway-debug-build.sh

echo "Railway build completed successfully!"
