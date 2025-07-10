<?php
/**
 * Manual Migration Script for Vercel/PlanetScale
 * Run this once after deploying to create database tables
 */

// Database connection details (update with your PlanetScale credentials)
$host = 'your-host.psdb.cloud';
$dbname = 'lapangin-db';
$username = 'your-username';
$password = 'your-password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    echo "Connected to database successfully!\n";

    // Create essential tables
    $migrations = [
        "CREATE TABLE IF NOT EXISTS users (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL,
            email_verified_at TIMESTAMP NULL,
            password VARCHAR(255) NOT NULL,
            phone VARCHAR(255) NULL,
            address TEXT NULL,
            remember_token VARCHAR(100) NULL,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL
        )",
        
        "CREATE TABLE IF NOT EXISTS sports (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            icon VARCHAR(255) NULL,
            sort_order INT NOT NULL DEFAULT 0,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL
        )",
        
        "CREATE TABLE IF NOT EXISTS venues (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description TEXT NULL,
            location VARCHAR(255) NOT NULL,
            price_per_hour DECIMAL(10,2) NOT NULL,
            sport_id BIGINT UNSIGNED NOT NULL,
            images JSON NULL,
            is_active BOOLEAN DEFAULT TRUE,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            FOREIGN KEY (sport_id) REFERENCES sports(id)
        )",
        
        "CREATE TABLE IF NOT EXISTS bookings (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id BIGINT UNSIGNED NOT NULL,
            venue_id BIGINT UNSIGNED NOT NULL,
            booking_date DATE NOT NULL,
            selected_time_slots JSON NOT NULL,
            total_hours INT NOT NULL,
            total_amount DECIMAL(10,2) NOT NULL,
            status ENUM('pending', 'confirmed', 'cancelled', 'completed') DEFAULT 'pending',
            payment_status ENUM('pending', 'paid', 'failed') DEFAULT 'pending',
            rating INT NULL,
            review TEXT NULL,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            FOREIGN KEY (user_id) REFERENCES users(id),
            FOREIGN KEY (venue_id) REFERENCES venues(id)
        )"
    ];

    foreach ($migrations as $sql) {
        $pdo->exec($sql);
        echo "Table created successfully\n";
    }

    // Insert sample sports
    $sports = [
        ['Futsal', 'fas fa-futbol', 1],
        ['Basketball', 'fas fa-basketball-ball', 2],
        ['Badminton', 'fas fa-shuttlecock', 3],
        ['Tennis', 'fas fa-tennis-ball', 4],
        ['Volleyball', 'fas fa-volleyball-ball', 5]
    ];

    $stmt = $pdo->prepare("INSERT IGNORE INTO sports (name, icon, sort_order) VALUES (?, ?, ?)");
    foreach ($sports as $sport) {
        $stmt->execute($sport);
    }

    echo "Sample data inserted successfully\n";
    echo "Database setup completed!\n";

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}
