#!/bin/bash

echo "🚀 Starting Lapangin Web deployment on Render with Docker..."

# Wait for database to be ready
echo "⏳ Waiting for database connection..."
sleep 10

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

# Set proper permissions
echo "🔒 Setting permissions..."
chmod -R 775 storage bootstrap/cache

echo "✅ Docker deployment completed successfully!"
