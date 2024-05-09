<?php
require_once __DIR__ . '/../controllers/HabitatController.php';

// Instancier HabitatController
$habitatController = new Controllers\HabitatController($conn);

// Récupérer l'ID de l'habitat à supprimer depuis l'URL
$id = $_GET['id'] ?? null;
// Extraire l'ID de $id
$id = is_array($id) && isset($id['id']) ? $id['id'] : $id;

// Vérifier si l'ID est défini
if ($id) {
    // Récupérer l'habitat par son ID
    $habitat = $habitatController->getById($id);
    ?>

<div class="container">
    <h2>Supprimer l'habitat</h2>
    <div class="row">
        <div class="col-md-6">
            <h3><?php echo $habitat->getName(); ?></h3>
            <p><?php echo $habitat->getDescription(); ?></p>
            <img src="<?php echo $habitat->getImages(); ?>"
                alt="<?php echo $habitat->getName(); ?>">
            <form action="/habitats/delete/process" method="post">
                <input type="hidden" name="id"
                    value="<?php echo $habitat->getId(); ?>">
                <button type="submit" class="btn btn-danger">Confirmer la
                    suppression</button>
            </form>
        </div>
    </div>
</div>

<?php
} else {
    // Si l'ID n'est pas défini, afficher un message d'erreur
    echo "ID de l'habitat non spécifié.";
}
?>