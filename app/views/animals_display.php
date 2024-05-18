<?php

// Include the database configuration file
require_once __DIR__.'/../dbconnect.php'; 

// Include AnimalController
require_once __DIR__.'/../controllers/AnimalController.php';

use Controllers\AnimalController;

// Create an instance of AnimalController
$animalController = new AnimalController($conn);

// Vérifier si des animaux existent déjà dans la base de données
$animals = $animalController->index();

?>

<div class="container">

    <h1>Liste des animaux</h1>

    <?php foreach ($animals as $animal): ?>
    <div class="animal">
        <h2>ID : <?php echo $animal->getId(); ?></h2> <!-- Afficher l'ID -->
        <h3><?php echo $animal->getName(); ?></h3>
        <img src="<?php echo $animal->getImage(); ?>"
            alt="<?php echo $animal->getName(); ?>">
        <p>Race : <?php echo $animal->getRace(); ?></p>
        <p>Habitat :
            <?php echo $animalController->getHabitatName($animal->getHabitat()); ?>
        </p>
        <p>État : <?php echo $animal->getAnimalStatus(); ?></p>
        <!-- Ajouter les liens pour la mise à jour et la suppression -->
        <a href="/animals/edit?id=<?php echo $animal->getId(); ?>">Modifier</a>
        <a
            href="/animals/delete?id=<?php echo $animal->getId(); ?>">Supprimer</a>
    </div>
    <?php endforeach; ?>

    <!-- Bouton "Ajouter un animal" -->
    <a href="/animals/add" class="btn btn-primary">Ajouter un animal</a>

</div>