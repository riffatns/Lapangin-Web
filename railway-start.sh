#!/bin/bash

echo "🚀 Starting Lapangin Railway deployment..."

# Check if we have database environment variables
if [ -z "$MYSQLHOST" ] && [ -z "$RAILWAY_PRIVATE_DOMAIN" ]; then
    echo "❌ Error: Database environment variables not set"
    echo "Make sure MySQL service is added to Railway project"
    echo "Available env vars:"
    env | grep -E "(MYSQL|DB_|RAILWAY)" | sort
    exit 1
fi

# Use Railway variables if available
DB_HOST=${MYSQLHOST:-$RAILWAY_PRIVATE_DOMAIN}
DB_PORT=${MYSQLPORT:-3306}
DB_DATABASE=${MYSQLDATABASE:-$MYSQL_DATABASE}
DB_USER=${MYSQLUSER:-root}
DB_PASSWORD=${MYSQLPASSWORD:-$MYSQL_ROOT_PASSWORD}

echo "📡 Database connection info:"
echo "   Host: $DB_HOST"
echo "   Port: $DB_PORT"
echo "   Database: $DB_DATABASE"
echo "   User: $DB_USER"

# Run detailed database debug
echo "🔍 Running detailed database debug..."
php debug-railway-db.php

# Wait for database with timeout
echo "⏳ Waiting for database connection..."
for i in {1..30}; do
    if php simple-db-test.php > /dev/null 2>&1; then
        echo "✅ Database connection established!"
        break
    else
        echo "🔄 Attempt $i/30: Database not ready, waiting 10 seconds..."
        sleep 10
    fi
    
    if [ $i -eq 30 ]; then
        echo "❌ Database connection timeout after 5 minutes"
        echo "Running detailed debug..."
        php simple-db-test.php
        echo "Available environment variables:"
        env | grep -E "(MYSQL|DB_|RAILWAY)" | sort
        
        # Try to force setup anyway
        echo "Trying to force setup..."
        bash force-db-setup.sh
        
        if [ $? -ne 0 ]; then
            echo "❌ Force setup failed"
            exit 1
        fi
        break
    fi
done

# Generate APP_KEY if missing
if [ -z "$APP_KEY" ]; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force --no-interaction
    echo "✅ Application key generated"
fi

# Run migrations
echo "📊 Running database migrations..."
if php artisan migrate --force --no-interaction; then
    echo "✅ Migrations completed successfully"
else
    echo "❌ Migration failed"
    exit 1
fi

# Check if we need to seed data
echo "🌱 Checking if database needs seeding..."
USER_COUNT=$(php artisan tinker --execute="echo App\Models\User::count();" 2>/dev/null | tail -n1 || echo "0")

if [ "$USER_COUNT" = "0" ] || [ "$USER_COUNT" = "" ]; then
    echo "🌱 Database is empty, seeding with sample data..."
    if php artisan db:seed --force --no-interaction; then
        echo "✅ Database seeded successfully"
    else
        echo "⚠️  Seeding failed, but continuing..."
    fi
else
    echo "📊 Database already has $USER_COUNT users, skipping seeding"
fi

# Cache configurations (optional, continue on failure)
echo "⚡ Caching configurations..."
php artisan config:cache 2>/dev/null && echo "✅ Config cached" || echo "⚠️  Config cache skipped"
php artisan route:cache 2>/dev/null && echo "✅ Routes cached" || echo "⚠️  Route cache skipped"
php artisan view:cache 2>/dev/null && echo "✅ Views cached" || echo "⚠️  View cache skipped"

# Start the server
echo "🌐 Starting Laravel server on port ${PORT:-8000}..."
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
