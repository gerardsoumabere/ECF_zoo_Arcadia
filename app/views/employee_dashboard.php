<?php 
    if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'employé') {
    // Rediriger vers une page d'erreur ou une page d'accueil
    header("Location: /login?error=unauthorized");
    exit();
 }
 ?><div class="container mt-5">
    <h1>Tableau de bord Employé</h1>
    <div class="list-group mt-4">
        <a href="/reviews" class="list-group-item list-group-item-action">
            Gestion des avis
        </a>
        <a href="/habitats" class="list-group-item list-group-item-action">
            Gestion des habitats</a>
        <a href="/animals" class="list-group-item list-group-item-action">
            Gestion des animaux
        </a>
        <a href="/food_reports" class="list-group-item list-group-item-action">
            Rapports alimentaires
        </a>
    </div>
</div>