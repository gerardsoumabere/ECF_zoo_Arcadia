<?php

// Include the database configuration file
require_once __DIR__.'/../dbconnect.php'; 
// Include ReviewController
require_once __DIR__.'/../controllers/ReviewController.php';

use Controllers\ReviewController;

// Create an instance of ReviewController
$reviewController = new ReviewController($conn);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitReview"])) {
    $pseudo = $_POST["pseudo"];
    $content = $_POST["content"];
    $isPublished = $_POST["isPublished"] ?? null;
    
    // Call the method to add a review
    $reviewController->add($pseudo, $content, $isPublished);
}
?>

<div class="container">
    <h2>Ajouter un avis</h2>
    <div class="row">
        <div class="col-md-6">
            <form action="/reviews/add" method="post">
                <div class="mb-3">
                    <label for="pseudo" class="form-label">Pseudo :</label>
                    <input type="text" class="form-control" id="pseudo"
                        name="pseudo">
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Contenu :</label>
                    <textarea class="form-control" id="content"
                        name="content"></textarea>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input"
                        id="isPublished" name="isPublished" value="0">
                    <label class="form-check-label"
                        for="isPublished">Publié</label>
                </div>
                <button type="submit" class="btn btn-primary"
                    name="submitReview">Enregistrer</button>
            </form>
        </div>
    </div>
</div>