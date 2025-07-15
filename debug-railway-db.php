<?php

echo "=== Railway Database Debug ===\n";

// Check environment variables
$envVars = [
    'MYSQLHOST' => getenv('MYSQLHOST'),
    'MYSQLPORT' => getenv('MYSQLPORT'), 
    'MYSQLDATABASE' => getenv('MYSQLDATABASE'),
    'MYSQLUSER' => getenv('MYSQLUSER'),
    'MYSQLPASSWORD' => getenv('MYSQLPASSWORD') ? '[HIDDEN]' : null,
    'MYSQL_DATABASE' => getenv('MYSQL_DATABASE'),
    'MYSQL_ROOT_PASSWORD' => getenv('MYSQL_ROOT_PASSWORD') ? '[HIDDEN]' : null,
    'MYSQL_URL' => getenv('MYSQL_URL'),
    'MYSQL_PUBLIC_URL' => getenv('MYSQL_PUBLIC_URL'),
    'RAILWAY_PRIVATE_DOMAIN' => getenv('RAILWAY_PRIVATE_DOMAIN'),
    'RAILWAY_TCP_PROXY_DOMAIN' => getenv('RAILWAY_TCP_PROXY_DOMAIN'),
    'RAILWAY_TCP_PROXY_PORT' => getenv('RAILWAY_TCP_PROXY_PORT'),
    'DB_HOST' => getenv('DB_HOST'),
    'DB_PORT' => getenv('DB_PORT'),
    'DB_DATABASE' => getenv('DB_DATABASE'),
    'DB_USERNAME' => getenv('DB_USERNAME'),
    'DB_PASSWORD' => getenv('DB_PASSWORD') ? '[HIDDEN]' : null,
];

echo "\n--- Environment Variables ---\n";
foreach ($envVars as $key => $value) {
    echo "$key: " . ($value ? $value : 'NOT SET') . "\n";
}

// Test direct PDO connection
echo "\n--- Direct PDO Connection Test ---\n";
$host = getenv('MYSQLHOST') ?: getenv('RAILWAY_PRIVATE_DOMAIN');
$port = getenv('MYSQLPORT') ?: '3306';
$database = getenv('MYSQLDATABASE') ?: getenv('MYSQL_DATABASE');
$username = getenv('MYSQLUSER') ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: getenv('MYSQL_ROOT_PASSWORD');

echo "Using connection parameters:\n";
echo "  Host: $host\n";
echo "  Port: $port\n";
echo "  Database: $database\n";
echo "  Username: $username\n";
echo "  Password: " . ($password ? '[HIDDEN]' : 'NOT SET') . "\n";

if ($host && $port && $database && $username) {
    try {
        $dsn = "mysql:host=$host;port=$port;dbname=$database";
        echo "Trying to connect to: $dsn\n";
        echo "Username: $username\n";
        
        $pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_TIMEOUT => 30,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        
        echo "✅ Direct PDO connection successful!\n";
        
        // Test basic query
        $stmt = $pdo->query('SELECT VERSION() as version');
        $result = $stmt->fetch();
        echo "MySQL Version: " . $result['version'] . "\n";
        
        // List tables
        $stmt = $pdo->query('SHOW TABLES');
        $tables = $stmt->fetchAll();
        echo "Tables in database: " . count($tables) . "\n";
        foreach ($tables as $table) {
            echo "  - " . array_values($table)[0] . "\n";
        }
        
    } catch (Exception $e) {
        echo "❌ PDO connection failed: " . $e->getMessage() . "\n";
        echo "Error Code: " . $e->getCode() . "\n";
    }
} else {
    echo "❌ Missing required environment variables\n";
}

// Test Laravel config
echo "\n--- Laravel Database Config ---\n";
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
    
    try {
        $app = require_once __DIR__ . '/bootstrap/app.php';
        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
        
        $config = $app['config'];
        $dbConfig = $config['database.connections.mysql'];
        
        echo "Laravel MySQL Config:\n";
        echo "  Host: " . $dbConfig['host'] . "\n";
        echo "  Port: " . $dbConfig['port'] . "\n";
        echo "  Database: " . $dbConfig['database'] . "\n";
        echo "  Username: " . $dbConfig['username'] . "\n";
        echo "  Password: " . ($dbConfig['password'] ? '[HIDDEN]' : 'NOT SET') . "\n";
        
    } catch (Exception $e) {
        echo "❌ Laravel config error: " . $e->getMessage() . "\n";
    }
}

echo "\n=== Debug Complete ===\n";
