<?php

namespace Controllers;

require_once __DIR__ . '/../models/Animal.php';

use Models\Animal;

class AnimalController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Get all animals
    public function index() {
        try {
            $animals = array();
            // SQL query to get all animals from the database
            $sql = "SELECT * FROM animals";
            $stmt = $this->conn->query($sql);

            // Get the results of the query
            while ($row = $stmt->fetch()) {
                $animal = new Animal(
                    $row['id'],
                    $row['name'],
                    $row['race'],
                    $row['image'],
                    $row['habitat_id'], // Utiliser habitat_id à la place de habitat
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

    // Get an animal by its ID
    public function getById($id) {
        try {
            // SQL query to get an animal by its ID
            $sql = "SELECT * FROM animals WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch();

            // Create and return an Animal object
            return new Animal(
                $row['id'],
                $row['name'],
                $row['race'],
                $row['image'],
                $row['habitat_id'], // Utiliser habitat_id à la place de habitat
                $row['animal_status'],
                $this->conn
            );
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Add an animal
    public function add($name, $race, $image, $habitat, $animalStatus) {
        try {
            // Create a new animal
            $animal = new Animal(null, $name, $race, $image, $habitat, $animalStatus, $this->conn);
            // Add the new animal to the database
            $animal->save();

            // Redirect to the /animals route
            header("Location: /animals");
            exit();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Update an animal
    public function update($id, $name, $race, $image, $habitat, $animalStatus) {
        try {
            // Get the animal to update
            $animal = $this->getById($id);
            $animal->setName($name);
            $animal->setRace($race);
            $animal->setImage($image);
            $animal->setHabitat($habitat);
            $animal->setAnimalStatus($animalStatus);

            // Update the animal in the database
            $animal->update();

            // Redirect to the /animals route
            header("Location: /animals");
            exit();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Delete an animal
    public function delete($id) {
        try {
            // Get the ID of the animal to delete from the array
            $id = $id['id'];
            
            // Get the animal by its ID
            $animal = $this->getById($id);

            // Delete the animal
            $animal->delete();

            // Redirect to the /animals route
            header("Location: /animals");
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
}