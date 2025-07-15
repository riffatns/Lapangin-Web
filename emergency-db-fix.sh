#!/bin/bash

echo "🚀 Emergency Railway Database Fix"

# Show current working directory and files
echo "Current directory: $(pwd)"
echo "Files in directory:"
ls -la

# Show ALL environment variables
echo -e "\n=== ALL ENVIRONMENT VARIABLES ==="
env | sort

# Test basic network connectivity
echo -e "\n=== Network Connectivity Test ==="
if command -v ping &> /dev/null; then
    echo "Testing network connectivity..."
    ping -c 3 google.com || echo "Network test failed"
fi

# Try different connection methods
echo -e "\n=== Database Connection Tests ==="

# Method 1: Using Railway variables
if [ -n "$RAILWAY_PRIVATE_DOMAIN" ] && [ -n "$MYSQL_ROOT_PASSWORD" ]; then
    echo "Method 1: Railway Private Domain"
    php -r "
        try {
            \$pdo = new PDO('mysql:host={$RAILWAY_PRIVATE_DOMAIN};port=3306;dbname=railway', 'root', '{$MYSQL_ROOT_PASSWORD}');
            echo '✅ Railway Private Domain connection: SUCCESS\n';
        } catch(Exception \$e) {
            echo '❌ Railway Private Domain connection: ' . \$e->getMessage() . '\n';
        }
    "
fi

# Method 2: Using MySQL* variables
if [ -n "$MYSQLHOST" ] && [ -n "$MYSQLPASSWORD" ]; then
    echo "Method 2: MySQL* Variables"
    php -r "
        try {
            \$pdo = new PDO('mysql:host={$MYSQLHOST};port={$MYSQLPORT};dbname={$MYSQLDATABASE}', '{$MYSQLUSER}', '{$MYSQLPASSWORD}');
            echo '✅ MySQL* variables connection: SUCCESS\n';
        } catch(Exception \$e) {
            echo '❌ MySQL* variables connection: ' . \$e->getMessage() . '\n';
        }
    "
fi

# Method 3: Using MYSQL_URL if available
if [ -n "$MYSQL_URL" ]; then
    echo "Method 3: MYSQL_URL"
    php -r "
        try {
            \$pdo = new PDO('{$MYSQL_URL}');
            echo '✅ MYSQL_URL connection: SUCCESS\n';
        } catch(Exception \$e) {
            echo '❌ MYSQL_URL connection: ' . \$e->getMessage() . '\n';
        }
    "
fi

# Check if Laravel can connect
echo -e "\n=== Laravel Database Test ==="
if [ -f artisan ]; then
    echo "Testing Laravel database connection..."
    php artisan tinker --execute="
        try {
            DB::connection()->getPdo();
            echo 'Laravel DB connection: SUCCESS\n';
        } catch(Exception \$e) {
            echo 'Laravel DB connection: ' . \$e->getMessage() . '\n';
        }
    " 2>/dev/null || echo "Laravel tinker failed"
else
    echo "artisan file not found"
fi

# Try to create database manually
echo -e "\n=== Manual Database Creation ==="
if [ -n "$RAILWAY_PRIVATE_DOMAIN" ] && [ -n "$MYSQL_ROOT_PASSWORD" ]; then
    php -r "
        try {
            \$pdo = new PDO('mysql:host={$RAILWAY_PRIVATE_DOMAIN};port=3306', 'root', '{$MYSQL_ROOT_PASSWORD}');
            \$pdo->exec('CREATE DATABASE IF NOT EXISTS railway');
            echo '✅ Database railway created/exists\n';
        } catch(Exception \$e) {
            echo '❌ Database creation failed: ' . \$e->getMessage() . '\n';
        }
    "
fi

echo -e "\n=== Emergency Fix Complete ==="
