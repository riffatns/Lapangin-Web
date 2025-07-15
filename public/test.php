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
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=lapangin_db', 'root', '');
    echo "<p style='color:green'>✅ Database connection: OK</p>";
    
    $userCount = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
    echo "<p>Users in database: " . $userCount . "</p>";
    
} catch (Exception $e) {
    echo "<p style='color:red'>❌ Database error: " . $e->getMessage() . "</p>";
}

echo "
    <h2>Laravel Test</h2>
    <p><a href='/'>Go to Laravel App</a></p>
    <p><a href='/register'>Register Page</a></p>
    <p><a href='/login'>Login Page</a></p>
</body>
</html>";
?>
