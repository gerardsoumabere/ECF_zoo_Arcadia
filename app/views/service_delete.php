<?php
// Récupérer l'ID du service à supprimer depuis l'URL
$id = $_GET['id'] ?? null;

// Vérifier si l'ID est défini
if ($id) {
    // Récupérer le service par son ID
    $service = $serviceController->getById($id);
    ?>

<div class="container">
    <h2>Supprimer le service</h2>
    <div class="row">
        <div class="col-md-6">
            <h3><?php echo $service->getTitle(); ?></h3>
            <p><?php echo $service->getDescription(); ?></p>
            <img src="<?php echo $service->getImage(); ?>"
                alt="<?php echo $service->getTitle(); ?>">
            <form action="/services/delete/process" method="post">
                <input type="hidden" name="id"
                    value="<?php echo $service->getId(); ?>">
                <button type="submit" class="btn btn-danger">Confirmer la
                    suppression</button>
            </form>
        </div>
    </div>
</div>

<?php
} else {
    // Si l'ID n'est pas défini, afficher un message d'erreur
    echo "ID du service non spécifié.";
}
?>