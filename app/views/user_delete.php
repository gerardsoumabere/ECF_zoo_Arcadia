<?php
require_once __DIR__ . '/../controllers/UserController.php'; // inclure le fichier UserController.php

// Créer une instance de UserController
$userController = new \Controllers\UserController($conn);

// Récupérer l'ID de l'utilisateur à supprimer depuis l'URL
$id = $_GET['id'] ?? null;

// Vérifier si l'ID est défini
if ($id) {
    // Récupérer l'utilisateur par son ID
    $user = $userController->getById($id);
    ?>

<div class="container">
    <h2>Supprimer l'utilisateur</h2>
    <div class="row">
        <div class="col-md-6">
            <h3><?php echo $user->getFirstName() . ' ' . $user->getLastName(); ?>
            </h3>
            <p>Email: <?php echo $user->getId(); ?></p>
            <form action="/users/delete/process" method="post">
                <input type="hidden" name="id"
                    value="<?php echo $user->getId(); ?>">
                <button type="submit" class="btn btn-danger">Confirmer la
                    suppression</button>
            </form>
        </div>
    </div>
</div>

<?php
} else {
    // Si l'ID n'est pas défini, afficher un message d'erreur
    echo "ID de l'utilisateur non spécifié.";
}
?>