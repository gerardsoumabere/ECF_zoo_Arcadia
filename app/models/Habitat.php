<?php

namespace Models;

class Habitat {
    private $id;
    private $name;
    private $images;
    private $description;
    private $animalList;
    private $habitatComment;
    private $conn;

    // Constructor
    public function __construct($id, $name, $images, $description, $animalList, $habitatComment, $conn) {
        $this->id = $id;
        $this->name = $name;
        $this->images = $images;
        $this->description = $description;
        $this->animalList = $animalList;
        $this->habitatComment = $habitatComment;
        $this->conn = $conn;
    }

    // Getters
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

    public function getAnimalList() {
        return $this->animalList;
    }

    public function getHabitatComment() {
        return $this->habitatComment;
    }

    // Setters
    public function setName($name) {
        $this->name = $name;
    }

    public function setImages($images) {
        $this->images = $images;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setAnimalList($animalList) {
        $this->animalList = $animalList;
    }

    public function setHabitatComment($habitatComment) {
        $this->habitatComment = $habitatComment;
    }

    // Method to save a habitat to the database
    public function save() {
        try {
            $sql = "INSERT INTO habitats (name, images, description, animal_list, habitat_comment) 
                    VALUES (:name, :images, :description, :animal_list, :habitat_comment)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':images', $this->images);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':animal_list', $this->animalList);
            $stmt->bindParam(':habitat_comment', $this->habitatComment);
            $stmt->execute();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Method to update a habitat in the database
    public function update() {
        try {
            $sql = "UPDATE habitats SET name = :name, images = :images, description = :description, 
                    animal_list = :animal_list, habitat_comment = :habitat_comment WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':images', $this->images);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':animal_list', $this->animalList);
            $stmt->bindParam(':habitat_comment', $this->habitatComment);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Method to delete a habitat from the database
    public function delete() {
        try {
            $sql = "DELETE FROM habitats WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }
}