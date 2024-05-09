<?php
// Include the database configuration file
require_once __DIR__.'/dbconnect.php'; 

// Include the ServiceController
require_once __DIR__.'/controllers/ServiceController.php';
// Include the HabitatController
require_once __DIR__.'/controllers/HabitatController.php';

use Controllers\ServiceController;
use Controllers\HabitatController;

// Create an instance of ServiceController
$serviceController = new ServiceController($conn);
// Create an instance of HabitatController
$habitatController = new HabitatController($conn);

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
        'file' => 'views/habitats_display.php',
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
        'method' => 'add', // Méthode à appeler dans le ServiceController
        'controller' => $serviceController // Instance du ServiceController
    ],

    '/services/edit/process' => [
        'file' => 'controllers/ServiceController.php',
        'method' => 'update', // Méthode à appeler dans le ServiceController
        'controller' => $serviceController // Instance du ServiceController
    ],

    '/services/delete/process' => [
        'file' => 'controllers/ServiceController.php',
        'method' => 'delete', // Méthode à appeler dans le ServiceController
        'controller' => $serviceController // Instance du ServiceController
    ],
    '/habitats/edit' => [
        'file' => 'views/habitat_form_edit.php',
        'title' => 'Modifier un habitat'
    ],
    '/habitats/delete' => [
        'file' => 'views/habitat_delete.php',
        'title' => 'Supprimer un habitat'
    ],
    '/habitats/add' => [
        'file' => 'views/habitat_form_add.php',
        'title' => 'Ajouter un habitat'
    ],
    '/habitats/add/process' => [
        'file' => 'controllers/HabitatController.php',
        'method' => 'add', // Méthode à appeler dans le HabitatController
        'controller' => $habitatController // Instance du HabitatController
    ],
    '/habitats/edit/process' => [
        'file' => 'controllers/HabitatController.php',
        'method' => 'update', // Méthode à appeler dans le HabitatController
        'controller' => $habitatController // Instance du HabitatController
    ],
    '/habitats/delete/process' => [
        'file' => 'controllers/HabitatController.php',
        'method' => 'delete', // Méthode à appeler dans le HabitatController
        'controller' => $habitatController // Instance du HabitatController
    ],
];

// Function to get the page content
function getPageContent($route)
{
    global $routes, $conn; // Ajout de $conn ici
    if (array_key_exists($route, $routes)) {
        if (isset($routes[$route]['method'])) {
            // Si une méthode est définie, appeler la méthode appropriée du ServiceController ou du HabitatController
            $method = $routes[$route]['method'];
            $controller = $routes[$route]['controller'];
            if ($method == 'add' || $method == 'update' || $method == 'delete') {
                // Récupérer les données du formulaire
                $requestData = $_POST;
                // Appeler la méthode avec les données du formulaire
                return $controller->$method($requestData);
            } else {
                return $controller->$method();
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