<?php
// Define routes
$routes = [
    '/' => [
        'file' => 'views/home.php',
        'title' => 'Accueil'
    ],
    '/avis' => [
        'file' => 'views/review.php',
        'title' => 'Avis'
    ],
    '/habitats' => [
        'file' => 'views/habitats.php',
        'title' => 'Les habitats'
    ],
    '/services' => [
        'file' => 'views/services.php',
        'title' => 'Nos services'
    ],
    '/contact' => [
        'file' => 'views/contact.php',
        'title' => 'Contact'
    ],
    '/connection' => [
        'file' => 'views/connection.php',
        'title' => 'Connexion'
    ],
    '/404' => [
        'file' => 'views/404.php',
        'title' => 'Erreur 404'
    ]
];

// Function to get the page content
function getPageContent($route)
{
    global $routes;
    if (array_key_exists($route, $routes)) {
        $title = $routes[$route]['title'];
        ob_start();
        require_once __DIR__ . '/' . $routes[$route]['file'];
        $content = ob_get_clean();
    } else {
        $title = $routes['/404']['title'];
        ob_start();
        require_once __DIR__ . '/' . $routes['/404']['file'];
        $content = ob_get_clean();
    }
    return ['content' => $content, 'title' => $title];
}

// Get the current route
$route = $_SERVER['REQUEST_URI'];

// Get page content based on route
$page = getPageContent($route);

// Extract title and content
$title = $page['title'];
$content = $page['content'];