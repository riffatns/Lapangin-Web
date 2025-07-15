#!/bin/bash

echo "🚀 Force Railway Database Setup"

# Show all environment variables
echo "=== Environment Variables ==="
env | grep -E "(MYSQL|DB_|RAILWAY)" | sort

# Test database connection
echo -e "\n=== Testing Database Connection ==="
php simple-db-test.php

# If connection fails, try to diagnose
if [ $? -ne 0 ]; then
    echo -e "\n❌ Database connection failed. Checking service status..."
    
    # Check if variables are set
    if [ -z "$MYSQL_ROOT_PASSWORD" ] && [ -z "$MYSQLPASSWORD" ]; then
        echo "❌ No database password found. Check if MySQL service is properly configured."
        exit 1
    fi
    
    if [ -z "$RAILWAY_PRIVATE_DOMAIN" ] && [ -z "$MYSQLHOST" ]; then
        echo "❌ No database host found. Check if MySQL service is running."
        exit 1
    fi
    
    echo "⚠️  Database connection failed but variables are set. MySQL service might be starting..."
    echo "Waiting 30 seconds for MySQL service to be ready..."
    sleep 30
    
    # Try again
    echo "Retrying database connection..."
    php simple-db-test.php
    
    if [ $? -ne 0 ]; then
        echo "❌ Database still not ready. Check Railway dashboard for MySQL service status."
        exit 1
    fi
fi

# Clear Laravel cache
echo -e "\n=== Clearing Laravel Cache ==="
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Run migrations
echo -e "\n=== Running Migrations ==="
php artisan migrate --force --verbose

if [ $? -eq 0 ]; then
    echo "✅ Migrations completed successfully"
    
    # Check migration status
    echo -e "\n=== Migration Status ==="
    php artisan migrate:status
    
    # Seed if needed
    echo -e "\n=== Checking for Seeding ==="
    USER_COUNT=$(php artisan tinker --execute="echo \App\Models\User::count();" 2>/dev/null | tail -n1)
    
    if [ "$USER_COUNT" = "0" ] || [ -z "$USER_COUNT" ]; then
        echo "Database is empty. Seeding..."
        php artisan db:seed --force
        echo "✅ Seeding completed"
    else
        echo "Database has $USER_COUNT users. Skipping seeding."
    fi
    
else
    echo "❌ Migration failed"
    exit 1
fi

echo -e "\n🎉 Database setup completed successfully!"
