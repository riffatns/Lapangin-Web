<?php
// Simple Railway Database Test
echo "=== Simple Railway DB Test ===\n";

// Display all environment variables related to database
echo "Environment Variables:\n";
foreach ($_ENV as $key => $value) {
    if (strpos($key, 'MYSQL') !== false || strpos($key, 'DB_') !== false || strpos($key, 'RAILWAY') !== false) {
        echo "$key = " . ($key === 'MYSQL_ROOT_PASSWORD' || $key === 'MYSQLPASSWORD' || $key === 'DB_PASSWORD' ? '[HIDDEN]' : $value) . "\n";
    }
}

echo "\n";

// Test with Railway environment variables
$configs = [
    'Railway Standard' => [
        'host' => $_ENV['RAILWAY_PRIVATE_DOMAIN'] ?? null,
        'port' => '3306',
        'database' => $_ENV['MYSQL_DATABASE'] ?? null,
        'username' => 'root',
        'password' => $_ENV['MYSQL_ROOT_PASSWORD'] ?? null,
    ],
    'Railway MySQL Variables' => [
        'host' => $_ENV['MYSQLHOST'] ?? null,
        'port' => $_ENV['MYSQLPORT'] ?? '3306',
        'database' => $_ENV['MYSQLDATABASE'] ?? null,
        'username' => $_ENV['MYSQLUSER'] ?? 'root',
        'password' => $_ENV['MYSQLPASSWORD'] ?? null,
    ],
];

foreach ($configs as $name => $config) {
    echo "\n--- Testing $name ---\n";
    
    if (!$config['host'] || !$config['database'] || !$config['password']) {
        echo "❌ Missing required variables for $name\n";
        continue;
    }
    
    echo "Host: {$config['host']}\n";
    echo "Port: {$config['port']}\n";
    echo "Database: {$config['database']}\n";
    echo "Username: {$config['username']}\n";
    
    try {
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']}";
        $pdo = new PDO($dsn, $config['username'], $config['password'], [
            PDO::ATTR_TIMEOUT => 10,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
        
        echo "✅ Connection successful!\n";
        
        // Test query
        $stmt = $pdo->query('SELECT 1 as test');
        $result = $stmt->fetch();
        echo "✅ Query test: " . $result['test'] . "\n";
        
        // Count tables
        $stmt = $pdo->query('SHOW TABLES');
        $tables = $stmt->fetchAll();
        echo "✅ Tables found: " . count($tables) . "\n";
        
        break; // Stop testing if successful
        
    } catch (Exception $e) {
        echo "❌ Connection failed: " . $e->getMessage() . "\n";
        echo "Error code: " . $e->getCode() . "\n";
    }
}

echo "\n=== Test Complete ===\n";
?>
