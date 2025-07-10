<?php

// Check Railway Environment Variables
echo "=== Railway Environment Check ===\n";

$requiredVars = [
    'RAILWAY_STATIC_URL',
    'MYSQLHOST',
    'MYSQLPORT', 
    'MYSQLDATABASE',
    'MYSQLUSER',
    'MYSQLPASSWORD'
];

foreach ($requiredVars as $var) {
    $value = env($var);
    echo "$var: " . ($value ? '✅ Set' : '❌ Missing') . "\n";
}

echo "\n=== Database Connection Test ===\n";
try {
    DB::connection()->getPdo();
    echo "✅ Database connection successful\n";
    
    // Test migration table
    $migrations = DB::table('migrations')->count();
    echo "✅ Migrations table exists ($migrations records)\n";
    
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
}

echo "\n=== Laravel Configuration ===\n";
echo "APP_ENV: " . config('app.env') . "\n";
echo "APP_DEBUG: " . (config('app.debug') ? 'true' : 'false') . "\n";
echo "APP_URL: " . config('app.url') . "\n";
echo "DB_CONNECTION: " . config('database.default') . "\n";
echo "MAIL_MAILER: " . config('mail.default') . "\n";

?>
