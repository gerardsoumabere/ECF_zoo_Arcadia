<?php
require_once __DIR__ . '/../controllers/FoodReportController.php';

use Controllers\FoodReportController;

$foodReportController = new FoodReportController($conn);

$foodReport = null;
// If an ID is provided in the URL, get the details of the food report
if(isset($_GET['id'])) {
    $foodReport = $foodReportController->getById($_GET['id']);
}

// If the form is submitted, delete the food report
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    
    // Delete the food report
    $foodReportController->delete($id);

    // Redirect to the food reports list
    header("Location: /food_reports");
    exit();
}
?>

<div class="container">
    <h2>Supprimer le rapport alimentaire</h2>
    <div class="row">
        <div class="col-md-6">
            <h3>ID : <?php echo $foodReport->getFoodReportId(); ?></h3>
            <p>Animal nourri : <?php echo $foodReport->getAnimalFed(); ?></p>
            <p>Type de nourriture : <?php echo $foodReport->getFoodType(); ?>
            </p>
            <p>Date d'alimentation :
                <?php echo $foodReport->getFeedingTime(); ?>
            </p>
            <form
                action="/food_reports/delete?id=<?php echo $foodReport->getFoodReportId(); ?>"
                method="post">
                <input type="hidden" name="id"
                    value="<?php echo $foodReport->getFoodReportId(); ?>">
                <button type="submit" class="btn btn-danger">Confirmer la
                    suppression</button>
            </form>
        </div>
    </div>
</div>