#!/bin/bash

# Simple database connection test
echo "Testing database connection..."

if [ -z "$MYSQLHOST" ] && [ -z "$RAILWAY_PRIVATE_DOMAIN" ]; then
    echo "Error: Missing required database environment variables"
    echo "Required: MYSQLHOST or RAILWAY_PRIVATE_DOMAIN"
    echo "Also required: MYSQLPORT, MYSQLDATABASE/MYSQL_DATABASE, MYSQLUSER, MYSQLPASSWORD/MYSQL_ROOT_PASSWORD"
    exit 1
fi

# Test connection with timeout
timeout 30 php -r "
    \$host = getenv('MYSQLHOST') ?: getenv('RAILWAY_PRIVATE_DOMAIN');
    \$port = getenv('MYSQLPORT') ?: '3306';
    \$database = getenv('MYSQLDATABASE') ?: getenv('MYSQL_DATABASE');
    \$username = getenv('MYSQLUSER') ?: 'root';
    \$password = getenv('MYSQLPASSWORD') ?: getenv('MYSQL_ROOT_PASSWORD');
    
    echo \"Testing connection to: \$host:\$port/\$database\n\";
    
    try {
        \$dsn = \"mysql:host=\$host;port=\$port;dbname=\$database\";
        \$pdo = new PDO(\$dsn, \$username, \$password, [
            PDO::ATTR_TIMEOUT => 30,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        echo \"Database connection successful!\n\";
        exit(0);
    } catch(Exception \$e) {
        echo \"Database connection failed: \" . \$e->getMessage() . \"\n\";
        exit(1);
    }
"

if [ $? -eq 0 ]; then
    echo "✅ Database connection verified"
    exit 0
else
    echo "❌ Database connection failed"
    exit 1
fi
