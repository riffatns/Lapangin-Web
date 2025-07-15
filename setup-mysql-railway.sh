#!/bin/bash

echo "🚀 Setup MySQL Database for Railway"

# Function to log with timestamp
log_with_time() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1"
}

log_with_time "=== Railway MySQL Setup ==="

# Check if we can add MySQL service
log_with_time "Checking current project status..."
railway status

# The MySQL service needs to be added manually through Railway dashboard
# This script will prepare the environment for when MySQL is added

log_with_time "=== Instructions for Adding MySQL Service ==="
echo "1. Go to Railway Dashboard (https://railway.app)"
echo "2. Open project: helpful-quietude"
echo "3. Click 'Add Service' or '+' button"
echo "4. Select 'Database' -> 'MySQL'"
echo "5. Wait for MySQL service to be provisioned (2-3 minutes)"
echo ""

log_with_time "=== After MySQL Service is Added ==="
echo "The following environment variables will be automatically set:"
echo "- MYSQL_DATABASE"
echo "- MYSQL_ROOT_PASSWORD"
echo "- RAILWAY_PRIVATE_DOMAIN"
echo "- MYSQLHOST"
echo "- MYSQLPORT"
echo "- MYSQLDATABASE"
echo "- MYSQLUSER"
echo "- MYSQLPASSWORD"
echo ""

# Wait for user confirmation
read -p "Press Enter after you've added MySQL service in Railway Dashboard..."

log_with_time "=== Testing MySQL Connection ==="

# Test connection with different variable combinations
test_connection() {
    local method=$1
    local host=$2
    local port=$3
    local database=$4
    local username=$5
    local password=$6
    
    if [ -n "$host" ] && [ -n "$password" ]; then
        log_with_time "Testing $method connection..."
        php -r "
            try {
                \$pdo = new PDO('mysql:host=$host;port=$port;dbname=$database', '$username', '$password', [
                    PDO::ATTR_TIMEOUT => 30,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]);
                echo '✅ $method connection: SUCCESS\\n';
                return true;
            } catch(Exception \$e) {
                echo '❌ $method connection: ' . \$e->getMessage() . '\\n';
                return false;
            }
        "
        return $?
    else
        log_with_time "❌ Missing variables for $method"
        return 1
    fi
}

# Get current environment variables
log_with_time "Fetching current environment variables..."
railway variables > /tmp/railway_vars.txt

# Extract database variables
MYSQL_HOST=$(railway variables --kv | grep MYSQLHOST | cut -d'=' -f2)
MYSQL_PORT=$(railway variables --kv | grep MYSQLPORT | cut -d'=' -f2)
MYSQL_DB=$(railway variables --kv | grep MYSQLDATABASE | cut -d'=' -f2)
MYSQL_USER=$(railway variables --kv | grep MYSQLUSER | cut -d'=' -f2)
MYSQL_PASS=$(railway variables --kv | grep MYSQLPASSWORD | cut -d'=' -f2)

RAILWAY_DOMAIN=$(railway variables --kv | grep RAILWAY_PRIVATE_DOMAIN | cut -d'=' -f2)
MYSQL_ROOT_PASS=$(railway variables --kv | grep MYSQL_ROOT_PASSWORD | cut -d'=' -f2)
MYSQL_DATABASE=$(railway variables --kv | grep MYSQL_DATABASE | cut -d'=' -f2)

# Test connections
CONNECTION_SUCCESS=false

if test_connection "Railway Standard" "$RAILWAY_DOMAIN" "3306" "${MYSQL_DATABASE:-railway}" "root" "$MYSQL_ROOT_PASS"; then
    CONNECTION_SUCCESS=true
elif test_connection "MySQL Variables" "$MYSQL_HOST" "${MYSQL_PORT:-3306}" "${MYSQL_DB:-railway}" "${MYSQL_USER:-root}" "$MYSQL_PASS"; then
    CONNECTION_SUCCESS=true
fi

if [ "$CONNECTION_SUCCESS" = true ]; then
    log_with_time "✅ Database connection successful!"
    
    # Run migrations
    log_with_time "Running database migrations..."
    railway run php artisan migrate --force
    
    # Seed database
    log_with_time "Seeding database..."
    railway run php artisan db:seed --force
    
    log_with_time "🎉 Database setup completed!"
else
    log_with_time "❌ Database connection failed"
    log_with_time "Please check if MySQL service is running and environment variables are set"
fi

echo ""
log_with_time "=== Setup Complete ==="
