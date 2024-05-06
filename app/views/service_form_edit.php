<?php
require_once __DIR__.'/../controllers/ServiceController.php';
use Controllers\ServiceController;

$serviceController = new ServiceController($conn);

$service = null;
// Si un ID est fourni dans l'URL, récupérer les détails du service
if(isset($_GET['id'])) {
    $service = $serviceController->getById($_GET['id']);
}
?>

<div class="container">
    <h2>Modifier le service <?php echo $service->getId(); ?></h2>
    <div class="row">
        <div class="col-md-6">
            <form action="/services/edit/process"=<?php echo $_GET['id']; ?>"
                method="post">
                <input type="hidden" name="id"
                    value="<?php echo $service->getId(); ?>">
                <div class="mb-3">
                    <label for="title" class="form-label">Titre du
                        service:</label>
                    <input type="text" class="form-control" id="title"
                        name="title"
                        value="<?php echo $service->getTitle(); ?>">
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image:</label>
                    <input type="text" class="form-control" id="image"
                        name="image"
                        value="<?php echo $service->getImage(); ?>">
                </div>
                <div class="mb-3">
                    <label for="description"
                        class="form-label">Description:</label>
                    <textarea class="form-control" id="description"
                        name="description"><?php echo $service->getDescription(); ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Modifier</button>
            </form>
        </div>
    </div>
</div>