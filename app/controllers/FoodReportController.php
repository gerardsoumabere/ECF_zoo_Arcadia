<?php

namespace Controllers;

require_once __DIR__ . '/../models/FoodReport.php';

use Models\FoodReport;

class FoodReportController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Get all food reports
    public function index() {
        try {
            $foodReports = array();
            // SQL query to get all food reports from the database
            $sql = "SELECT * FROM food_reports";
            $stmt = $this->conn->query($sql);

            // Get the results of the query
            while ($row = $stmt->fetch()) {
                $foodReport = new FoodReport(
                    $row['foodreport_ID'],
                    $row['animal_fed'],
                    $row['food_type'],
                    $row['feeding_time'],
                    $row['feeding_date'], // Add feeding date
                    $this->conn
                );
                $foodReports[] = $foodReport;
            }

            // If no food reports found, return null
            if (empty($foodReports)) {
                return null;
            }

            return $foodReports; // Return the food reports
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Get a food report by its ID
    public function getById($id) {
        try {
            // SQL query to get a food report by its ID
            $sql = "SELECT * FROM food_reports WHERE foodreport_ID = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch();

            // If a food report is found, return a FoodReport object
            if ($row) {
                return new FoodReport(
                    $row['foodreport_ID'],
                    $row['animal_fed'],
                    $row['food_type'],
                    $row['feeding_time'],
                    $row['feeding_date'], // Add feeding date
                    $this->conn
                );
            } else {
                return null; // Return null if no food report found with the given ID
            }
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Add a food report
    public function add($animalFed, $foodType, $feedingTime, $feedingDate) {
        try {
            // Create a new food report
            $foodReport = new FoodReport(null, $animalFed, $foodType, $feedingTime, $feedingDate, $this->conn);
            // Add the new food report to the database
            $foodReport->save();

            // Redirect to the /food_reports route
            header("Location: /food_reports");
            exit();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Update a food report
    public function update($id, $animalFed, $foodType, $feedingTime, $feedingDate) {
        try {
            // Get the food report to update
            $foodReport = $this->getById($id);
            $foodReport->setAnimalFed($animalFed);
            $foodReport->setFoodType($foodType);
            $foodReport->setFeedingTime($feedingTime);
            $foodReport->setFeedingDate($feedingDate);

            // Update the food report in the database
            $foodReport->update();

            // Redirect to the /food_reports route
            header("Location: /food_reports");
            exit();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Delete a food report
    public function delete($id) {
        try {
            // Get the ID of the food report to delete from the array
            //$id = $id['id'];TODO Ici cela fonctionne contrairement aux controllers des autres classes

            // Get the food report by its ID
            $foodReport = $this->getById($id);

            // Delete the food report
            $foodReport->delete();

            // Redirect to the /food_reports route
            header("Location: /food_reports");
            exit();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Get all animals
    public function getAllAnimals() {
        try {
            $animals = array();
            // SQL query to get all animals from the database
            $sql = "SELECT id, name FROM animals";
            $stmt = $this->conn->query($sql);

            // Get the results of the query
            while ($row = $stmt->fetch()) {
                $animals[] = array(
                    'id' => $row['id'],
                    'name' => $row['name']
                );
            }

            return $animals; // Return the list of animals
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

}