<?php
// Simple test page
echo "<!DOCTYPE html>
<html>
<head>
    <title>Lapangin Test</title>
</head>
<body>
    <h1>🚀 Lapangin Railway Test</h1>
    <p>Server is running!</p>
    <p>Time: " . date('Y-m-d H:i:s') . "</p>
    <p>PHP Version: " . phpversion() . "</p>
    <p>Environment: " . ($_ENV['APP_ENV'] ?? 'unknown') . "</p>
    
    <h2>Database Test</h2>";

try {
    // Try Railway MySQL variables first, then fallback to standard Laravel variables
    $host = getenv('MYSQLHOST') ?: getenv('DB_HOST') ?: '127.0.0.1';
    $database = getenv('MYSQLDATABASE') ?: getenv('DB_DATABASE') ?: 'lapangin_db';
    $username = getenv('MYSQLUSER') ?: getenv('DB_USERNAME') ?: 'root';
    $password = getenv('MYSQLPASSWORD') ?: getenv('DB_PASSWORD') ?: '';
    $port = getenv('MYSQLPORT') ?: getenv('DB_PORT') ?: '3306';
    
    echo "<p><strong>Connecting to:</strong> $host:$port</p>";
    echo "<p><strong>Database:</strong> $database</p>";
    echo "<p><strong>Username:</strong> $username</p>";
    echo "<p><strong>Using:</strong> " . (getenv('MYSQLHOST') ? 'Railway MySQL vars' : 'Laravel DB vars') . "</p>";
    
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✅ Database connected successfully!</p>";
    
    // Test if tables exist
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "<p><strong>Tables found:</strong> " . count($tables) . "</p>";
    if (count($tables) > 0) {
        echo "<ul>";
        foreach ($tables as $table) {
            echo "<li>$table</li>";
        }
        echo "</ul>";
        
        // If users table exists, count users
        if (in_array('users', $tables)) {
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
            $count = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<p><strong>Users count:</strong> " . $count['count'] . "</p>";
        }
    } else {
        echo "<p style='color: orange;'>⚠️ No tables found - migration needed</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Database error: " . $e->getMessage() . "</p>";
}

echo "
    <h2>Laravel Test</h2>
    <p><a href='/'>Go to Laravel App</a></p>
    <p><a href='/register'>Register Page</a></p>
    <p><a href='/login'>Login Page</a></p>
</body>
</html>";
?>
