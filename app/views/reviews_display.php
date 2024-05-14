<?php
// Include the database configuration file
require_once __DIR__.'/../dbconnect.php'; 
// Include ReviewController
require_once __DIR__.'/../controllers/ReviewController.php';

use Controllers\ReviewController;

// Create an instance of ReviewController
$reviewController = new ReviewController($conn);

// Get published reviews from the database
$reviews = $reviewController->getPublishedReviews();

?>

<div class="container">

    <h1>Liste des avis publiés</h1>

    <?php if (!empty($reviews)): ?>
    <?php foreach ($reviews as $review): ?>
    <div class="review">
        <h2>ID : <?php echo $review->getId(); ?></h2>
        <!-- Afficher l'ID -->
        <p>Pseudo : <?php echo $review->getPseudo(); ?></p>
        <p>Contenu : <?php echo $review->getContent(); ?></p>
        <!-- Add links for editing and deleting -->
        <a href="/reviews/edit?id=<?php echo $review->getId(); ?>">Modifier</a>
        <a
            href="/reviews/delete?id=<?php echo $review->getId(); ?>">Supprimer</a>
    </div>
    <?php endforeach; ?>
    <?php else: ?>
    <p>Aucun avis publié trouvé.</p>
    <?php endif; ?>

    <!-- Button "Ajouter un avis" -->
    <a href="/reviews/add" class="btn btn-primary">Ajouter un avis</a>

</div>