<?php
require_once __DIR__ . '/../controllers/AnimalController.php';

// Instancier AnimalController
$animalController = new Controllers\AnimalController($conn);

// Récupérer l'ID de l'animal à supprimer depuis l'URL
$id = $_GET['id'] ?? null;
// Extraire l'ID de $id
$id = is_array($id) && isset($id['id']) ? $id['id'] : $id;

// Vérifier si l'ID est défini
if ($id) {
    // Récupérer l'animal par son ID
    $animal = $animalController->getById($id);
    ?>

<div class="container">
    <h2>Supprimer l'animal</h2>
    <div class="row">
        <div class="col-md-6">
            <h3><?php echo $animal->getName(); ?></h3>
            <p>Race: <?php echo $animal->getRace(); ?></p>
            <p>Habitat: <?php echo $animal->getHabitat(); ?></p>
            <p>Détail: <?php echo $animal->getAnimalStatus(); ?></p>
            <img src="<?php echo $animal->getImage(); ?>"
                alt="<?php echo $animal->getName(); ?>">
            <form action="/animals/delete/process" method="post">
                <input type="hidden" name="id"
                    value="<?php echo $animal->getId(); ?>">
                <button type="submit" class="btn btn-danger">Confirmer la
                    suppression</button>
            </form>
        </div>
    </div>
</div>

<?php
} else {
    // Si l'ID n'est pas défini, afficher un message d'erreur
    echo "ID de l'animal non spécifié.";
}
?>