<?php
echo "=== Environment Variables Debug ===\n";

// Check MySQL variables
$mysqlVars = ['MYSQLHOST', 'MYSQLDATABASE', 'MYSQLUSER', 'MYSQLPASSWORD', 'MYSQLPORT'];
echo "\n--- MySQL Variables ---\n";
foreach ($mysqlVars as $var) {
    $value = getenv($var) ?: 'NOT SET';
    echo "$var: $value\n";
}

// Check Laravel DB variables
$dbVars = ['DB_HOST', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD', 'DB_PORT'];
echo "\n--- Laravel DB Variables ---\n";
foreach ($dbVars as $var) {
    $value = getenv($var) ?: 'NOT SET';
    echo "$var: $value\n";
}

// Test connection with preferred variables
echo "\n--- Testing Database Connection ---\n";
try {
    $host = getenv('MYSQLHOST') ?: getenv('DB_HOST') ?: 'NOT SET';
    $database = getenv('MYSQLDATABASE') ?: getenv('DB_DATABASE') ?: 'NOT SET';
    $username = getenv('MYSQLUSER') ?: getenv('DB_USERNAME') ?: 'NOT SET';
    $password = getenv('MYSQLPASSWORD') ?: getenv('DB_PASSWORD') ?: 'NOT SET';
    
    echo "Using: " . (getenv('MYSQLHOST') ? 'Railway MySQL vars' : 'Laravel DB vars') . "\n";
    echo "Connecting to: $host:3306\n";
    echo "Database: $database\n";
    echo "Username: $username\n";
    
    if ($host !== 'NOT SET' && $database !== 'NOT SET') {
        $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        echo "✅ Connection successful!\n";
        echo "Tables found: " . count($tables) . "\n";
        
        if (count($tables) > 0) {
            echo "All tables:\n";
            foreach ($tables as $table) {
                echo "  - $table\n";
            }
            
            // Test users table
            if (in_array('users', $tables)) {
                $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
                $count = $stmt->fetch(PDO::FETCH_ASSOC);
                echo "Users count: " . $count['count'] . "\n";
            }
        }
    } else {
        echo "❌ Missing database environment variables\n";
    }
} catch (Exception $e) {
    echo "❌ Connection failed: " . $e->getMessage() . "\n";
}
?>
