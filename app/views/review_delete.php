<?php
require_once __DIR__ . '/../controllers/ReviewController.php';

use Controllers\ReviewController;

$reviewController = new ReviewController($conn);

$review = null;
// If an ID is provided in the URL, get the details of the review
if(isset($_GET['id'])) {
    $review = $reviewController->getById($_GET['id']);
}

// If the form is submitted, delete the review
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    
    // Delete the review
    $reviewController->delete($id);

    // Redirect to the reviews list
    header("Location: /reviews");
    exit();
}
?>

<div class="container">
    <h2>Supprimer l'avis</h2>
    <div class="row">
        <div class="col-md-6">
            <h3>ID : <?php echo $review->getId(); ?></h3>
            <p>Pseudo : <?php echo $review->getPseudo(); ?></p>
            <p>Contenu : <?php echo $review->getContent(); ?></p>
            <p>Publié : <?php echo $review->getIsPublished() ? 'Oui' : 'Non'; ?>
            </p>
            <form action="/reviews/delete?id=<?php echo $review->getId(); ?>"
                method="post">
                <input type="hidden" name="id"
                    value="<?php echo $review->getId(); ?>">
                <button type="submit" class="btn btn-danger">Confirmer la
                    suppression</button>
            </form>
        </div>
    </div>
</div>