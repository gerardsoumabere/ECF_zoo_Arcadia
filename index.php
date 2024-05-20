<?php
session_start();
require_once 'app/router.php';

// Routes for roles
$dashboardRoutes = [
    'administrateur' => '/admin',
    'employé' => '/employee',
    'vétérinaire' => '/vet_dashboard'
];

$navLinks = ''; // Default navbar links
$navbarClass = 'navbar-dark bg-warning'; // Default navbar class

// Check if user is logged in and has a specific role
if (isset($_SESSION['user'])) {
    $role = $_SESSION['user'];
    $dashboardLink = isset($dashboardRoutes[$role]) ? $dashboardRoutes[$role] : '#'; // Get dashboard route based on role
    $navLinks .= '<li class="nav-item"><a class="nav-link text-white" href="' . $dashboardLink . '">Dashboard (' . $role . ')</a></li>'; // Add Dashboard link with role
    $navLinks .= '<li class="nav-item"><a class="nav-link text-white" href="/logout">Se déconnecter</a></li>'; // Add Logout link
    $navbarClass = 'navbar-dark bg-secondary'; // Change navbar class for logged-in users
} else {
    // Only show these links if no role is defined
    $navLinks .= '<li class="nav-item"><a class="nav-link text-white" href="/">Accueil</a></li>'; // Add Accueil link
    $navLinks .= '<li class="nav-item"><a class="nav-link text-white" href="/habitats">Les habitats</a></li>'; // Add Habitats link
    $navLinks .= '<li class="nav-item"><a class="nav-link text-white" href="/services">Nos services</a></li>'; // Add Nos services link
    $navLinks .= '<li class="nav-item"><a class="nav-link text-white" href="/contact">Nous contacter</a></li>'; // Add Nous contacter link
    $navLinks .= '<li class="nav-item"><a class="nav-link text-white" href="/login">S\'identifier</a></li>'; // Add Login link
}
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
    <link href="public/assets/css/logo.css" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-expand-lg <?php echo $navbarClass; ?>">
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
                    <?php echo $navLinks; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php echo $content; ?>
    </div>

    <footer class="text-center text-lg-start bg-success text-dark mt-5">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Horaires d'ouverture</h5>
                    <?php
                    // Lire le contenu du fichier JSON
                    $jsonData = file_get_contents('app/config/hours.json');

                    // Convertir le contenu JSON en tableau associatif PHP
                    $horaires = json_decode($jsonData, true);

                    // Vérifier si les données existent
                    if (isset($horaires['horaires'])) {
                        $hours = $horaires['horaires'];

                        // Afficher les horaires si le booléen "afficher" est vrai
                        foreach ($hours as $horaire) {
                            if ($horaire['afficher']) {
                                echo "<p class='mb-1 small'>{$horaire['jour']} : {$horaire['horaires']}</p>";
                            }
                        }
                    } else {
                        echo "Aucun horaire disponible.";
                    }
                    ?>
                </div>
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Informations de contact</h5>
                    <p><i class="fas fa-map-marker-alt me-2"></i>Z.A de la
                        Certification, 35381 Fictiville-sur-vilaine, France</p>
                    <p><i
                            class="fas fa-envelope me-2"></i>contact@zoo-arcadia.com
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
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js">
    </script>
</body>

</html>