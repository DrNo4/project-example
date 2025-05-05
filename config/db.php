<?php
// Database configuration
$host = 'localhost';
$dbname = 'contacts_app';
$username = 'root2';
$password = 'password';

try {
    // Connect without database first
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname`");
    $pdo->exec("USE `$dbname`");
    
    // Create contacts table if it doesn't exist
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS contacts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(50) NOT NULL,
            last_name VARCHAR(50) NOT NULL,
            phone VARCHAR(20) NOT NULL,
            email VARCHAR(100) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )
    ");
    
    // Add sample data if the table is empty
    $stmt = $pdo->query("SELECT COUNT(*) FROM contacts");
    $count = $stmt->fetchColumn();
    
    if ($count == 0) {
        $pdo->exec("
            INSERT INTO contacts (first_name, last_name, phone, email) VALUES
            ('John', 'Doe', '555-123-4567', 'john.doe@example.com'),
            ('Jane', 'Smith', '555-987-6543', 'jane.smith@example.com'),
            ('Bob', 'Johnson', '555-246-8135', 'bob.johnson@example.com'),
            ('Alice', 'Williams', '555-369-2580', 'alice.williams@example.com')
        ");
    }
    
    // Set default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    // Display error message
    die("Connection failed: " . $e->getMessage());
} 