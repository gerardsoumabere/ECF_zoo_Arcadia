<?php
require_once 'app/router.php';// Include router file

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <link href="public\assets\css\logo.css" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-warning">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img src="public/assets/svg/logo_arcadia.svg" alt="Logo"
                    height="80">
            </a>
            <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-around"
                id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/habitats">Les
                            habitats</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link text-white" href="/services">Nos
                            services</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link text-white" href="/contact">Nous
                            contacter</a>
                    <li class="nav-item">
                        <a class="nav-link text-white"
                            href="/identification">S'identifier</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>




    <?php echo $content; ?>

    <footer class="text-center text-lg-start bg-success text-dark">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Horaires d'ouverture</h5>
                    <p>Mardi - Dimanche: 8h00 - 18h00</p>
                </div>
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Informations de contact</h5>
                    <p><i class="fas fa-map-marker-alt me-2"></i>Z.A de la
                        Certification
                        , 35381 Fictiville-sur-vilaine, France</p>
                    <p><i class="fas fa-envelope me-2"></i>
                        contact@zoo-arcadia.com
                    </p>
                    <p><i class="fas fa-phone me-2"></i> 09 87 65 43 21</p>
                </div>
            </div>
        </div>
        <div class="text-center p-3">
            <?php echo date("Y"); ?> ECF Zoo Arcadia
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script
        src="
            https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js">
    </script>


    <script src="https://kit.fontawesome.com/b9e4f7e18e.js"
        crossorigin="anonymous"></script>
</body>

</html>