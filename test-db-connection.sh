#!/bin/bash

echo "🔍 Quick Database Connection Test"

# Get all database-related variables
echo "=== Current Database Environment Variables ==="
railway variables --kv | grep -E "(MYSQL|DB_|RAILWAY)" | sort

echo ""
echo "=== Testing Database Connection ==="

# Test with railway run command
echo "Testing database connection..."
railway run php -r "
    try {
        \$config = [
            'host' => getenv('MYSQLHOST') ?: getenv('RAILWAY_PRIVATE_DOMAIN'),
            'port' => getenv('MYSQLPORT') ?: '3306',
            'database' => getenv('MYSQLDATABASE') ?: getenv('MYSQL_DATABASE') ?: 'railway',
            'username' => getenv('MYSQLUSER') ?: 'root',
            'password' => getenv('MYSQLPASSWORD') ?: getenv('MYSQL_ROOT_PASSWORD')
        ];
        
        echo 'Using connection:' . PHP_EOL;
        echo 'Host: ' . \$config['host'] . PHP_EOL;
        echo 'Port: ' . \$config['port'] . PHP_EOL;
        echo 'Database: ' . \$config['database'] . PHP_EOL;
        echo 'Username: ' . \$config['username'] . PHP_EOL;
        echo 'Password: ' . (\$config['password'] ? '[HIDDEN]' : 'NOT SET') . PHP_EOL;
        
        if (!\$config['host'] || !\$config['password']) {
            echo 'ERROR: Missing required database configuration' . PHP_EOL;
            exit(1);
        }
        
        \$dsn = \"mysql:host={\$config['host']};port={\$config['port']};dbname={\$config['database']}\";
        \$pdo = new PDO(\$dsn, \$config['username'], \$config['password'], [
            PDO::ATTR_TIMEOUT => 30,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        
        echo 'SUCCESS: Database connection established!' . PHP_EOL;
        
        // Test basic query
        \$result = \$pdo->query('SELECT VERSION() as version')->fetch();
        echo 'MySQL Version: ' . \$result['version'] . PHP_EOL;
        
        // List tables
        \$tables = \$pdo->query('SHOW TABLES')->fetchAll();
        echo 'Tables count: ' . count(\$tables) . PHP_EOL;
        
    } catch(Exception \$e) {
        echo 'ERROR: ' . \$e->getMessage() . PHP_EOL;
        exit(1);
    }
"

if [ $? -eq 0 ]; then
    echo ""
    echo "✅ Database connection works! Ready to run migrations."
    echo ""
    echo "Run these commands to setup database:"
    echo "railway run php artisan migrate --force"
    echo "railway run php artisan db:seed --force"
else
    echo ""
    echo "❌ Database connection failed!"
    echo ""
    echo "Next steps:"
    echo "1. Add MySQL service in Railway Dashboard"
    echo "2. Wait for MySQL service to be 'Running'"
    echo "3. Run this script again"
fi
