#!/bin/bash
set -e

echo "🚀 Starting Laravel application..."

# Wait for database to be ready with proper connection test
echo "⏳ Waiting for database connection..."
echo "Database info: $DB_HOST:$DB_PORT/$DB_DATABASE"

# Create a simple PHP script to test database connection
cat > /tmp/db_test.php << 'EOF'
<?php
$maxTries = 60; // 5 minutes
$tries = 0;

while ($tries < $maxTries) {
    try {
        $host = $_ENV['DB_HOST'] ?? 'localhost';
        $port = $_ENV['DB_PORT'] ?? '5432';
        $database = $_ENV['DB_DATABASE'] ?? 'lapangin';
        $username = $_ENV['DB_USERNAME'] ?? 'lapangin_user';
        $password = $_ENV['DB_PASSWORD'] ?? '';
        
        $dsn = "pgsql:host=$host;port=$port;dbname=$database";
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        echo "✅ Database connection successful!\n";
        exit(0);
    } catch (Exception $e) {
        $tries++;
        echo "⏳ Database not ready (attempt $tries/$maxTries): " . $e->getMessage() . "\n";
        sleep(5);
    }
}

echo "❌ Database connection failed after all attempts\n";
exit(1);
EOF

# Test database connection
php /tmp/db_test.php

# Run the build script for initial setup
echo "🔧 Running initial setup..."
./build.sh

echo "✅ Laravel application ready!"

# Start Apache
exec apache2-foreground