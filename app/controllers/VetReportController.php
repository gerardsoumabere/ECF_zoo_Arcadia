<?php
namespace Controllers;

require_once __DIR__ . '/../models/VetReport.php';

use Models\VetReport;

class VetReportController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Get all vet reports
    public function index() {
        try {
            $vetReports = array();
            // SQL query to get all vet reports from the database
            $sql = "SELECT * FROM vet_reports";
            $stmt = $this->conn->query($sql);

            // Get the results of the query
            while ($row = $stmt->fetch()) {
                $vetReport = new VetReport(
                    $row['id'],
                    $row['animal_id'],
                    $row['passing_date'],
                    $row['creation_date'],
                    $row['detail'],
                    $this->conn
                );
                $vetReports[] = $vetReport;
            }

            // If no vet reports found, return null
            if (empty($vetReports)) {
                return null;
            }

            return $vetReports; // Return the vet reports
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Get a vet report by its ID
    public function getById($id) {
        try {
            // SQL query to get a vet report by its ID
            $sql = "SELECT * FROM vet_reports WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch();

            // If a vet report is found, return a VetReport object
            if ($row) {
                return new VetReport(
                    $row['id'],
                    $row['animal_id'],
                    $row['passing_date'],
                    $row['creation_date'],
                    $row['detail'],
                    $this->conn
                );
            } else {
                return null; // Return null if no vet report found with the given ID
            }
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Add a vet report
    public function add($animalId, $passingDate, $creationDate, $detail) {
        try {
            // Create a new vet report
            $vetReport = new VetReport(null, $animalId, $passingDate, $creationDate, $detail, $this->conn);
            // Add the new vet report to the database
            $vetReport->save();

            // Redirect to the /vet_reports route
            header("Location: /vet_reports");
            exit();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Update a vet report
    public function update($id, $animalId, $passingDate, $creationDate, $detail) {
        try {
            // Get the vet report to update
            $vetReport = $this->getById($id);
            $vetReport->setAnimalId($animalId);
            $vetReport->setPassingDate($passingDate);
            $vetReport->setCreationDate($creationDate);
            $vetReport->setDetail($detail);

            // Update the vet report in the database
            $vetReport->update();

            // Redirect to the /vet_reports route
            header("Location: /vet_reports");
            exit();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Delete a vet report
    public function delete($id) {
        try {
            // Get the ID of the vet report to delete from the array
            //$id = $id['id'];TODO Ici cela fonctionne contrairement aux controllers des autres classes

            // Get the vet report by its ID
            $vetReport = $this->getById($id);

            // Delete the vet report
            $vetReport->delete();

            // Redirect to the /vet_reports route
            header("Location: /vet_reports");
            exit();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }
}