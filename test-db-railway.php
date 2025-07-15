<?php

echo "🔍 Database Connection Test for Railway\n";

// Get environment variables
$envVars = [
    'DB_HOST' => getenv('DB_HOST'),
    'DB_PORT' => getenv('DB_PORT'),
    'DB_DATABASE' => getenv('DB_DATABASE'),
    'DB_USERNAME' => getenv('DB_USERNAME'),
    'DB_PASSWORD' => getenv('DB_PASSWORD'),
    'MYSQLHOST' => getenv('MYSQLHOST'),
    'MYSQLPORT' => getenv('MYSQLPORT'),
    'MYSQLDATABASE' => getenv('MYSQLDATABASE'),
    'MYSQLUSER' => getenv('MYSQLUSER'),
    'MYSQLPASSWORD' => getenv('MYSQLPASSWORD'),
    'RAILWAY_PRIVATE_DOMAIN' => getenv('RAILWAY_PRIVATE_DOMAIN'),
    'MYSQL_ROOT_PASSWORD' => getenv('MYSQL_ROOT_PASSWORD'),
    'MYSQL_DATABASE' => getenv('MYSQL_DATABASE'),
];

echo "=== Environment Variables ===\n";
foreach ($envVars as $key => $value) {
    $displayValue = $value;
    if (strpos($key, 'PASSWORD') !== false && $value) {
        $displayValue = '[HIDDEN]';
    }
    echo "$key: " . ($displayValue ?: 'NOT SET') . "\n";
}

echo "\n=== Connection Tests ===\n";

// Test configurations
$configs = [
    'Current DB_* Variables' => [
        'host' => getenv('DB_HOST'),
        'port' => getenv('DB_PORT') ?: '3306',
        'database' => getenv('DB_DATABASE'),
        'username' => getenv('DB_USERNAME'),
        'password' => getenv('DB_PASSWORD'),
    ],
    'MySQL* Variables' => [
        'host' => getenv('MYSQLHOST'),
        'port' => getenv('MYSQLPORT') ?: '3306',
        'database' => getenv('MYSQLDATABASE'),
        'username' => getenv('MYSQLUSER'),
        'password' => getenv('MYSQLPASSWORD'),
    ],
    'Railway Variables' => [
        'host' => getenv('RAILWAY_PRIVATE_DOMAIN'),
        'port' => '3306',
        'database' => getenv('MYSQL_DATABASE') ?: 'railway',
        'username' => 'root',
        'password' => getenv('MYSQL_ROOT_PASSWORD'),
    ],
];

$connectionWorking = false;

foreach ($configs as $name => $config) {
    echo "\nTesting $name:\n";
    
    if (!$config['host'] || !$config['database']) {
        echo "❌ Missing required configuration\n";
        continue;
    }
    
    echo "  Host: {$config['host']}\n";
    echo "  Port: {$config['port']}\n";
    echo "  Database: {$config['database']}\n";
    echo "  Username: {$config['username']}\n";
    echo "  Password: " . ($config['password'] ? '[HIDDEN]' : 'NOT SET') . "\n";
    
    try {
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']}";
        $pdo = new PDO($dsn, $config['username'], $config['password'], [
            PDO::ATTR_TIMEOUT => 10,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
        
        echo "  ✅ Connection: SUCCESS\n";
        
        // Test basic query
        $result = $pdo->query('SELECT VERSION() as version')->fetch();
        echo "  ✅ MySQL Version: {$result['version']}\n";
        
        // Count tables
        $tables = $pdo->query('SHOW TABLES')->fetchAll();
        echo "  ✅ Tables found: " . count($tables) . "\n";
        
        $connectionWorking = true;
        break;
        
    } catch (Exception $e) {
        echo "  ❌ Connection failed: " . $e->getMessage() . "\n";
    }
}

echo "\n=== Summary ===\n";
if ($connectionWorking) {
    echo "✅ Database connection is working!\n";
    echo "You can now run migrations:\n";
    echo "  railway run php artisan migrate --force\n";
    echo "  railway run php artisan db:seed --force\n";
} else {
    echo "❌ No database connection found!\n";
    echo "\nNext steps:\n";
    echo "1. Add MySQL service in Railway Dashboard\n";
    echo "2. Go to https://railway.app/dashboard\n";
    echo "3. Open your project: helpful-quietude\n";
    echo "4. Click 'Add Service' or '+' button\n";
    echo "5. Select 'Database' -> 'MySQL'\n";
    echo "6. Wait for MySQL service to be provisioned\n";
    echo "7. Run this test again\n";
}

echo "\n=== Test Complete ===\n";
?>
