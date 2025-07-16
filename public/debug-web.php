<?php
// Direct database test script for web container
echo "=== Web Container Database Test ===\n";

try {
    // Use Laravel configuration
    $host = getenv('DB_HOST') ?: 'mysql.railway.internal';
    $database = getenv('DB_DATABASE') ?: 'railway';
    $username = getenv('DB_USERNAME') ?: 'root';
    $password = getenv('DB_PASSWORD') ?: '';
    
    echo "Connecting to: $host:3306\n";
    echo "Database: $database\n";
    echo "Username: $username\n";
    
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Connection successful!\n";
    
    // Show tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
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
    } else {
        echo "No tables found!\n";
    }
    
} catch (Exception $e) {
    echo "❌ Connection failed: " . $e->getMessage() . "\n";
}
?>
