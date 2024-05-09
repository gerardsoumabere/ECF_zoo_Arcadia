<?php
// Start session
session_start();

// Include the database configuration file
require_once __DIR__.'/../dbconnect.php'; 
// Include ServiceController
require_once __DIR__.'/../controllers/ServiceController.php';

use Controllers\ServiceController;

// Create an instance of ServiceController
$serviceController = new ServiceController($conn);

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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitService"])) {
    $title = $_POST["title"];
    $description = $_POST["description"];
    
    $image = "/public" . $_SESSION['newfileurl']; // Utiliser le chemin de l'image de la session
    
    // Appeler la méthode pour ajouter un service
    $serviceController->add($title, $image, $description);
}
?>

<div class="container">
    <h2>Ajouter un service</h2>
    <div class="row">
        <div class="col-md-6">
            <form action="/services/add" method="post">
                <div class="mb-3">
                    <label for="title" class="form-label">Titre du
                        service:</label>
                    <input type="text" class="form-control" id="title"
                        name="title" value="Titre de test">
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image:</label>
                    <input type="text" class="form-control" id="image"
                        name="image"
                        value="<?php echo isset($_SESSION['newfileurl']) ? "/public".$_SESSION['newfileurl'] : ""; ?>"
                        readonly>
                    <?php if(isset($_SESSION['newfileurl'])) { ?>
                    <img src="<?php echo "/public".$_SESSION['newfileurl']; ?>"
                        class="img-fluid" alt="Image téléchargée">
                    <?php } ?>
                </div>
                <div class="mb-3">
                    <label for="description"
                        class="form-label">Description:</label>
                    <textarea class="form-control" id="description"
                        name="description">Description de test</textarea>
                </div>
                <button type="submit" class="btn btn-primary"
                    name="submitService">Enregistrer</button>
            </form>
        </div>
    </div>
</div>

<div class="container mt-5">
    <form action="/services/add" method="post" enctype="multipart/form-data">
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