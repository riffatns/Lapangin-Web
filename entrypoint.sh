#!/bin/bash
set -e

echo "=== Laravel Setup ==="

# Ensure .env file exists
if [ ! -f .env ]; then
    echo "Creating .env file..."
    cp .env.example .env
fi

# Update .env with database configuration
echo "Configuring database connection..."
sed -i "s/DB_CONNECTION=.*/DB_CONNECTION=pgsql/" .env
sed -i "s/DB_HOST=.*/DB_HOST=${DB_HOST}/" .env
sed -i "s/DB_PORT=.*/DB_PORT=${DB_PORT}/" .env
sed -i "s/DB_DATABASE=.*/DB_DATABASE=${DB_DATABASE}/" .env
sed -i "s/DB_USERNAME=.*/DB_USERNAME=${DB_USERNAME}/" .env
sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=${DB_PASSWORD}/" .env

echo "Database configuration:"
grep "DB_" .env

# Wait for database to be ready
echo "Waiting for database connection..."
echo "DB_HOST: ${DB_HOST}"
echo "DB_PORT: ${DB_PORT}"
echo "DB_DATABASE: ${DB_DATABASE}"
echo "DB_USERNAME: ${DB_USERNAME}"

for i in {1..30}; do
    echo "Attempt $i: Testing database connection..."
    if php artisan migrate:status &>/dev/null; then
        echo "Database connection successful!"
        break
    fi
    echo "Attempt $i: Database not ready, waiting 10 seconds..."
    if [ $i -eq 30 ]; then
        echo "Failed to connect to database after 30 attempts"
        echo "Trying to show detailed connection error:"
        php artisan migrate:status || true
    fi
    sleep 10
done

# Generate app key if not exists in .env
if ! grep -q "APP_KEY=" .env || [ -z "$(grep APP_KEY= .env | cut -d'=' -f2)" ]; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Run migrations
echo "Running database migrations..."
php artisan migrate --force

# Seed database
echo "Seeding database..."
php artisan db:seed --force || echo "Seeding completed or skipped"

# Cache optimization for production
echo "Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=== Starting Apache ==="
exec apache2-foreground
