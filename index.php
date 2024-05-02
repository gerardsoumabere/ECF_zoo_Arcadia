<?php
require_once 'app/router.php';// Include router file
require_once 'app/dbconnect.php';// Include the database configuration file

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
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-warning">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="public/assets/svg/logo_arcadia.svg" alt="Logo" height="80
                    ">
            </a>
            <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end"
                id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/habitats">Les habitats</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/services">Nos services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/connection">Connexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php echo $content; ?>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js">
    </script>
</body>

</html>