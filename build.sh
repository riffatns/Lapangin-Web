#!/bin/bash

echo "🚀 Starting Lapangin Web deployment on Render with Docker..."

# Generate application key if not exists
echo "🔑 Generating application key..."
php artisan key:generate --force

# Create storage link
echo "🔗 Creating storage link..."
php artisan storage:link || echo "Storage link already exists"

# Check database connection
echo "🔍 Testing database connection..."
php artisan migrate:status || echo "Migration status check failed, proceeding..."

# Run database migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force

# Check if seeders exist and run them
echo "🌱 Seeding database..."
if php artisan db:seed --class=SportsSeeder --force; then
    echo "✅ Sports seeded successfully"
else
    echo "⚠️ Sports seeder not found or failed, continuing..."
fi

if php artisan db:seed --class=VenueSeeder --force; then
    echo "✅ Venues seeded successfully"
else
    echo "⚠️ Venue seeder not found or failed, continuing..."
fi

# Clear and cache configuration
echo "⚡ Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions
echo "🔒 Setting permissions..."
chmod -R 775 storage bootstrap/cache

echo "✅ Docker deployment completed successfully!"
