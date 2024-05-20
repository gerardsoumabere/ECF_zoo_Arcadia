<?php

// Include AnimalController
require_once __DIR__.'/../controllers/AnimalController.php';

use Controllers\AnimalController;

$animalController = new AnimalController($conn);

$animal = null;
// Si un ID est fourni dans l'URL, récupérer les détails de l'animal
if(isset($_GET['id'])) {
    $animal = $animalController->getById($_GET['id']);
}

// Vérifier si l'animal est défini
if($animal) {
    // Si le formulaire est soumis, mettre à jour l'animal
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitAnimal"])) {
        $id = $_POST["id"];
        $name = $_POST["name"];
        $race = $_POST["race"];

        // Vérifier si une nouvelle image a été téléchargée
        if(isset($_FILES["images"]) && $_FILES["images"]["error"] == 0) {
            $extension = pathinfo($_FILES["images"]["name"], PATHINFO_EXTENSION);
            $date = date("YmdHis");
            $random = uniqid();
            $newfilename = $date . "-" . $random . "." . $extension;
            $target_file = $_SERVER['DOCUMENT_ROOT'] . "/public/assets/gallery/" . $newfilename;
            $newfileurl = "/assets/gallery/" . $newfilename;
            move_uploaded_file($_FILES["images"]["tmp_name"], $target_file);
            $images = "/public" . $newfileurl;
        } else {
            // Si aucune nouvelle image a été téléchargée, utiliser l'image existante
            $images = $_POST["oldImages"];
        }

        $habitat = $_POST["habitat"];
        $animalDetail = $_POST["animal_detail"];

        // Mettre à jour l'animal
        $animalController->update($id, $name, $race, $images, $habitat, $animalDetail);
    }
} else {
    // Rediriger avec un message d'erreur si aucun animal n'est trouvé
    header("Location: /animals");
    exit();
}
?>

<div class="container">
    <h2>Modifier l'animal <?php echo $animal->getId(); ?></h2>
    <div class="row">
        <div class="col-md-6">
            <form action="/animals/edit?id=<?php echo $animal->getId(); ?>"
                method="post" enctype="multipart/form-data">
                <input type="hidden" name="id"
                    value="<?php echo $animal->getId(); ?>">
                <input type="hidden" name="oldImages"
                    value="<?php echo $animal->getImage(); ?>">
                <div class="mb-3">
                    <label for="name" class="form-label">Nom de
                        l'animal:</label>
                    <input type="text" class="form-control" id="name"
                        name="name" value="<?php echo $animal->getName(); ?>">
                </div>
                <div class="mb-3">
                    <label for="race" class="form-label">Race de
                        l'animal:</label>
                    <input type="text" class="form-control" id="race"
                        name="race" value="<?php echo $animal->getRace(); ?>">
                </div>
                <div class="mb-3">
                    <label for="images" class="form-label">Image:</label><br>
                    <?php if($animal->getImage() != ''): ?>
                    <img src="<?php echo $animal->getImage(); ?>"
                        class="img-fluid" alt="Image actuelle"><br>
                    <?php else: ?>
                    Aucune image attribuée<br>
                    <?php endif; ?>
                    <input type="text" class="form-control" id="images"
                        name="images"
                        value="<?php echo $animal->getImage() != '' ? $animal->getImage() : 'Aucune image attribuée'; ?>"
                        readonly>
                </div>
                <div class="mb-3">
                    <label for="habitat" class="form-label">Habitat:</label>
                    <select class="form-select" id="habitat" name="habitat">
                        <option value="1"
                            <?php echo $animal->getHabitatId() == 1 ? 'selected' : ''; ?>>
                            Savane</option>
                        <option value="2"
                            <?php echo $animal->getHabitatId() == 2 ? 'selected' : ''; ?>>
                            Jungle</option>
                        <option value="3"
                            <?php echo $animal->getHabitatId() == 3 ? 'selected' : ''; ?>>
                            Marais</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="animal_detail" class="form-label">Détail de
                        l'animal:</label>
                    <textarea class="form-control" id="animal_detail"
                        name="animal_detail"><?php echo $animal->getAnimalStatus(); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="fileToUpload">Sélectionnez une nouvelle image
                        à télécharger :</label>
                    <input type="file" class="form-control-file" name="images"
                        id="fileToUpload" onchange="previewImage(event);">
                </div>
                <div class="mb-3">
                    <img id="output" width="100" height="100" />
                </div>
                <button type="submit" class="btn btn-primary"
                    name="submitAnimal">Modifier</button>
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