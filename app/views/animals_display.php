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

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Image</th>
                <th>Race</th>
                <th>Habitat</th>
                <th>État</th>
                <?php if (isset($_SESSION['user']) || $_SESSION['user'] == 'administrateur'): ?>
                <th>Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($animals as $animal): ?>
            <tr>
                <td><?php echo $animal->getId(); ?></td>
                <td><?php echo $animal->getName(); ?></td>
                <td><img src="<?php echo $animal->getImage(); ?>"
                        alt="<?php echo $animal->getName(); ?>"
                        style="width: 100px; height: auto;"></td>
                <td><?php echo $animal->getRace(); ?></td>
                <td><?php echo $animalController->getHabitatName($animal->getHabitatId()); ?>
                </td>
                <td><?php echo $animal->getAnimalStatus(); ?></td>
                <?php if (isset($_SESSION['user']) || $_SESSION['user'] == 'administrateur'): ?>
                <td>
                    <a href="/animals/edit?id=<?php echo $animal->getId(); ?>"
                        class="btn btn-warning">Modifier</a>
                    <a href="/animals/delete?id=<?php echo $animal->getId(); ?>"
                        class="btn btn-danger">Supprimer</a>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (isset($_SESSION['user']) || $_SESSION['user'] == 'administrateur'): ?>
    <a href="/animals/add" class="btn btn-primary">Ajouter un animal</a>
    <?php endif; ?>

</div>