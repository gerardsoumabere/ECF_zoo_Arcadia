<?php

if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'vétérinaire') {
    // Rediriger vers une page d'erreur ou une page d'accueil
    header("Location: /login?error=unauthorized");
    exit();
}
?>

<div class="container mt-5">
    <h1>Tableau de bord Vétérinaire</h1>
    <div>
        <a href="/vet_reports" class="list-group-item list-group-item-action">
            Gestion des rapports vétérinaires
        </a>
    </div>
</div>