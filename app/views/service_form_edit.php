<?php
require_once __DIR__.'/../controllers/ServiceController.php';
use Controllers\ServiceController;

$serviceController = new ServiceController($conn);

$service = null;
// Si un ID est fourni dans l'URL, récupérer les détails du service
if(isset($_GET['id'])) {
    $service = $serviceController->getById($_GET['id']);
}

// Si le formulaire est soumis, mettre à jour le service
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitService"])) {
    $id = $_POST["id"];
    $title = $_POST["title"];
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

    // Mettre à jour le service
    $serviceController->update($id, $title, $image, $description);
}
?>

<div class="container">
    <h2>Modifier le service <?php echo $service->getId(); ?></h2>
    <div class="row">
        <div class="col-md-6">
            <form action="/services/edit?id=<?php echo $service->getId(); ?>"
                method="post" enctype="multipart/form-data">
                <input type="hidden" name="id"
                    value="<?php echo $service->getId(); ?>">
                <input type="hidden" name="oldImage"
                    value="<?php echo $service->getImage(); ?>">
                <div class="mb-3">
                    <label for="title" class="form-label">Titre du
                        service:</label>
                    <input type="text" class="form-control" id="title"
                        name="title"
                        value="<?php echo $service->getTitle(); ?>">
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image:</label><br>
                    <?php if($service->getImage() != ''): ?>
                    <img src="<?php echo $service->getImage(); ?>"
                        class="img-fluid" alt="Image actuelle"><br>
                    <?php else: ?>
                    Aucune image attribuée<br>
                    <?php endif; ?>
                    <input type="text" class="form-control" id="image"
                        name="image"
                        value="<?php echo $service->getImage() != '' ? $service->getImage() : 'Aucune image attribuée'; ?>"
                        readonly>
                </div>
                <div class="mb-3">
                    <label for="description"
                        class="form-label">Description:</label>
                    <textarea class="form-control" id="description"
                        name="description"><?php echo $service->getDescription(); ?></textarea>
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
                    name="submitService">Modifier</button>
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