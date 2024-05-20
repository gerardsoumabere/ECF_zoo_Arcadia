<?php

if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'vétérinaire') {
    // Rediriger vers une page d'erreur ou une page d'accueil
    header("Location: /login?error=unauthorized");
    exit();
}

require_once __DIR__.'/../controllers/VetReportController.php';

use Controllers\VetReportController;

$vetReportController = new VetReportController($conn);

$vetReport = null;
// If an ID is provided in the URL, get the details of the vet report
if(isset($_GET['id'])) {
$vetReport = $vetReportController->getById($_GET['id']);
}

// If the form is submitted, update the vet report
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitVetReport"])) {
$id = $_POST["id"];
$animalId = $_POST["animal_id"];
$passingDate = $_POST["passing_date"];
$creationDate = $_POST["creation_date"];
$detail = $_POST["detail"];

// Update the vet report
$vetReportController->update($id, $animalId, $passingDate, $creationDate,
$detail);
}
?>

<div class="container">
    <h2>Modifier le rapport vétérinaire <?php echo $vetReport->getId(); ?></h2>
    <div class="row">
        <div class="col-md-6">
            <form
                action="/vet_reports/edit?id=<?php echo $vetReport->getId(); ?>"
                method="post">
                <input type="hidden" name="id"
                    value="<?php echo $vetReport->getId(); ?>">
                <div class="mb-3">
                    <label for="animal_id" class="form-label">ID de
                        l'animal:</label>
                    <input type="text" class="form-control" id="animal_id"
                        name="animal_id"
                        value="<?php echo $vetReport->getAnimalId(); ?>">
                </div>
                <div class="mb-3">
                    <label for="passing_date" class="form-label">Date de
                        passage:</label>
                    <input type="date" class="form-control" id="passing_date"
                        name="passing_date"
                        value="<?php echo $vetReport->getPassingDate(); ?>">
                </div>
                <div class="mb-3">
                    <label for="creation_date" class="form-label">Date de
                        création:</label>
                    <input type="date" class="form-control" id="creation_date"
                        name="creation_date"
                        value="<?php echo $vetReport->getCreationDate(); ?>">
                </div>
                <div class="mb-3">
                    <label for="detail" class="form-label">Détail:</label>
                    <textarea class="form-control" id="detail"
                        name="detail"><?php echo $vetReport->getDetail(); ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary"
                    name="submitVetReport">Modifier</button>
            </form>
        </div>
    </div>
</div>