<?php

if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'vétérinaire') {
    // Rediriger vers une page d'erreur ou une page d'accueil
    header("Location: /login?error=unauthorized");
    exit();
}

require_once __DIR__ . '/../controllers/VetReportController.php';

use Controllers\VetReportController;

$vetReportController = new VetReportController($conn);

$vetReport = null;
// If an ID is provided in the URL, get the details of the vet report
if(isset($_GET['id'])) {
$vetReport = $vetReportController->getById($_GET['id']);
}

// If the form is submitted, delete the vet report
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$id = $_POST["id"];

// Delete the vet report
$vetReportController->delete($id);

// Redirect to the vet reports list
header("Location: /vet_reports");
exit();
}
?>

<div class="container">
    <h2>Supprimer le rapport vétérinaire</h2>
    <div class="row">
        <div class="col-md-6">
            <h3>ID : <?php echo $vetReport->getId(); ?></h3>
            <p>ID de l'animal : <?php echo $vetReport->getAnimalId(); ?></p>
            <p>Date de passage : <?php echo $vetReport->getPassingDate(); ?></p>
            <p>Date de création : <?php echo $vetReport->getCreationDate(); ?>
            </p>
            <p>Detail : <?php echo $vetReport->getDetail(); ?></p>
            <form
                action="/vet_reports/delete?id=<?php echo $vetReport->getId(); ?>"
                method="post">
                <input type="hidden" name="id"
                    value="<?php echo $vetReport->getId(); ?>">
                <button type="submit" class="btn btn-danger">Confirmer la
                    suppression</button>
            </form>
        </div>
    </div>
</div>