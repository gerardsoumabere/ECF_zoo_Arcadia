<?php
if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'administrateur') {
    // Rediriger vers une page d'erreur ou une page d'accueil
    header("Location: /login?error=unauthorized");
    exit();
}
?>
<div class="container mt-5">
    <h1>Tableau de bord Admin</h1>
    <div class="list-group mt-4">
        <a href="/users" class="list-group-item list-group-item-action">
            Gestion des utilisateurs
        </a>
        <a href="/habitats" class="list-group-item list-group-item-action">
            Gestion des habitats
        </a>
        <a href="/animals" class="list-group-item list-group-item-action">
            Gestion des animaux
        </a>
    </div>
</div>
<h2>Modifier les horaires</h2>
<?php
// Lire le contenu du fichier JSON
$jsonData = file_get_contents('app/config/hours.json');

// Convertir le contenu JSON en tableau associatif PHP
$horaires = json_decode($jsonData, true);

// Vérifier si les données existent
if (isset($horaires['horaires'])) {
    $hours = $horaires['horaires'];

    // Vérifier si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Créer un tableau pour stocker les nouveaux horaires
        $newHours = [];

        // Parcourir les données soumises
        foreach ($_POST['hours'] as $key => $value) {
            // Récupérer le jour à partir de la clé
            $day = $hours[$key]['jour'];

            // Mettre à jour les horaires avec les nouvelles valeurs soumises
            $newHours[] = [
                'jour' => $day,
                'horaires' => $value,
                'afficher' => isset($_POST['show'][$key])
            ];
        }

        // Enregistrer les nouvelles données dans le fichier JSON
        $horaires['horaires'] = $newHours;
        file_put_contents('app/config/hours.json', json_encode($horaires));

        // Rediriger vers la même page pour afficher les modifications
        header("Location: {$_SERVER['REQUEST_URI']}");
        exit;
    }
?>
<form method="post">
    <ul>
        <?php foreach ($hours as $key => $schedule) : ?>
        <li>
            <label for="day_<?php echo $key; ?>">Jour</label>
            <input type="text" id="day_<?php echo $key; ?>"
                name="days[<?php echo $key; ?>]"
                value="<?php echo $schedule['jour']; ?>">
            <label for="schedule_<?php echo $key; ?>">Horaire</label>
            <input type="text" id="schedule_<?php echo $key; ?>"
                name="hours[<?php echo $key; ?>]"
                value="<?php echo $schedule['horaires']; ?>">
            <input type="checkbox" id="show_<?php echo $key; ?>"
                name="show[<?php echo $key; ?>]"
                <?php if ($schedule['afficher']) echo "checked"; ?>>
            <label for="show_<?php echo $key; ?>">Afficher</label>
        </li>
        <?php endforeach; ?>
    </ul>
    <button type="submit">Enregistrer</button>
</form>
<?php
} else {
    echo "Aucun horaire disponible.";
}
?>