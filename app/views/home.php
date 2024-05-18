<?php require_once __DIR__ . '/../controllers/ReviewController.php';
use Controllers\ReviewController;
?>

<body>

    <div class="py-5 hero-section position-relative text-center"
        style="background-image: url('../../public/assets/img/hero_img.jpg'); background-size: cover; padding: 50px 0;">
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-75"
            style="content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.75); z-index: 1;">
        </div>
        <h1 class="display-5 fw-bold text-white position-relative z-index-1 mt-5"
            style="position: relative; z-index: 2;">
            Bienvenue au zoo Arcadia
        </h1>
        <div class="col-lg-6 mx-auto position-relative z-index-1"
            style="position: relative; z-index: 2;">
            <p class="fs-5 mb-4 text-white">
                Venez découvrir la diversité de nos animaux exotiques dans leur
                habitat adapté.
                Nous nous engageons à la préservation de l'environnement et au
                bien-être de tous les êtres vivants grâce à notre autonomie
                totale
                en énergie verte et un suivi vétérinaire journalier.
            </p>
        </div>
    </div>

    <hr class="hr" />

    <div class="container">
        <!-- Example row of columns -->
        <div class="row">
            <div class="col-md-4">
                <h2>Les habitats</h2>
                <img src="../../public/assets/img/habitat_img.png"
                    class="img-fluid" alt="illustration des habitats">
                <p>Parcourez les différents habitats pour découvrir nos
                    magnifiques
                    animaux.</p>
                <p><a class="btn btn-secondary" href="/habitats"
                        role="button">Parcourir »</a></p>
            </div>
            <div class="col-md-4">
                <h2>Nos services</h2>
                <img src="../../public/assets/img/services_img.jpg"
                    class="img-fluid" alt="illustration des services">
                <p>Venez découvrir nos différents services afin d'améliorer
                    votre
                    visite.</p>
                <p><a class="btn btn-secondary" href="/services"
                        role="button">Découvrir »</a></p>
            </div>
            <div class="col-md-4">
                <h2>Ce qu'ils en pensent</h2>
                <div id="reviewCarousel" class="carousel slide"
                    data-ride="carousel">
                    <div class="carousel-inner" id="reviews"
                        style="display: flex; align-items: center;">
                        <?php
                        // Récupérer les avis depuis la base de données
                        $reviewController = new ReviewController($conn);
                        $reviews = $reviewController->index();

                        // Afficher les avis dans le carrousel
                        if (!empty($reviews)) {
                            foreach ($reviews as $index => $review) {
                                echo '<div class="carousel-item' . ($index === 0 ? ' active' : '') . '">'
                                    . '<div class="jumbotron jumbotron-fluid p-4">'
                                    . '<div class="container">'
                                    . '<h1 class="display-4">' . $review->getPseudo() . '</h1>'
                                    . '<p class="lead">' . $review->getContent() . '</p>'
                                    . '</div>'
                                    . '</div>'
                                    . '</div>';
                            }
                        }
                        ?>
                    </div>
                </div>
                <p><a class="btn btn-secondary" href="/reviews"
                        role="button">Votre
                        avis compte »</a></p>
            </div>
        </div>

        <hr>
    </div>

    <script>
    // JavaScript pour changer l'avis du carrousel toutes les X secondes
    document.addEventListener("DOMContentLoaded", function() {
        var reviewsContainer = document.getElementById('reviews');
        var reviews = reviewsContainer.querySelectorAll(
            '.carousel-item');
        var currentIndex = 0;

        function changeReview() {
            reviews[currentIndex].classList.remove('active');
            currentIndex = (currentIndex + 1) % reviews.length;
            reviews[currentIndex].classList.add('active');
        }

        setInterval(changeReview,
            8000); // 
    });
    </script>
</body>