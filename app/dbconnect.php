<?php

// Include the database configuration file
require_once 'config/dbconfig.php';

// Include the Service class
require_once 'Models/Service.php';

// Function to connect to the database using PDO
function connectDB() {
    try {
        // Set Data Source Name
        $dsn = "mysql:host=" . DB_HOST . ";";
        // Create a new PDO instance
        $conn = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Check if the database exists, if not, create it
        $dbName = "`" . str_replace("`", "``", DB_NAME) . "`";
        $conn->exec("CREATE DATABASE IF NOT EXISTS $dbName");
        $conn->exec("USE $dbName");

        // Create the table for the Service class if it doesn't exist
        $conn->exec("CREATE TABLE IF NOT EXISTS services (
                        id INT(11) AUTO_INCREMENT PRIMARY KEY,
                        title VARCHAR(255) NOT NULL,
                        image VARCHAR(255) NOT NULL,
                        description TEXT
                    )");

        return $conn;
    } catch (PDOException $e) {
        // Handle connection errors
        die("Connection failed: " . $e->getMessage());
    }
}

// Call the connectDB function
$conn = connectDB();