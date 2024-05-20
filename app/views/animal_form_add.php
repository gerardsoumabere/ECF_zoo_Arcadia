<?php

// Include the database configuration file
require_once __DIR__.'/../dbconnect.php'; 
// Include AnimalController
require_once __DIR__.'/../controllers/AnimalController.php';

use Controllers\AnimalController;

// Create an instance of AnimalController
$animalController = new AnimalController($conn);

// Chemin du répertoire de destination des images
$target_dir = $_SERVER['DOCUMENT_ROOT'] . "/public/assets/gallery/";

// Si un fichier est soumis, le télécharge
if(isset($_POST["submitImage"])) {
    if(isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == 0) {
        $extension = pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION);
        $date = date("YmdHis");
        $random = uniqid();
        $newfilename = $date . "-" . $random . "." . $extension;
        $target_file = $target_dir . $newfilename;
        $newfileurl = "/assets/gallery/" . $newfilename;
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
        $_SESSION['newfileurl'] = $newfileurl; // Stocker le chemin de l'image dans la session
        
        echo "<br>Le fichier $newfilename a été téléchargé.";
    }
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitAnimal"])) {
    $name = $_POST["name"];
    $race = $_POST["race"];
    $habitat = $_POST["habitat"];
    $image = "/public" . $_SESSION['newfileurl']; // Utiliser le chemin de l'image de la session
    $animal_detail = $_POST["animal_detail"];
    
    // Appeler la méthode pour ajouter un animal
    $animalController->add($name, $race, $image, $habitat, $animal_detail);
}
?>

<div class="container">
    <h2>Ajouter un animal</h2>
    <div class="row">
        <div class="col-md-6">
            <form action="/animals/add" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Nom de
                        l'animal:</label>
                    <input type="text" class="form-control" id="name"
                        name="name" value="Lion">
                </div>
                <div class="mb-3">
                    <label for="race" class="form-label">Race de
                        l'animal:</label>
                    <input type="text" class="form-control" id="race"
                        name="race" value="Lion d'Afrique">
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Image:</label>
                    <input type="text" class="form-control" id="image"
                        name="image"
                        value="<?php echo isset($_SESSION['newfileurl']) ? "/public" .$_SESSION['newfileurl'] : ""; ?>"
                        readonly>
                    <?php if(isset($_SESSION['newfileurl'])) { ?>
                    <img src="<?php echo "/public".$_SESSION['newfileurl']; ?>"
                        class="img-fluid" alt="Image téléchargée">
                    <?php } ?>
                </div>
                <div class="mb-3">
                    <label for="habitat" class="form-label">Habitat:</label>
                    <select class="form-select" id="habitat" name="habitat">
                        <option value="1">Savane</option>
                        <option value="2">Jungle</option>
                        <option value="3">Marais</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="animal_detail" class="form-label">Détail de
                        l'animal:</label>
                    <textarea class="form-control" id="animal_detail"
                        name="animal_detail">L'animal vit en groupe dans les savanes africaines. Il se nourrit principalement de viande.</textarea>
                </div>
                <button type="submit" class="btn btn-primary"
                    name="submitAnimal">Enregistrer</button>
            </form>
        </div>
    </div>
</div>

<div class="container mt-5">
    <form action="/animals/add/" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="fileToUpload">Sélectionnez une image à télécharger
                :</label>
            <input type="file" class="form-control-file" name="fileToUpload"
                id="fileToUpload" onchange="previewImage(event);">
        </div>
        <div class="form-group">
            <img id="output" width="100" height="100" />
        </div>
        <button type="submit" class="btn btn-primary"
            name="submitImage">Télécharger l'image</button>
    </form>
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