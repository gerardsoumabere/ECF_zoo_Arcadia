<?php
require_once __DIR__.'/../controllers/ReviewController.php';

use Controllers\ReviewController;

$reviewController = new ReviewController($conn);

$review = null;
// If an ID is provided in the URL, get the details of the review
if(isset($_GET['id'])) {
    $review = $reviewController->getById($_GET['id']);
}

// If the form is submitted, update the review
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitReview"])) {
    $id = $_POST["id"];
    $pseudo = $_POST["pseudo"];
    $content = $_POST["content"];
    $isPublished = $_POST["isPublished"] ?? null;
    
    // Update the review
    $reviewController->update($id, $pseudo, $content, $isPublished);
}
?>

<div class="container">
    <h2>Modifier l'avis <?php echo $review->getId(); ?></h2>
    <div class="row">
        <div class="col-md-6">
            <form action="/reviews/edit?id=<?php echo $review->getId(); ?>"
                method="post">
                <input type="hidden" name="id"
                    value="<?php echo $review->getId(); ?>">
                <div class="mb-3">
                    <label for="pseudo" class="form-label">Pseudo :</label>
                    <input type="text" class="form-control" id="pseudo"
                        name="pseudo"
                        value="<?php echo $review->getPseudo(); ?>">
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Contenu :</label>
                    <textarea class="form-control" id="content"
                        name="content"><?php echo $review->getContent(); ?></textarea>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input"
                        id="isPublished" name="isPublished" value="1"
                        <?php if($review->getIsPublished()) echo "checked"; ?>>
                    <label class="form-check-label"
                        for="isPublished">Publié</label>
                </div>
                <button type="submit" class="btn btn-primary"
                    name="submitReview">Modifier</button>
            </form>
        </div>
    </div>
</div>