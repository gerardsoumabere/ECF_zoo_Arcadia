<?php

namespace Controllers;

require_once __DIR__ . '/../models/Habitat.php';

use Models\Habitat;

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
                $habitat = new Habitat(
                    $row['id'],
                    $row['name'],
                    $row['images'],
                    $row['description'],
                    $row['animal_list'],
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

            // Create and return a Habitat object
            return new Habitat(
                $row['id'],
                $row['name'],
                $row['images'],
                $row['description'],
                $row['animal_list'],
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
            $habitat->setAnimalList($animalList);
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
// Supprimer un habitat
public function delete($id) {
    try {
        // Récupérer l'ID de l'habitat à supprimer depuis le tableau
        $id = $id['id'];
        
        // Récupérer l'habitat par son ID
        $habitat = $this->getById($id);

        // Supprimer l'habitat
        $habitat->delete();

        // Rediriger vers la route /habitats
        header("Location: /habitats");
        exit();

    } catch (\PDOException $e) {
        // Gérer les erreurs de base de données
        echo "Erreur : " . $e->getMessage();
    }
}
}