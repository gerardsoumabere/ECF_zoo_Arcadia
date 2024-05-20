<?php

// Include the database configuration file
require_once __DIR__.'/../dbconnect.php'; 
// Include UserController
require_once __DIR__.'/../controllers/UserController.php';

use Controllers\UserController;

// Create an instance of UserController
$userController = new UserController($conn);

// Function to generate random password
function generateRandomPassword($length = 10) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $password = substr(str_shuffle($chars), 0, $length);
    return $password;
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitUser"])) {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    // Générer un mot de passe aléatoire
    $password = generateRandomPassword();
    // Récupérer le rôle depuis le formulaire
    $role = $_POST["role"];

    // Appeler la méthode pour ajouter un utilisateur
    $userController->add($firstName, $lastName, $email, $password, $role);

    // Afficher le mot de passe généré
    echo "<div class='alert alert-success' role='alert'>Mot de passe généré : <strong>$password</strong></div>";
}
?>

<div class="container">
    <h2>Ajouter un utilisateur</h2>
    <div class="row">
        <div class="col-md-6">
            <form action="/users/add" method="post">
                <div class="mb-3">
                    <label for="firstName" class="form-label">Prénom:</label>
                    <input type="text" class="form-control" id="firstName"
                        name="firstName" required>
                </div>
                <div class="mb-3">
                    <label for="lastName" class="form-label">Nom de
                        famille:</label>
                    <input type="text" class="form-control" id="lastName"
                        name="lastName" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email"
                        name="email" required>
                </div>
                <!-- Ajouter la sélection du rôle -->
                <div class="mb-3">
                    <label for="role" class="form-label">Rôle:</label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="employé">Employé</option>
                        <option value="vétérinaire">Vétérinaire</option>
                    </select>
                </div>
                <!-- Afficher le mot de passe généré -->
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de
                        passe généré:</label>
                    <input type="text" class="form-control" id="password"
                        name="password"
                        value="<?php echo generateRandomPassword(); ?>"
                        readonly>
                </div>
                <button type="submit" class="btn btn-primary"
                    name="submitUser">Enregistrer</button>
            </form>
        </div>
    </div>
</div>