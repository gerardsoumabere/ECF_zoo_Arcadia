<?php
require_once __DIR__.'/../controllers/UserController.php';
use Controllers\UserController;

$userController = new UserController($conn);

$user = null;
// Si un ID est fourni dans l'URL, récupérer les détails de l'utilisateur
if(isset($_GET['id'])) {
    $user = $userController->getById($_GET['id']);
}

// Si le formulaire est soumis, mettre à jour l'utilisateur
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitUser"])) {
    $id = $_POST["id"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role = $_POST["role"];

    // Mettre à jour l'utilisateur
    $userController->update($id, $firstName, $lastName, $email, $password, $role);
}
?>
<div class="container">
    <h2>Modifier l'utilisateur <?php echo $user->user(); ?></h2>
    <div class="row">
        <div class="col-md-6">
            <form action="/users/edit?id=<?php echo $user->getId(); ?>"
                method="post">
                <input type="hidden" name="id"
                    value="<?php echo $user->getId(); ?>">
                <div class="mb-3">
                    <label for="firstName" class="form-label">Prénom:</label>
                    <input type="text" class="form-control" id="firstName"
                        name="firstName"
                        value="<?php echo $user->getFirstName(); ?>">
                </div>
                <div class="mb-3">
                    <label for="lastName" class="form-label">Nom de
                        famille:</label>
                    <input type="text" class="form-control" id="lastName"
                        name="lastName"
                        value="<?php echo $user->getLastName(); ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email"
                        name="email" value="<?php echo $user->getEmail(); ?>">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de
                        passe:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="password"
                            name="password"
                            value="<?php echo $user->getPassword(); ?>"
                            readonly>
                        <button type="button" class="btn btn-secondary"
                            id="generatePassword">Générer</button>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Rôle:</label>
                    <select name="role" id="role" class="form-select">
                        <option value="Employé"
                            <?php if($user->getRole() == 'Employé(e)') echo 'selected'; ?>>
                            Employé</option>
                        <option value="Vétérinaire"
                            <?php if($user->getRole() == 'Vétérinaire') echo 'selected'; ?>>
                            Vétérinaire</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary"
                    name="submitUser">Modifier</button>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('generatePassword').addEventListener('click',
    function() {
        var length = 10;
        var chars =
            "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        var password = "";
        for (var i = 0; i < length; i++) {
            password += chars.charAt(Math.floor(Math.random() * chars
                .length));
        }
        document.getElementById('password').value = password;
    });
</script>