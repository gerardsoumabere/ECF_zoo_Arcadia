<?php
// Include the database configuration file
require_once __DIR__.'/../dbconnect.php'; 
// Include UserController
require_once __DIR__.'/../controllers/UserController.php';

use Controllers\UserController;

// Create an instance of UserController
$userController = new UserController($conn);

// Vérifier si les utilisateurs existent déjà dans la base de données
$users = $userController->index();

//************************** TODO : A supprimer une fois les formulaires intégrés ************************************************************************ */
// Si aucun utilisateur n'existe, alors les ajouter
if (empty($users)) {
    // Initialiser les données des utilisateurs
    // SQL statement to insert users
    $sql = "INSERT INTO users (first_name, last_name, email, password, role) VALUES 
            ('John', 'Doe', 'john.doe@example.com', 'password123', 'employé'),
            ('Jane', 'Doe', 'jane.doe@example.com', 'password456', 'vétérinaire')";

    // Execute the SQL statement
    $conn->exec($sql);

    // Close the connection
    $conn = null;

    // Récupérer à nouveau la liste des utilisateurs
    $users = $userController->index();
}
?>

<div class="container">

    <h1>Liste des utilisateurs</h1>

    <?php if (!empty($users)): ?>
    <?php foreach ($users as $user): ?>
    <div class="user">
        <h2>ID : <?php echo $user->getId(); ?></h2> <!-- Afficher l'ID -->
        <h3><?php echo $user->user(); ?></h3>
        <p>Email : <?php echo $user->getEmail(); ?></p>
        <!-- Afficher le rôle de l'utilisateur -->
        <p>Rôle : <?php echo $user->getRole(); ?></p>
        <!-- Ajoutez les liens pour la mise à jour et la suppression -->
        <a href="/users/edit?id=<?php echo $user->getId(); ?>">Modifier</a>
        <a href="/users/delete?id=<?php echo $user->getId(); ?>">Supprimer</a>
    </div>
    <?php endforeach; ?>
    <?php else: ?>
    <p>Aucun utilisateur n'a été trouvé.</p>
    <?php endif; ?>

    <!-- Bouton "Ajouter un utilisateur" -->
    <a href="/users/add" class="btn btn-primary">Ajouter un utilisateur</a>

</div>