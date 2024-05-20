<?php

namespace Models;


use Controllers\AnimalController;

class Habitat {
    private $id;
    private $name;
    private $images;
    private $description;
    private $animals; // 
    private $habitatComment;
    private $conn;

    public function __construct($id, $name, $images, $description, $animals, $habitatComment, $conn) {
        $this->id = $id;
        $this->name = $name;
        $this->images = $images;
        $this->description = $description;
        $this->animals = $animals; 
        $this->habitatComment = $habitatComment;
        $this->conn = $conn;
    }

    // Getters and Setters

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getImages() {
        return $this->images;
    }

    public function getDescription() {
        return $this->description;
    }

    // Getter for animals
    public function getAnimals() {
        return $this->animals;
    }

    public function getHabitatComment() {
        return $this->habitatComment;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setImages($images) {
        $this->images = $images;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setAnimals($animals) {
        $this->animals = $animals;
    }

    public function setHabitatComment($habitatComment) {
        $this->habitatComment = $habitatComment;
    }

    // Database operations

    public function save() {
        try {
            $sql = "INSERT INTO habitats (name, images, description, habitat_comment) 
                    VALUES (:name, :images, :description, :habitat_comment)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':images', $this->images);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':habitat_comment', $this->habitatComment);
            $stmt->execute();
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function update() {
        try {
            $sql = "UPDATE habitats SET name = :name, images = :images, description = :description, 
                    habitat_comment = :habitat_comment WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':images', $this->images);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':habitat_comment', $this->habitatComment);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function delete() {
        try {
            $sql = "DELETE FROM habitats WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Custom methods

    public function getImage() {
        return $this->images;
    }

    // Method to get animals by habitat
    public function getAnimalsByHabitat() {
        try {
            $animalController = new AnimalController($this->conn);
            return $animalController->getAnimalsByHabitat($this->id);
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}