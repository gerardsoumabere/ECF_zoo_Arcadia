<?php

// Include the database configuration file
require_once __DIR__.'/../dbconnect.php'; 
// Include ServiceController
require_once __DIR__.'/../controllers/ServiceController.php';

use Controllers\ServiceController;

// Create an instance of ServiceController
$serviceController = new ServiceController($conn);

// Call the index method to get the services
$services = $serviceController->index();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Call the add method of ServiceController to add the new service
    $serviceController->add();
}

?>


<div class="container">

    <h1>Liste des services</h1>

    <?php foreach ($services as $service): ?>
    <div class="service">
        <h2><?php echo $service->getTitle(); ?></h2>
        <img src="<?php echo $service->getImage(); ?>"
            alt="<?php echo $service->getTitle(); ?>">
        <p><?php echo $service->getDescription(); ?></p>
    </div>
    <?php endforeach; ?>

    <h2>Ajouter un nouveau service</h2>
    <div class="row">
        <div class="col-md-6">
            <form action="/services" method="post">
                <div class="mb-3">
                    <label for="title" class="form-label">Titre du
                        service:</label>
                    <input type="text" class="form-control" id="title"
                        name="title" value="Titre de test">
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image:</label>
                    <input type="text" class="form-control" id="image"
                        name="image" value="Contenu de test">
                </div>
                <div class="mb-3">
                    <label for="description"
                        class="form-label">Description:</label>
                    <textarea class="form-control" id="description"
                        name="description">Description de test</textarea>
                </div>
                <button type="submit"
                    class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
</div>