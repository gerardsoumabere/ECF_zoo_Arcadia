<?php
// Start session
session_start();

// Include the database configuration file
require_once __DIR__.'/../dbconnect.php'; 
// Include VetReportController
require_once __DIR__.'/../controllers/VetReportController.php';

use Controllers\VetReportController;

// Create an instance of VetReportController
$vetReportController = new VetReportController($conn);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitVetReport"])) {
    $animalId = $_POST["animal_id"];
    $passingDate = $_POST["passing_date"];
    $creationDate = $_POST["creation_date"];
    $detail = $_POST["detail"];
    
    // Call the method to add a vet report
    $vetReportController->add($animalId, $passingDate, $creationDate, $detail);
}
?>

<div class="container">
    <h2>Ajouter un rapport vétérinaire</h2>
    <div class="row">
        <div class="col-md-6">
            <form action="/vet_reports/add" method="post">
                <div class="mb-3">
                    <label for="animal_id" class="form-label">ID de
                        l'animal:</label>
                    <input type="text" class="form-control" id="animal_id"
                        name="animal_id" value="1">
                </div>
                <div class="mb-3">
                    <label for="passing_date" class="form-label">Date de
                        passage:</label>
                    <input type="date" class="form-control" id="passing_date"
                        name="passing_date">
                </div>
                <div class="mb-3">
                    <label for="creation_date" class="form-label">Date de
                        création:</label>
                    <input type="date" class="form-control" id="creation_date"
                        name="creation_date"
                        value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="mb-3">
                    <label for="detail" class="form-label">Détail:</label>
                    <textarea class="form-control" id="detail"
                        name="detail"></textarea>
                </div>
                <button type="submit" class="btn btn-primary"
                    name="submitVetReport">Enregistrer</button>
            </form>
        </div>
    </div>
</div>