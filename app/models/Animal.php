<?php

namespace Models;

class Animal {
    private $id;
    private $name;
    private $race;
    private $image;
    private $habitatId;
    private $animalStatus;
    private $conn;

    // Constructor
    public function __construct($id, $name, $race, $image, $habitatId, $animalStatus, $conn) {
        $this->id = $id;
        $this->name = $name;
        $this->race = $race;
        $this->image = $image;
        $this->habitatId = $habitatId;
        $this->animalStatus = $animalStatus;
        $this->conn = $conn;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getRace() {
        return $this->race;
    }

    public function getImage() {
        return $this->image;
    }

    public function getHabitatId() {
        return $this->habitatId;
    }

    public function getAnimalStatus() {
        return $this->animalStatus;
    }

    // Setters
    public function setName($name) {
        $this->name = $name;
    }

    public function setRace($race) {
        $this->race = $race;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function setHabitatId($habitatId) {
        $this->habitatId = $habitatId;
    }

    public function setAnimalStatus($animalStatus) {
        $this->animalStatus = $animalStatus;
    }

        // Method to save an animal to the database
    public function save() {
        try {
            $sql = "INSERT INTO animals (name, race, image, habitat_id, animal_status) VALUES (:name, :race, :image, :habitatId, :animalStatus)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':race', $this->race);
            $stmt->bindParam(':image', $this->image);
            $stmt->bindParam(':habitatId', $this->habitatId);
            $stmt->bindParam(':animalStatus', $this->animalStatus);
            $stmt->execute();
        } catch (\PDOException $e) {
            // Handle database errors
            throw new \Exception("Error saving animal: " . $e->getMessage());
        }
    }

    // Method to update an animal in the database
    public function update() {
        try {
            $sql = "UPDATE animals SET name = :name, race = :race, image = :image, habitat_id = :habitatId, animal_status = :animalStatus WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':race', $this->race);
            $stmt->bindParam(':image', $this->image);
            $stmt->bindParam(':habitatId', $this->habitatId);
            $stmt->bindParam(':animalStatus', $this->animalStatus);
            $stmt->execute();
        } catch (\PDOException $e) {
            // Handle database errors
            throw new \Exception("Error updating animal: " . $e->getMessage());
        }
    }

    // Method to delete an animal from the database
    public function delete()
    {
        try {
            $sql = "DELETE FROM animals WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        } catch (\PDOException $e) {
            // Handle database errors
            throw new \Exception("Error deleting animal: " . $e->getMessage());
        }
    }
    
    // Method to get the habitat name associated with the animal
    public function getHabitatName()
    {
        try {
            $sql = "SELECT name FROM habitats WHERE id = :habitatId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':habitatId', $this->habitatId);
            $stmt->execute();
            $row = $stmt->fetch();

            return $row['name'];
        } catch (\PDOException $e) {
            // Handle database errors
            throw new \Exception("Error fetching habitat name: " . $e->getMessage());
        }

    }
}