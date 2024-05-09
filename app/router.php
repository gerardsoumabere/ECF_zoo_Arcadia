<?php
// Include the database configuration file
require_once __DIR__.'/dbconnect.php'; 

// Include the ServiceController
require_once __DIR__.'/controllers/ServiceController.php';

use Controllers\ServiceController;

// Create an instance of ServiceController
$serviceController = new ServiceController($conn);

// Define routes
$routes = [
    '/' => [
        'file' => 'views/home.php',
        'title' => 'Accueil'
    ],
    '/reviews' => [
        'file' => 'views/reviews.php',
        'title' => 'Avis'
    ],
    '/habitats' => [
        'file' => 'views/habitats.php',
        'title' => 'Les habitats'
    ],
    '/services' => [
        'file' => 'views/services_display.php',
        'title' => 'Nos services'
    ],
    '/contact' => [
        'file' => 'views/contact_form.php',
        'title' => 'Contact'
    ],
    '/connection' => [
        'file' => 'views/connection.php',
        'title' => 'Connexion'
    ],
    '/404' => [
        'file' => 'views/404.php',
        'title' => 'Erreur 404'
    ],

    '/services/edit' => [
        'file' => 'views/service_form_edit.php',
        'title' => 'Modifier un service'
    ],
    '/services/delete' => [
        'file' => 'views/service_delete.php',
        'title' => 'Supprimer un service'
    ],
    '/services/add' => [
        'file' => 'views/service_form_add.php',
        'title' => 'Ajouter un service'
    ],
    '/services/add/process' => [
        'file' => 'controllers/ServiceController.php',
        'method' => 'add' // Méthode à appeler dans le ServiceController
    ],

    '/services/edit/process' => [
        'file' => 'controllers/ServiceController.php',
        'method' => 'update' // Méthode à appeler dans le ServiceController
    ],

    '/services/delete/process' => [
        'file' => 'controllers/ServiceController.php',
        'method' => 'delete' // Méthode à appeler dans le ServiceController
    ],
];

// Function to get the page content
function getPageContent($route)
{
    global $routes, $conn, $serviceController; // Ajout de $conn et $serviceController ici
    if (array_key_exists($route, $routes)) {
        if (isset($routes[$route]['method'])) {
            // Si une méthode est définie, appeler la méthode appropriée du ServiceController
            $method = $routes[$route]['method'];
            if ($method == 'add') {
                // Récupérer les données du formulaire pour ajouter un service
                $title = $_POST["title"];
                $image = $_POST["image"];
                $description = $_POST["description"];
                // Appeler la méthode add avec les données récupérées
                $serviceController->$method($title, $image, $description);
                return ['content' => '', 'title' => '']; // Pas besoin de renvoyer du contenu ou un titre pour ces routes
            } else if ($method == 'update') {
                // Récupérer les données du formulaire pour modifier un service
                $id = $_POST["id"];
                $title = $_POST["title"];
                $image = $_POST["image"];
                $description = $_POST["description"];
                // Appeler la méthode update avec les données récupérées
                $serviceController->$method($id, $title, $image, $description);
                return ['content' => '', 'title' => '']; // Pas besoin de renvoyer du contenu ou un titre pour ces routes
            } else if ($method == 'delete') {
                // Récupérer l'ID du service à supprimer
                $id = $_POST["id"]; // Utiliser $_POST pour récupérer l'ID du service à supprimer
                $serviceController->$method($id); // Passer l'ID du service à supprimer à la méthode delete
                return ['content' => '', 'title' => '']; // Pas besoin de renvoyer du contenu ou un titre pour ces routes
            } else {
                $serviceController->$method(); // Pour les autres méthodes, pas besoin de données supplémentaires
                return ['content' => '', 'title' => '']; // Pas besoin de renvoyer du contenu ou un titre pour ces routes
            }
        } else {
            $title = $routes[$route]['title'];
            ob_start();
            require_once __DIR__ . '/' . $routes[$route]['file'];
            $content = ob_get_clean();
            return ['content' => $content, 'title' => $title];
        }
    } else {
        $title = $routes['/404']['title'];
        ob_start();
        require_once __DIR__ . '/' . $routes['/404']['file'];
        $content = ob_get_clean();
        return ['content' => $content, 'title' => $title];
    }
}

// Get the current route
$route = strtok($_SERVER['REQUEST_URI'], '?'); // Utilisation de strtok pour supprimer les paramètres GET

// Get page content based on route
$page = getPageContent($route);

// Extract title and content
$title = $page['title'];
$content = $page['content'];