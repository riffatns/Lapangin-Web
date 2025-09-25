#!/bin/bash

echo "🚀 Starting Lapangin Web deployment on Render..."

# Install PHP dependencies
echo "📦 Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev --no-interaction --prefer-dist

# Generate application key if not exists
echo "🔑 Generating application key..."
php artisan key:generate --force

# Create storage link
echo "🔗 Creating storage link..."
php artisan storage:link

# Run database migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force

# Seed essential data
echo "🌱 Seeding database..."
php artisan db:seed --class=SportsSeeder --force
php artisan db:seed --class=VenueSeeder --force

# Clear and cache configuration
echo "⚡ Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize composer autoloader
composer dump-autoload --optimize --classmap-authoritative

# Set proper permissions
echo "🔒 Setting permissions..."
chmod -R 775 storage bootstrap/cache

echo "✅ Render deployment completed successfully!"
