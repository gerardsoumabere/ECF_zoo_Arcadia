<?php
// Include the database configuration file
require_once __DIR__.'/../dbconnect.php'; 
// Include ServiceController
require_once __DIR__.'/../controllers/ServiceController.php';

use Controllers\ServiceController;

// Create an instance of ServiceController
$serviceController = new ServiceController($conn);

// Call the index method to get the services
$services = $serviceController->index();

?>

<div class="container">

    <h1>Liste des services</h1>

    <?php foreach ($services as $service): ?>
    <div class="service">
        <h2>ID : <?php echo $service->getId(); ?></h2> <!-- Afficher l'ID -->
        <h3><?php echo $service->getTitle(); ?></h3>
        <img src="<?php echo $service->getImage(); ?>"
            alt="<?php echo $service->getTitle(); ?>">
        <p><?php echo $service->getDescription(); ?></p>
        <!-- Ajoutez les liens pour la mise à jour et la suppression -->
        <a
            href="/services/edit?id=<?php echo $service->getId(); ?>">Modifier</a>
        <a
            href="/services/delete?id=<?php echo $service->getId(); ?>">Supprimer</a>
    </div>
    <?php endforeach; ?>

    <!-- Bouton "Ajouter un service" -->
    <a href="/services/add" class="btn btn-primary">Ajouter un service</a>

</div>