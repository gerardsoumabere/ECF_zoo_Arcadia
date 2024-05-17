<?php
// Start session
session_start();

// Include the database configuration file
require_once __DIR__.'/../dbconnect.php'; 
// Include FoodReportController
require_once __DIR__.'/../controllers/FoodReportController.php';

use Controllers\FoodReportController;

// Create an instance of FoodReportController
$foodReportController = new FoodReportController($conn);

// Get all animals
$animals = $foodReportController->getAllAnimals();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitFoodReport"])) {
    $animalFed = $_POST["animal_fed"];
    $foodType = $_POST["food_type"];
    $feedingTime = $_POST["feeding_time"];
    $feedingDate = date('Y-m-d H:i:s', strtotime($_POST["feeding_time"])); // Convert feeding time to MySQL datetime format
    
    // Call the method to add a food report
    $foodReportController->add($animalFed, $foodType, $feedingTime, $feedingDate);
}
?>

<div class="container">
    <h2>Ajouter un rapport alimentaire</h2>
    <div class="row">
        <div class="col-md-6">
            <form action="/food_reports/add" method="post">
                <div class="mb-3">
                    <label for="animal_fed" class="form-label">Animal nourri
                        :</label>
                    <select class="form-select" id="animal_fed"
                        name="animal_fed">
                        <?php foreach ($animals as $animal) { ?>
                        <option value="<?php echo $animal['id']; ?>">
                            <?php echo $animal['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="food_type" class="form-label">Type de nourriture
                        :</label>
                    <input type="text" class="form-control" id="food_type"
                        name="food_type">
                </div>
                <div class="mb-3">
                    <label for="feeding_time" class="form-label">Date
                        d'alimentation :</label>
                    <input type="datetime-local" class="form-control"
                        id="feeding_time" name="feeding_time">
                </div>
                <button type="submit" class="btn btn-primary"
                    name="submitFoodReport">Enregistrer</button>
            </form>
        </div>
    </div>
</div>