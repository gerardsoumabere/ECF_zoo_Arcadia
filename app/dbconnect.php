<?php

// Include the database configuration file
require_once 'config/dbconfig.php';

// Include the Service class
require_once 'Models/Service.php';

// Include the Habitat class
require_once 'Models/Habitat.php';

// Include the VetReport class
require_once 'Models/VetReport.php';

// Function to connect to the database using PDO
function connectDB()
{
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

        // Create the table for the Habitat class if it doesn't exist
        $conn->exec("CREATE TABLE IF NOT EXISTS habitats (
                        id INT(11) AUTO_INCREMENT PRIMARY KEY,
                        name VARCHAR(255) NOT NULL,
                        images VARCHAR(255) NOT NULL,
                        description TEXT,
                        animal_list TEXT,
                        habitat_comment TEXT
                    )");

        // Create the table for the Animal class if it doesn't exist
        $conn->exec("CREATE TABLE IF NOT EXISTS animals (
                        id INT(11) AUTO_INCREMENT PRIMARY KEY,
                        name VARCHAR(255) NOT NULL,
                        race VARCHAR(255) NOT NULL,
                        image VARCHAR(255) NOT NULL,
                        habitat VARCHAR(255) NOT NULL,
                        animal_status TEXT
                    )");

        // Create the table for the VetReport class if it doesn't exist
        $conn->exec("CREATE TABLE IF NOT EXISTS vet_reports (
                        id INT(11) AUTO_INCREMENT PRIMARY KEY,
                        animal_id INT(11) NOT NULL,
                        passing_date DATE NOT NULL,
                        creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        detail TEXT
                    )");

        return $conn;
    } catch (PDOException $e) {
        // Handle connection errors
        die("Connection failed: " . $e->getMessage());
    }
}
 
// Call the connectDB function
$conn = connectDB();