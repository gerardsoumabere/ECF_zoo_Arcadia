<?php

if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'vétérinaire') {
    // Rediriger vers une page d'erreur ou une page d'accueil
    header("Location: /login?error=unauthorized");
    exit();
}

// Include the database configuration file
require_once __DIR__.'/../dbconnect.php'; 
// Include VetReportController
require_once __DIR__.'/../controllers/VetReportController.php';

use Controllers\VetReportController;

// Create an instance of VetReportController
$vetReportController = new VetReportController($conn);

// Get vet reports from the database
$vetReports = $vetReportController->index();

?>

<div class="container">

    <h1>Liste des rapports vétérinaires</h1>

    <?php if (!empty($vetReports)): ?>
    <?php foreach ($vetReports as $vetReport): ?>
    <div class="vet-report">
        <h2>ID : <?php echo $vetReport->getId(); ?></h2> <!-- Afficher l'ID -->
        <p>Animal ID : <?php echo $vetReport->getAnimalId(); ?></p>
        <p>Date de passage : <?php echo $vetReport->getPassingDate(); ?></p>
        <p>Date de création : <?php echo $vetReport->getCreationDate(); ?></p>
        <p>Detail : <?php echo $vetReport->getDetail(); ?></p>
        <!-- Add links for editing and deleting -->
        <a
            href="/vet_reports/edit?id=<?php echo $vetReport->getId(); ?>">Modifier</a>
        <a
            href="/vet_reports/delete?id=<?php echo $vetReport->getId(); ?>">Supprimer</a>
    </div>
    <?php endforeach; ?>
    <?php else: ?>
    <p>Aucun rapport vétérinaire trouvé.</p>
    <?php endif; ?>

    <!-- Button "Ajouter un rapport vétérinaire" -->
    <a href="/vet_reports/add" class="btn btn-primary">Ajouter un rapport
        vétérinaire</a>

</div>