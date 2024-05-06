<?php
require_once __DIR__.'/../dbconnect.php'; 

require_once __DIR__.'/../controllers/ServiceController.php';
use Controllers\ServiceController;

$serviceController = new ServiceController($conn);

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $title = $_POST["title"];
    $image = $_POST["image"];
    $description = $_POST["description"];

    // Appeler la méthode pour ajouter un service
    $serviceController->add($title, $image, $description);
}

?>

<div class="container">
    <h2>Ajouter un service</h2>
    <div class="row">
        <div class="col-md-6">
            <form action="/services/add/process" method="post">
                <div class="mb-3">
                    <label for="title" class="form-label">Titre du
                        service:</label>
                    <input type="text" class="form-control" id="title"
                        name="title">
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image:</label>
                    <input type="text" class="form-control" id="image"
                        name="image">
                </div>
                <div class="mb-3">
                    <label for="description"
                        class="form-label">Description:</label>
                    <textarea class="form-control" id="description"
                        name="description"></textarea>
                </div>
                <button type="submit"
                    class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
</div>