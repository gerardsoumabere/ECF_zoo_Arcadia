<?php
// Include the database configuration file
require_once __DIR__.'/../dbconnect.php'; 
// Include HabitatController
require_once __DIR__.'/../controllers/HabitatController.php';

use Controllers\HabitatController;

// Create an instance of HabitatController
$habitatController = new HabitatController($conn);

// Vérifier si les habitats existent déjà dans la base de données
$habitats = $habitatController->index();

//************************** TODO : A supprimer une fois les formulaires intégrés ************************************************************************ */
// Si aucun habitat n'existe, alors les ajouter
if (empty($habitats)) {
    // Initialiser les données des habitats
   // SQL statement to insert habitats
$sql = "INSERT INTO habitats (name, images, description, animal_list, habitat_comment) VALUES 
        ('Savane', 'https://via.placeholder.com/400', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vitae enim ac massa lobortis sagittis.', 'Lion, Éléphant, Zèbre', 'Cet environnement est caractérisé par de vastes plaines herbeuses et un climat sec.'),
        ('Jungle', 'https://via.placeholder.com/400', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vitae enim ac massa lobortis sagittis.', 'Tigre, Singe, Perroquet', 'Cet environnement est dense et humide, avec une grande diversité de plantes et d\'animaux.'),
        ('Marais', 'https://via.placeholder.com/400', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vitae enim ac massa lobortis sagittis.', 'Crocodile, Grenouille, Héron', 'Cet environnement est caractérisé par des sols humides et des végétations aquatiques.')";

// Execute the SQL statement
$conn->exec($sql);

// Close the connection
$conn = null;
//************************** TODO : A supprimer une fois les formulaires intégrés ************************************************************************ */
    // Récupérer à nouveau la liste des habitats
    $habitats = $habitatController->index();
}
?>

<div class="container">

    <h1>Liste des habitats</h1>

    <?php if (!empty($habitats)): ?>
    <?php foreach ($habitats as $habitat): ?>
    <div class="habitat">
        <h2>ID : <?php echo $habitat->getId(); ?></h2> <!-- Afficher l'ID -->
        <h3><?php echo $habitat->getName(); ?></h3>
        <img src="<?php echo $habitat->getImages(); ?>"
            alt="<?php echo $habitat->getName(); ?>">
        <p><?php echo $habitat->getDescription(); ?></p>
        <p>Liste des animaux : <?php echo $habitat->getAnimalList(); ?></p>
        <p>Commentaire habitat : <?php echo $habitat->getHabitatComment(); ?>
        </p>
        <!-- Ajoutez les liens pour la mise à jour et la suppression -->
        <a
            href="/habitats/edit?id=<?php echo $habitat->getId(); ?>">Modifier</a>
        <a
            href="/habitats/delete?id=<?php echo $habitat->getId(); ?>">Supprimer</a>
    </div>
    <?php endforeach; ?>
    <?php else: ?>
    <p>Aucun habitat n'a été trouvé.</p>
    <?php endif; ?>

    <!-- Bouton "Ajouter un habitat" -->
    <a href="/habitats/add" class="btn btn-primary">Ajouter un habitat</a>

</div>