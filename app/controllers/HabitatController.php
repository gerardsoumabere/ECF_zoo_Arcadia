<?php

namespace Controllers;

require_once __DIR__ . '/../models/Habitat.php';

use Models\Habitat;
use Models\Animal;

class HabitatController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Get all habitats
    public function index() {
        try {
            $habitats = array();
            // SQL query to get all habitats from the database
            $sql = "SELECT * FROM habitats";
            $stmt = $this->conn->query($sql);

            // Get the results of the query
            while ($row = $stmt->fetch()) {
                // Use getAnimalsByHabitat to get animals for this habitat
                $animals = $this->getAnimalsByHabitat($row['id']);
                $habitat = new Habitat(
                    $row['id'],
                    $row['name'],
                    $row['images'],
                    $row['description'],
                    $animals, // Pass animals obtained from getAnimalsByHabitat
                    $row['habitat_comment'],
                    $this->conn
                );
                $habitats[] = $habitat;
            }

            return $habitats; // Return the habitats
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Get a habitat by its ID
    public function getById($id) {
        try {
            // SQL query to get a habitat by its ID
            $sql = "SELECT * FROM habitats WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch();

            // Use getAnimalsByHabitat to get animals for this habitat
            $animals = $this->getAnimalsByHabitat($row['id']);
            
            // Create and return a Habitat object with animals
            return new Habitat(
                $row['id'],
                $row['name'],
                $row['images'],
                $row['description'],
                $animals, // Pass animals obtained from getAnimalsByHabitat
                $row['habitat_comment'],
                $this->conn
            );
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Add a habitat
    public function add($name, $images, $description, $animalList, $habitatComment) {
        try {
            // Create a new habitat
            $habitat = new Habitat(null, $name, $images, $description, $animalList, $habitatComment, $this->conn);
            // Add the new habitat to the database
            $habitat->save();

            // Redirect to the /habitats route
            header("Location: /habitats");
            exit();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Update a habitat
    public function update($id, $name, $images, $description, $animalList, $habitatComment) {
        try {
            // Get the habitat to update
            $habitat = $this->getById($id);
            $habitat->setName($name);
            $habitat->setImages($images);
            $habitat->setDescription($description);
            // Update the habitat with the provided animalList
            $habitat->setAnimals($animalList);
            $habitat->setHabitatComment($habitatComment);

            // Update the habitat in the database
            $habitat->update();

            // Redirect to the /habitats route
            header("Location: /habitats");
            exit();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Delete a habitat
    public function delete($requestData) {
    try {
        // Get the ID of the habitat to delete from the request data
        $id = $requestData['id'];
        
        // Get the habitat by its ID
        $habitat = $this->getById($id);

        // Delete the habitat
        $habitat->delete();

        // Redirect to the /habitats route
        header("Location: /habitats");
        exit();

    } catch (\PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
}


    // Get habitat name by habitat id
    public function getHabitatName($habitatId) {
        try {
            $sql = "SELECT name FROM habitats WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $habitatId);
            $stmt->execute();
            $row = $stmt->fetch();
            return $row['name'];
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Get animals by habitat id
    public function getAnimalsByHabitat($habitatId) {
        try {
            $animals = array();
            // SQL query to get animals by habitat id
            $sql = "SELECT * FROM animals WHERE habitat_id = :habitat_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':habitat_id', $habitatId);
            $stmt->execute();

            // Get the results of the query
            while ($row = $stmt->fetch()) {
                $animal = new Animal(
                    $row['id'],
                    $row['name'],
                    $row['race'],
                    $row['image'],
                    $row['habitat_id'],
                    $row['animal_status'],
                    $this->conn
                );
                $animals[] = $animal;
            }

            return $animals; // Return the animals
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }
}