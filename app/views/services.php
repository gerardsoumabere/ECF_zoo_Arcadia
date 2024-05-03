<?php
// Include ServiceController
require_once __DIR__.'/../controllers/ServiceController.php';

use Controllers\ServiceController;

// Create an instance of ServiceController
$serviceController = new ServiceController();

// Call the index method to get the services
$services = $serviceController->index();

?>

<h1>Liste des services</h1>

<?php foreach ($services as $service): ?>
<div class="service">
    <h2><?php echo $service->getTitle(); ?></h2>
    <img src="<?php echo $service->getImage(); ?>"
        alt="<?php echo $service->getTitle(); ?>">
    <p><?php echo $service->getDescription(); ?></p>
</div>
<?php endforeach; ?>