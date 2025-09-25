#!/bin/bash
set -e

echo "🚀 Starting Laravel application..."

# Wait for database to be ready
echo "⏳ Waiting for database connection..."
until php artisan migrate:status > /dev/null 2>&1; do
    echo "Database not ready, waiting..."
    sleep 5
done

# Run the build script for initial setup
echo "🔧 Running initial setup..."
./build.sh

echo "✅ Laravel application ready!"

# Start Apache
exec apache2-foreground