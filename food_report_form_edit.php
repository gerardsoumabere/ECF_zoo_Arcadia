<?php
require_once __DIR__.'/../controllers/FoodReportController.php';

use Controllers\FoodReportController;

$foodReportController = new FoodReportController($conn);

$foodReport = null;
$animals = $foodReportController->getAllAnimals(); // Get all animals

// If an ID is provided in the URL, get the details of the food report
if(isset($_GET['id'])) {
    $foodReport = $foodReportController->getById($_GET['id']);
}

// If the form is submitted, update the food report
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitFoodReport"])) {
    $id = $_POST["id"];
    $animalFed = $_POST["animal_fed"];
    $foodType = $_POST["food_type"];
    $feedingTime = $_POST["feeding_time"];
    $feedingDate = date('Y-m-d H:i:s', strtotime($_POST["feeding_time"])); // Convert feeding time to MySQL datetime format
    
    // Update the food report
    $foodReportController->update($id, $animalFed, $foodType, $feedingTime, $feedingDate);
}
?>

<div class="container">
    <h2>Modifier le rapport alimentaire
        <?php echo $foodReport->getFoodReportId(); ?></h2>
    <div class="row">
        <div class="col-md-6">
            <form
                action="/food_reports/edit?id=<?php echo $foodReport->getFoodReportId(); ?>"
                method="post">
                <input type="hidden" name="id"
                    value="<?php echo $foodReport->getFoodReportId(); ?>">
                <div class="mb-3">
                    <label for="animal_fed" class="form-label">Animal nourri
                        :</label>
                    <select class="form-control" id="animal_fed"
                        name="animal_fed">
                        <?php foreach ($animals as $animal): ?>
                        <option value="<?php echo $animal['id']; ?>"
                            <?php if ($animal['id'] == $foodReport->getAnimalFed()) echo "selected"; ?>>
                            <?php echo $animal['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="food_type" class="form-label">Type de nourriture
                        :</label>
                    <input type="text" class="form-control" id="food_type"
                        name="food_type"
                        value="<?php echo $foodReport->getFoodType(); ?>">
                </div>
                <div class="mb-3">
                    <label for="feeding_time" class="form-label">Date
                        d'alimentation :</label>
                    <input type="datetime-local" class="form-control"
                        id="feeding_time" name="feeding_time"
                        value="<?php echo date('Y-m-d\TH:i', strtotime($foodReport->getFeedingTime())); ?>">
                </div>
                <button type="submit" class="btn btn-primary"
                    name="submitFoodReport">Modifier</button>
            </form>
        </div>
    </div>
</div>