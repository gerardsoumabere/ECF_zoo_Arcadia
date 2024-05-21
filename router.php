<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__.'/dbconnect.php'; 

// Include ServiceController
require_once __DIR__.'/controllers/ServiceController.php';
// Include HabitatController
require_once __DIR__.'/controllers/HabitatController.php';
// Include AnimalController
require_once __DIR__.'/controllers/AnimalController.php';
// Include VetReportController
require_once __DIR__.'/controllers/VetReportController.php';
// Include FoodReportController
require_once __DIR__.'/controllers/FoodReportController.php';
// Include UserController
require_once __DIR__.'/controllers/UserController.php';
// Include ReviewController
require_once __DIR__.'/controllers/ReviewController.php';



use Controllers\ServiceController;
use Controllers\HabitatController;
use Controllers\AnimalController;
use Controllers\VetReportController;
use Controllers\FoodReportController;
use Controllers\UserController;
use Controllers\ReviewController;

// Create an instance of ServiceController
$serviceController = new ServiceController($conn);
// Create an instance of HabitatController
$habitatController = new HabitatController($conn);
// Create an instance of AnimalController
$animalController = new AnimalController($conn);
// Create an instance of VetReportController
$vetReportController = new VetReportController($conn);
// Create an instance of FoodReportController
$foodReportController = new FoodReportController($conn);
// Create an instance of UserController
$userController = new UserController($conn);
// Create an instance of ReviewController
$reviewController = new ReviewController($conn);


// Define routes
$routes = [
    '/' => [
        'file' => 'views/home.php',
        'title' => 'Bienvenue au Zoo Arcadia'
    ],    
    // Routes for ServiceController
    '/services' => [
        'file' => 'views/services_display.php',
        'title' => 'Nos services'
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

    // Routes for HabitatController
    '/habitats' => [
        'file' => 'views/habitats_display.php',
        'title' => 'Les habitats'
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
    'controller' => $habitatController, // Instance du HabitatController
    'requestData' => $_POST // Passer les données du formulaire
    ],


    // Routes for AnimalController
    '/animals' => [
        'file' => 'views/animals_display.php',
        'title' => 'Les animaux'
    ],
    '/animals/edit' => [
        'file' => 'views/animal_form_edit.php',
        'title' => 'Modifier un animal'
    ],
    '/animals/delete' => [
        'file' => 'views/animal_delete.php',
        'title' => 'Supprimer un animal'
    ],
    '/animals/add' => [
        'file' => 'views/animal_form_add.php',
        'title' => 'Ajouter un animal'
    ],
    '/animals/add/process' => [
        'file' => 'controllers/AnimalController.php',
        'method' => 'add', // Méthode à appeler dans le AnimalController
        'controller' => $animalController // Instance du AnimalController
    ],
    '/animals/edit/process' => [
        'file' => 'controllers/AnimalController.php',
        'method' => 'update', // Méthode à appeler dans le AnimalController
        'controller' => $animalController // Instance du AnimalController
    ],
    '/animals/delete/process' => [
        'file' => 'controllers/AnimalController.php',
        'method' => 'delete', // Méthode à appeler dans le AnimalController
        'controller' => $animalController // Instance du AnimalController
    ],

    // Routes for VetReportController
    '/vet_reports' => [
        'file' => 'views/vet_reports_display.php',
        'title' => 'Les rapports vétérinaires'
    ],
    '/vet_reports/edit' => [
        'file' => 'views/vet_report_form_edit.php',
        'title' => 'Modifier un rapport vétérinaire'
    ],
    '/vet_reports/delete' => [
        'file' => 'views/vet_report_delete.php',
        'title' => 'Supprimer un rapport vétérinaire'
    ],
    '/vet_reports/add' => [
        'file' => 'views/vet_report_form_add.php',
        'title' => 'Ajouter un rapport vétérinaire'
    ],
    '/vet_reports/add/process' => [
        'file' => 'controllers/VetReportController.php',
        'method' => 'add', // Méthode à appeler dans le VetReportController
        'controller' => $vetReportController // Instance du VetReportController
    ],
    '/vet_reports/edit/process' => [
        'file' => 'controllers/VetReportController.php',
        'method' => 'update', // Méthode à appeler dans le VetReportController
        'controller' => $vetReportController // Instance du VetReportController
    ],
    '/vet_reports/delete/process' => [
        'file' => 'controllers/VetReportController.php',
        'method' => 'delete', // Méthode à appeler dans le VetReportController
        'controller' => $vetReportController // Instance du VetReportController
    ],

    // Routes for FoodReportController
    '/food_reports' => [
        'file' => 'views/food_reports_display.php',
        'title' => 'Les rapports alimentaires'
    ],
    '/food_reports/edit' => [
        'file' => 'views/food_report_form_edit.php',
        'title' => 'Modifier un rapport alimentaire'
    ],
    '/food_reports/delete' => [
        'file' => 'views/food_report_delete.php',
        'title' => 'Supprimer un rapport alimentaire'
    ],
    '/food_reports/add' => [
        'file' => 'views/food_report_form_add.php',
        'title' => 'Ajouter un rapport alimentaire'
    ],
    '/food_reports/add/process' => [
        'file' => 'controllers/FoodReportController.php',
        'method' => 'add', // Méthode à appeler dans le FoodReportController
        'controller' => $foodReportController // Instance du FoodReportController
    ],
    '/food_reports/edit/process' => [
        'file' => 'controllers/FoodReportController.php',
        'method' => 'update', // Méthode à appeler dans le FoodReportController
        'controller' => $foodReportController // Instance du FoodReportController
    ],
    '/food_reports/delete/process' => [
        'file' => 'controllers/FoodReportController.php',
        'method' => 'delete', // Méthode à appeler dans le FoodReportController
        'controller' => $foodReportController // Instance du FoodReportController
    ],

    // Routes for UserController
    '/users' => [
        'file' => 'views/users_display.php',
        'title' => 'Liste des utilisateurs'
    ],
    '/users/add' => [
        'file' => 'views/user_form_add.php',
        'title' => 'Ajouter un utilisateur'
    ],
    '/users/edit' => [
        'file' => 'views/user_form_edit.php',
        'title' => 'Modifier un utilisateur'
    ],
    '/users/delete' => [
        'file' => 'views/user_delete.php',
        'title' => 'Supprimer un utilisateur'
    ],
    '/users/add/process' => [
        'file' => 'controllers/UserController.php',
        'method' => 'add', // Méthode à appeler dans le UserController
        'controller' => $userController // Instance du UserController
    ],
    '/users/edit/process' => [
        'file' => 'controllers/UserController.php',
        'method' => 'update', // Méthode à appeler dans le UserController
        'controller' => $userController // Instance du UserController
    ],
    '/users/delete/process' => [
        'file' => 'controllers/UserController.php',
        'method' => 'delete', // Méthode à appeler dans le UserController
        'controller' => $userController // Instance du UserController
    ],

    // Routes for ReviewController
    '/reviews' => [
        'file' => 'views/reviews_display.php',
        'title' => 'Avis'
    ],    
    '/reviews/validation' => [
        'file' => 'views/reviews_validation.php',
        'title' => 'Avis'   
    ],
    '/reviews/edit' => [
        'file' => 'views/review_form_edit.php',
        'title' => 'Modifier un avis'
    ],
    '/reviews/delete' => [
        'file' => 'views/review_delete.php',
        'title' => 'Supprimer un avis'
    ],
    '/reviews/add' => [
        'file' => 'views/review_form_add.php',
        'title' => 'Ajouter un avis'
    ],
    '/reviews/add/process' => [
        'file' => 'controllers/ReviewController.php',
        'method' => 'add', // Méthode à appeler dans le ReviewController
        'controller' => $reviewController // Instance du ReviewController
    ],
    '/reviews/edit/process' => [
        'file' => 'controllers/ReviewController.php',
        'method' => 'update', // Méthode à appeler dans le ReviewController
        'controller' => $reviewController // Instance du ReviewController
    ],
    '/reviews/delete/process' => [
        'file' => 'controllers/ReviewController.php',
        'method' => 'delete', // Méthode à appeler dans le ReviewController
        'controller' => $reviewController // Instance du ReviewController
    ],
    // Route for Contact
    '/contact' => [
        'file' => 'views/contact_form.php',
        'title' => 'Nous contacter'
    ],

    // Route for Login
    '/login' => [
        'file' => 'views/login.php',
        'title' => 'S\'identifier'
    ],
    '/login/process' => [
        'file' => 'controllers/UserController.php',
        'method' => 'login', 
        'controller' => $userController, 
        'requestData' => $_POST
    ],
    '/logout' => [
        'file' => 'controllers/UserController.php',
        'method' => 'logout', // Méthode à appeler dans le LoginController
        'controller' => $userController // Instance du LoginController
    ],
    
    //Routes for roles
    '/admin' => [
        'file' => 'views/admin_dashboard.php',
        'title' => 'Administrateur'
    ],
    '/employee' => [
        'file' => 'views/employee_dashboard.php',
        'title' => 'Employé',
    ],
    '/vet_dashboard' => [
        'file' => 'views/vet_dashboard.php',
        'title' => 'Vétérinaire', 
    ],
    // Default 404 route
    '/404' => [
        'file' => 'views/404.php',
        'title' => 'Erreur 404'
    ],
];



// Function to get the page content
function getPageContent($route)
{
    global $routes, $conn; // Ajout de $conn ici

    if (array_key_exists($route, $routes)) {
        if (isset($routes[$route]['method'])) {
            echo ('méthode définie');
            // Si une méthode est définie, appeler la méthode appropriée du Controller
            $method = $routes[$route]['method'];
            $controller = $routes[$route]['controller'];
            if ($method == 'add' || $method == 'update' || $method == 'delete' || $method == 'login') {
                // Vérifier si des données POST ont été envoyées
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Récupérer les données du formulaire
                    $requestData = $_POST;
                    // Appeler la méthode avec les données du formulaire
                    return $controller->$method($requestData);
                } else {
                    // Gérer l'absence de données POST
                    return "Aucune donnée POST n'a été envoyée.";
                }
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