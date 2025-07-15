#!/bin/bash

echo "🚀 Railway Database Migration Script"

# Check environment variables
if [ -z "$MYSQLHOST" ] && [ -z "$RAILWAY_PRIVATE_DOMAIN" ]; then
    echo "❌ Error: Database environment variables not set"
    exit 1
fi

# Use Railway variables if available
DB_HOST=${MYSQLHOST:-$RAILWAY_PRIVATE_DOMAIN}
DB_PORT=${MYSQLPORT:-3306}
DB_DATABASE=${MYSQLDATABASE:-$MYSQL_DATABASE}
DB_USER=${MYSQLUSER:-root}

echo "📡 Database Info:"
echo "   Host: $DB_HOST"
echo "   Port: $DB_PORT"
echo "   Database: $DB_DATABASE"
echo "   User: $DB_USER"

# Test connection first
echo "🔍 Testing database connection..."
php debug-railway-db.php

# Wait for database to be ready
echo "⏳ Waiting for database to be ready..."
for i in {1..30}; do
    if timeout 30 bash check-db.sh; then
        echo "✅ Database is ready!"
        break
    else
        echo "🔄 Attempt $i/30: Database not ready, waiting 10 seconds..."
        sleep 10
    fi
    
    if [ $i -eq 30 ]; then
        echo "❌ Database connection timeout"
        exit 1
    fi
done

# Clear any cached configs
echo "🧹 Clearing cached configurations..."
php artisan config:clear || echo "Config clear skipped"
php artisan route:clear || echo "Route clear skipped"
php artisan view:clear || echo "View clear skipped"

# Run migrations
echo "📊 Running database migrations..."
php artisan migrate:status
php artisan migrate --force --no-interaction --verbose

if [ $? -eq 0 ]; then
    echo "✅ Migrations completed successfully"
else
    echo "❌ Migration failed"
    exit 1
fi

# Check migration status
echo "📋 Migration status:"
php artisan migrate:status

# Seed database if empty
echo "🌱 Checking if database needs seeding..."
USER_COUNT=$(php artisan tinker --execute="echo App\Models\User::count();" 2>/dev/null | tail -n1 || echo "0")

if [ "$USER_COUNT" = "0" ] || [ "$USER_COUNT" = "" ]; then
    echo "🌱 Database is empty, seeding with sample data..."
    php artisan db:seed --force --no-interaction
    echo "✅ Database seeded successfully"
else
    echo "📊 Database already has $USER_COUNT users, skipping seeding"
fi

echo "🎉 Migration script completed!"
