<?php
// Start session
session_start();

// Include HabitatController
require_once __DIR__.'/../controllers/HabitatController.php';

use Controllers\HabitatController;

$habitatController = new HabitatController($conn);

$habitat = null;
// Si un ID est fourni dans l'URL, récupérer les détails de l'habitat
if(isset($_GET['id'])) {
    $habitat = $habitatController->getById($_GET['id']);
}

// Si le formulaire est soumis, mettre à jour l'habitat
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitHabitat"])) {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $description = $_POST["description"];

    // Vérifier si une nouvelle image a été téléchargée
    if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $date = date("YmdHis");
        $random = uniqid();
        $newfilename = $date . "-" . $random . "." . $extension;
        $target_file = $_SERVER['DOCUMENT_ROOT'] . "/public/assets/gallery/" . $newfilename;
        $newfileurl = "/assets/gallery/" . $newfilename;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $image = "/public" . $newfileurl;
    } else {
        // Si aucune nouvelle image n'a été téléchargée, utiliser l'image existante
        $image = $_POST["oldImage"];
    }

    $habitatComment = $_POST["habitat_comment"];

    // Mettre à jour l'habitat
    $habitatController->update($id, $name, $image, $description, $animalList, $habitatComment);

}
?>

<div class="container">
    <h2>Modifier l'habitat <?php echo $habitat->getId(); ?></h2>
    <div class="row">
        <div class="col-md-6">
            <form action="/habitats/edit?id=<?php echo $habitat->getId(); ?>"
                method="post" enctype="multipart/form-data">
                <input type="hidden" name="id"
                    value="<?php echo $habitat->getId(); ?>">
                <input type="hidden" name="oldImage"
                    value="<?php echo $habitat->getImages(); ?>">
                <div class="mb-3">
                    <label for="name" class="form-label">Nom de
                        l'habitat:</label>
                    <input type="text" class="form-control" id="name"
                        name="name" value="<?php echo $habitat->getName(); ?>">
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image:</label><br>
                    <?php if($habitat->getImages() != ''): ?>
                    <img src="<?php echo $habitat->getImages(); ?>"
                        class="img-fluid" alt="Image actuelle"><br>
                    <?php else: ?>
                    Aucune image attribuée<br>
                    <?php endif; ?>
                    <input type="text" class="form-control" id="image"
                        name="image"
                        value="<?php echo $habitat->getImages() != '' ? $habitat->getImages() : 'Aucune image attribuée'; ?>"
                        readonly>
                </div>
                <div class="mb-3">
                    <label for="description"
                        class="form-label">Description:</label>
                    <textarea class="form-control" id="description"
                        name="description"><?php echo $habitat->getDescription(); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="habitat_comment" class="form-label">Commentaire
                        habitat:</label>
                    <textarea class="form-control" id="habitat_comment"
                        name="habitat_comment"><?php echo $habitat->getHabitatComment(); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="fileToUpload">Sélectionnez une nouvelle image à
                        télécharger :</label>
                    <input type="file" class="form-control-file" name="image"
                        id="fileToUpload" onchange="previewImage(event);">
                </div>
                <div class="mb-3">
                    <img id="output" width="100" height="100" />
                </div>
                <button type="submit" class="btn btn-primary"
                    name="submitHabitat">Modifier</button>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('output');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>