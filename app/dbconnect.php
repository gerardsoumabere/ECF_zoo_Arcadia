<?php

// Include the database configuration file
require_once 'config/dbconfig.php';


// Function to connect to the database using PDO
function connectDB()
{
    try {
        // Set Data Source Name
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
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
                        habitat_comment TEXT
                    )");

        // Create the table for the Animal class if it doesn't exist
        $conn->exec("CREATE TABLE IF NOT EXISTS animals (
                        id INT(11) AUTO_INCREMENT PRIMARY KEY,
                        name VARCHAR(255) NOT NULL,
                        race VARCHAR(255) NOT NULL,
                        image VARCHAR(255) NOT NULL,
                        habitat_id INT(11) NOT NULL,
                        animal_status TEXT,
                        FOREIGN KEY (habitat_id) REFERENCES habitats(id)
                    )");

        // Create the table for the VetReport class if it doesn't exist
        $conn->exec("CREATE TABLE IF NOT EXISTS vet_reports (
                        id INT(11) AUTO_INCREMENT PRIMARY KEY,
                        animal_id INT(11) NOT NULL,
                        passing_date DATE NOT NULL,
                        creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        detail TEXT,
                        FOREIGN KEY (animal_id) REFERENCES animals(id)
                    )");

        // Create the table for the FoodReport class if it doesn't exist
        $conn->exec("CREATE TABLE IF NOT EXISTS food_reports (
                        foodreport_ID INT(11) AUTO_INCREMENT PRIMARY KEY,
                        animal_fed VARCHAR(255) NOT NULL,
                        food_type VARCHAR(255) NOT NULL,
                        feeding_time TIME NOT NULL,
                        feeding_date DATE NOT NULL,
                        FOREIGN KEY (animal_id) REFERENCES animals(id)
                    )");

        // Create the table for the User class if it doesn't exist
        $conn->exec("CREATE TABLE IF NOT EXISTS users (
                        id INT(11) AUTO_INCREMENT PRIMARY KEY,
                        email VARCHAR(100) NOT NULL UNIQUE,
                        first_name VARCHAR(50) NOT NULL,
                        last_name VARCHAR(255) NOT NULL,
                        password VARCHAR(255) NOT NULL,
                        role VARCHAR(100) NOT NULL
                    )");

        // Create the table for the Review class if it doesn't exist
        $conn->exec("CREATE TABLE IF NOT EXISTS reviews (
                        id INT(11) AUTO_INCREMENT PRIMARY KEY,
                        pseudo VARCHAR(255) NOT NULL,
                        content TEXT NOT NULL,
                        isPublished BOOLEAN DEFAULT NULL
                    )");

        return $conn;
    } catch (PDOException $e) {
        // Handle connection errors
        die("Connection failed: " . $e->getMessage());
    }
}
 
// Call the connectDB function
$conn = connectDB();