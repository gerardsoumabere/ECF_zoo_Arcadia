<?php

namespace Models;

class VetReport {
    private $id;
    private $animalId;
    private $passingDate;
    private $creationDate;
    private $detail;
    private $conn;

    // Constructor
    public function __construct($id, $animalId, $passingDate, $creationDate, $detail, $conn) {
        $this->id = $id;
        $this->animalId = $animalId;
        $this->passingDate = $passingDate;
        $this->creationDate = $creationDate;
        $this->detail = $detail;
        $this->conn = $conn;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getAnimalId() {
        return $this->animalId;
    }

    public function getPassingDate() {
        return $this->passingDate;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function getDetail() {
        return $this->detail;
    }

    // Setters
    public function setAnimalId($animalId) {
        $this->animalId = $animalId;
    }

    public function setPassingDate($passingDate) {
        $this->passingDate = $passingDate;
    }

    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

    public function setDetail($detail) {
        $this->detail = $detail;
    }

    // Method to save a vet report to the database
    public function save() {
        try {
            $sql = "INSERT INTO vet_reports (animal_id, passing_date, creation_date, detail) 
                    VALUES (:animal_id, :passing_date, :creation_date, :detail)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':animal_id', $this->animalId);
            $stmt->bindParam(':passing_date', $this->passingDate);
            $stmt->bindParam(':creation_date', $this->creationDate);
            $stmt->bindParam(':detail', $this->detail);
            $stmt->execute();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Method to update a vet report in the database
    public function update() {
        try {
            $sql = "UPDATE vet_reports SET animal_id = :animal_id, passing_date = :passing_date, 
                    creation_date = :creation_date, detail = :detail WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':animal_id', $this->animalId);
            $stmt->bindParam(':passing_date', $this->passingDate);
            $stmt->bindParam(':creation_date', $this->creationDate);
            $stmt->bindParam(':detail', $this->detail);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Method to delete a vet report from the database
    public function delete() {
        try {
            $sql = "DELETE FROM vet_reports WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }
}