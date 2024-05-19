<?php

// Include the database configuration file
require_once 'config/dbconfig.php';

// Function to connect to the database using PDO
function connectDB()
{
    try {
        // Connect to MySQL without specifying a database
        $dsn = "mysql:host=" . DB_HOST;
        $conn = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Create the database if it does not exist
        $dbName = "`" . str_replace("`", "``", DB_NAME) . "`";
        $conn->exec("CREATE DATABASE IF NOT EXISTS $dbName");

        // Connect to the newly created database
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
        $conn = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Create tables if they do not exist
        $conn->exec("CREATE TABLE IF NOT EXISTS services (
                        id INT(11) AUTO_INCREMENT PRIMARY KEY,
                        title VARCHAR(255) NOT NULL,
                        image VARCHAR(255) NOT NULL,
                        description TEXT
                    )");

        $conn->exec("CREATE TABLE IF NOT EXISTS habitats (
                        id INT(11) AUTO_INCREMENT PRIMARY KEY,
                        name VARCHAR(255) NOT NULL,
                        images VARCHAR(255) NOT NULL,
                        description TEXT,
                        habitat_comment TEXT
                    )");

        $conn->exec("CREATE TABLE IF NOT EXISTS animals (
                        id INT(11) AUTO_INCREMENT PRIMARY KEY,
                        name VARCHAR(255) NOT NULL,
                        race VARCHAR(255) NOT NULL,
                        image VARCHAR(255) NOT NULL,
                        habitat_id INT(11) NOT NULL,
                        animal_status TEXT,
                        FOREIGN KEY (habitat_id) REFERENCES habitats(id)
                    );");

        $conn->exec("CREATE TABLE IF NOT EXISTS vet_reports (
                        id INT(11) AUTO_INCREMENT PRIMARY KEY,
                        animal_id INT(11) NOT NULL,
                        passing_date DATE NOT NULL,
                        creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        detail TEXT,
                        FOREIGN KEY (animal_id) REFERENCES animals(id)
                    )");

        $conn->exec("CREATE TABLE IF NOT EXISTS food_reports (
                        foodreport_ID INT(11) AUTO_INCREMENT PRIMARY KEY,
                        animal_id INT(11) NOT NULL,
                        animal_fed VARCHAR(255) NOT NULL,
                        food_type VARCHAR(255) NOT NULL,
                        feeding_time TIME NOT NULL,
                        feeding_date DATE NOT NULL,
                        FOREIGN KEY (animal_id) REFERENCES animals(id)
                    )");

        $conn->exec("CREATE TABLE IF NOT EXISTS users (
                        id INT(11) AUTO_INCREMENT PRIMARY KEY,
                        email VARCHAR(100) NOT NULL UNIQUE,
                        first_name VARCHAR(50) NOT NULL,
                        last_name VARCHAR(255) NOT NULL,
                        password VARCHAR(255) NOT NULL,
                        role VARCHAR(100) NOT NULL
                    )");

        $conn->exec("CREATE TABLE IF NOT EXISTS reviews (
                        id INT(11) AUTO_INCREMENT PRIMARY KEY,
                        pseudo VARCHAR(255) NOT NULL,
                        content TEXT NOT NULL,
                        isPublished BOOLEAN DEFAULT NULL
                    )");

        return $conn;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

// Function to load fixtures into the database
function loadFixtures($conn)
{
    $habitats = [
        ['name' => 'Savane', 'images' => 'https://via.placeholder.com/150', 'description' => 'Lorem ipsum dolor sit amet.', 'habitat_comment' => 'Savane habitat.'],
        ['name' => 'Marais', 'images' => 'https://via.placeholder.com/150', 'description' => 'Lorem ipsum dolor sit amet.', 'habitat_comment' => 'Marais habitat.'],
        ['name' => 'Jungle', 'images' => 'https://via.placeholder.com/150', 'description' => 'Lorem ipsum dolor sit amet.', 'habitat_comment' => 'Jungle habitat.'],
    ];

    $animals = [
        ['name' => 'Lion', 'race' => 'Panthera leo', 'image' => 'https://via.placeholder.com/150', 'habitat_id' => 1, 'animal_status' => 'Healthy'],
        ['name' => 'Crocodile', 'race' => 'Crocodylus niloticus', 'image' => 'https://via.placeholder.com/150', 'habitat_id' => 2, 'animal_status' => 'Healthy'],
        ['name' => 'Jaguar', 'race' => 'Panthera onca', 'image' => 'https://via.placeholder.com/150', 'habitat_id' => 3, 'animal_status' => 'Healthy'],
    ];

    $services = [
        ['title' => 'Guided Tour', 'image' => 'https://via.placeholder.com/150', 'description' => 'Lorem ipsum dolor sit amet.'],
        ['title' => 'Animal Feeding', 'image' => 'https://via.placeholder.com/150', 'description' => 'Lorem ipsum dolor sit amet.'],
        ['title' => 'Kids Playground', 'image' => 'https://via.placeholder.com/150', 'description' => 'Lorem ipsum dolor sit amet.'],
    ];

    $users = [
        ['email' => 'employee1@example.com', 'first_name' => 'John', 'last_name' => 'Doe', 'password' => password_hash('password1', PASSWORD_DEFAULT), 'role' => 'employé'],
        ['email' => 'vet1@example.com', 'first_name' => 'Jane', 'last_name' => 'Doe', 'password' => password_hash('password2', PASSWORD_DEFAULT), 'role' => 'vétérinaire'],
        ['email' => 'employee2@example.com', 'first_name' => 'Jim', 'last_name' => 'Beam', 'password' => password_hash('password3', PASSWORD_DEFAULT), 'role' => 'employé'],
    ];

    $reviews = [
        ['pseudo' => 'visitor1', 'content' => 'Amazing experience!', 'isPublished' => true],
        ['pseudo' => 'visitor2', 'content' => 'Loved the animals!', 'isPublished' => true],
        ['pseudo' => 'visitor3', 'content' => 'Great service!', 'isPublished' => true],
    ];

    $vetReports = [
        ['animal_id' => 1, 'passing_date' => '2024-05-01', 'detail' => 'Routine checkup.'],
        ['animal_id' => 2, 'passing_date' => '2024-05-02', 'detail' => 'Vaccination.'],
        ['animal_id' => 3, 'passing_date' => '2024-05-03', 'detail' => 'Minor injury.'],
    ];

    $foodReports = [
        ['animal_id' => 1, 'animal_fed' => 'Lion', 'food_type' => 'Meat', 'feeding_time' => '12:00:00', 'feeding_date' => '2024-05-01'],
        ['animal_id' => 2, 'animal_fed' => 'Crocodile', 'food_type' => 'Fish', 'feeding_time' => '13:00:00', 'feeding_date' => '2024-05-02'],
        ['animal_id' => 3, 'animal_fed' => 'Jaguar', 'food_type' => 'Meat', 'feeding_time' => '14:00:00', 'feeding_date' => '2024-05-03'],
    ];

    // Function to insert data if the table has less than 3 records
    function insertData($conn, $table, $data)
    {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM $table");
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count < 3) {
            foreach ($data as $row) {
                $columns = implode(", ", array_keys($row));
                $values = implode(", ", array_map(fn($value) => ":$value", array_keys($row)));
                $stmt = $conn->prepare("INSERT INTO $table ($columns) VALUES ($values)");
                foreach ($row as $key => &$value) {
                    $stmt->bindParam(":$key", $value);
                }
                $stmt->execute();
            }
        }
    }

    insertData($conn, 'habitats', $habitats);
    insertData($conn, 'animals', $animals);
    insertData($conn, 'services', $services);
    insertData($conn, 'users', $users);
    insertData($conn, 'reviews', $reviews);
    insertData($conn, 'vet_reports', $vetReports);
    insertData($conn, 'food_reports', $foodReports);
}

// Call the connectDB function and load fixtures
$conn = connectDB();
loadFixtures($conn);