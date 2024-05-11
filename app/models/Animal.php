<?php

namespace Models;

class Animal {
    private $id;
    private $name;
    private $race;
    private $image;
    private $habitat;
    private $animalStatus;
    private $conn;

    // Constructor
    public function __construct($id, $name, $race, $image, $habitat, $animalStatus, $conn) {
        $this->id = $id;
        $this->name = $name;
        $this->race = $race;
        $this->image = $image;
        $this->habitat = $habitat;
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

    public function getHabitat() {
        return $this->habitat;
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

    public function setHabitat($habitat) {
        $this->habitat = $habitat;
    }

    public function setAnimalStatus($animalStatus) {
        $this->animalStatus = $animalStatus;
    }

    // Method to save an animal to the database
    public function save() {
        try {
            $sql = "INSERT INTO animals (name, race, image, habitat, animal_status) 
                    VALUES (:name, :race, :image, :habitat, :animal_status)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':race', $this->race);
            $stmt->bindParam(':image', $this->image);
            $stmt->bindParam(':habitat', $this->habitat);
            $stmt->bindParam(':animal_status', $this->animalStatus);
            $stmt->execute();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Method to update an animal in the database
    public function update() {
        try {
            $sql = "UPDATE animals SET name = :name, race = :race, image = :image, 
                    habitat = :habitat, animal_status = :animal_status WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':race', $this->race);
            $stmt->bindParam(':image', $this->image);
            $stmt->bindParam(':habitat', $this->habitat);
            $stmt->bindParam(':animal_status', $this->animalStatus);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Method to delete an animal from the database
    public function delete() {
        try {
            $sql = "DELETE FROM animals WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }
}