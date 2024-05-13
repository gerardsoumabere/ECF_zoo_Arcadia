<?php
// Include the database configuration file
require_once __DIR__.'/../dbconnect.php'; 
// Include FoodReportController
require_once __DIR__.'/../controllers/FoodReportController.php';

use Controllers\FoodReportController;

// Create an instance of FoodReportController
$foodReportController = new FoodReportController($conn);

// Get food reports from the database
$foodReports = $foodReportController->index();

?>

<div class="container">

    <h1>Liste des rapports alimentaires</h1>

    <?php if (!empty($foodReports)): ?>
    <?php foreach ($foodReports as $foodReport): ?>
    <div class="food-report">
        <h2>ID : <?php echo $foodReport->getFoodReportId(); ?></h2>
        <!-- Afficher l'ID -->
        <p>Animal nourri : <?php echo $foodReport->getAnimalFed(); ?></p>
        <p>Type de nourriture : <?php echo $foodReport->getFoodType(); ?></p>
        <p>Date d'alimentation : <?php echo $foodReport->getFeedingTime(); ?>
        </p>
        <!-- Add links for editing and deleting -->
        <a
            href="/food_reports/edit?id=<?php echo $foodReport->getFoodReportId(); ?>">Modifier</a>
        <a
            href="/food_reports/delete?id=<?php echo $foodReport->getFoodReportId(); ?>">Supprimer</a>
    </div>
    <?php endforeach; ?>
    <?php else: ?>
    <p>Aucun rapport alimentaire trouvé.</p>
    <?php endif; ?>

    <!-- Button "Ajouter un rapport alimentaire" -->
    <a href="/food_reports/add" class="btn btn-primary">Ajouter un rapport
        alimentaire</a>

</div>