#!/bin/bash

echo "🔧 Manual Database Setup for Railway"

# Step 1: Emergency diagnosis
echo "=== Step 1: Emergency Diagnosis ==="
bash emergency-db-fix.sh

# Step 2: Test simple connection
echo -e "\n=== Step 2: Simple Connection Test ==="
if [ -n "$RAILWAY_PRIVATE_DOMAIN" ] && [ -n "$MYSQL_ROOT_PASSWORD" ]; then
    echo "Testing with Railway variables..."
    php -r "
        try {
            \$pdo = new PDO('mysql:host={$RAILWAY_PRIVATE_DOMAIN};port=3306;dbname=railway', 'root', '{$MYSQL_ROOT_PASSWORD}', [
                PDO::ATTR_TIMEOUT => 30,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            echo '✅ Base connection successful\n';
            
            // Test basic query
            \$result = \$pdo->query('SELECT 1 as test')->fetch();
            echo '✅ Query test: ' . \$result['test'] . '\n';
            
            // Show tables
            \$tables = \$pdo->query('SHOW TABLES')->fetchAll();
            echo '✅ Tables count: ' . count(\$tables) . '\n';
            
        } catch(Exception \$e) {
            echo '❌ Connection failed: ' . \$e->getMessage() . '\n';
            exit(1);
        }
    "
    
    if [ $? -eq 0 ]; then
        echo "✅ Database connection is working!"
    else
        echo "❌ Database connection failed"
        exit 1
    fi
else
    echo "❌ Missing Railway environment variables"
    exit 1
fi

# Step 3: Setup Laravel environment
echo -e "\n=== Step 3: Laravel Environment Setup ==="
php artisan config:clear
php artisan cache:clear

# Step 4: Run migrations
echo -e "\n=== Step 4: Database Migrations ==="
php artisan migrate --force --verbose

if [ $? -eq 0 ]; then
    echo "✅ Migrations successful"
else
    echo "❌ Migrations failed"
    exit 1
fi

# Step 5: Seed database
echo -e "\n=== Step 5: Database Seeding ==="
php artisan db:seed --force

if [ $? -eq 0 ]; then
    echo "✅ Seeding successful"
else
    echo "⚠️  Seeding failed but continuing..."
fi

# Step 6: Final test
echo -e "\n=== Step 6: Final Test ==="
php artisan tinker --execute="
    try {
        \$userCount = App\Models\User::count();
        echo 'User count: ' . \$userCount . '\n';
        echo 'Database setup completed successfully!\n';
    } catch(Exception \$e) {
        echo 'Final test failed: ' . \$e->getMessage() . '\n';
        exit(1);
    }
"

echo -e "\n🎉 Manual database setup completed!"
