<?php
// Include the database configuration file
require_once 'config/dbconfig.php';

// Function to connect to the database using PDO
function connectDB() {
    try {
        // Set Data Source Name
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
        // Create a new PDO instance
        $conn = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        // Handle connection errors
        die("Connection failed: " . $e->getMessage());
    }
}

// Call the connectDB function
$conn = connectDB();