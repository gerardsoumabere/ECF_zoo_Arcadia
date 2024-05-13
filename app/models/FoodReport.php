<?php

namespace Models;

class FoodReport {
    private $foodreport_ID;
    private $animal_fed;
    private $food_type;
    private $feeding_time;
    private $conn;

    // Constructor
    public function __construct($foodreport_ID, $animal_fed, $food_type, $feeding_time, $conn) {
        $this->foodreport_ID = $foodreport_ID;
        $this->animal_fed = $animal_fed;
        $this->food_type = $food_type;
        $this->feeding_time = $feeding_time;
        $this->conn = $conn;
    }

    // Getters
    public function getFoodReportId() {
        return $this->foodreport_ID;
    }

    public function getAnimalFed() {
        return $this->animal_fed;
    }

    public function getFoodType() {
        return $this->food_type;
    }

    public function getFeedingTime() {
        return $this->feeding_time;
    }

    // Setters
    public function setAnimalFed($animal_fed) {
        $this->animal_fed = $animal_fed;
    }

    public function setFoodType($food_type) {
        $this->food_type = $food_type;
    }

    public function setFeedingTime($feeding_time) {
        $this->feeding_time = $feeding_time;
    }

    // Method to save a food report to the database
    public function save() {
        try {
            $sql = "INSERT INTO food_reports (animal_fed, food_type, feeding_time) 
                    VALUES (:animal_fed, :food_type, :feeding_time)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':animal_fed', $this->animal_fed);
            $stmt->bindParam(':food_type', $this->food_type);
            $stmt->bindParam(':feeding_time', $this->feeding_time);
            $stmt->execute();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Method to update a food report in the database
    public function update() {
        try {
            $sql = "UPDATE food_reports SET animal_fed = :animal_fed, 
                    food_type = :food_type, feeding_time = :feeding_time WHERE foodreport_ID = :foodreport_ID";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':animal_fed', $this->animal_fed);
            $stmt->bindParam(':food_type', $this->food_type);
            $stmt->bindParam(':feeding_time', $this->feeding_time);
            $stmt->bindParam(':foodreport_ID', $this->foodreport_ID);
            $stmt->execute();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Method to delete a food report from the database
    public function delete() {
        try {
            $sql = "DELETE FROM food_reports WHERE foodreport_ID = :foodreport_ID";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':foodreport_ID', $this->foodreport_ID);
            $stmt->execute();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }
}