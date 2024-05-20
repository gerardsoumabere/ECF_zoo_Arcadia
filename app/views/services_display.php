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

?>

<div class="container">
    <h1>Liste des services</h1>
    <div class="row">
        <?php foreach ($services as $service): ?>
        <div class="col-md-4 mb-4">
            <div class="card" style="width: 18rem;">
                <img src="<?php echo $service->getImage(); ?>"
                    class="card-img-top"
                    alt="<?php echo $service->getTitle(); ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $service->getTitle(); ?>
                    </h5>
                    <p class="card-text">
                        <?php echo $service->getDescription(); ?></p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>