<?php

namespace Controllers;

require_once __DIR__ . '/../models/Service.php';

use Models\Service;

class ServiceController {
    private $services = array();
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        // Initialisation avec quelques services 
        $service1 = new Service("Service 1", "image1.jpg", "Description du service 1", $this->conn);
        $service2 = new Service("Service 2", "image2.jpg", "Description du service 2", $this->conn);
        $service3 = new Service("Service 3", "image3.jpg", "Description du service 3", $this->conn);

        $this->services[] = $service1;
        $this->services[] = $service2;
        $this->services[] = $service3;
    }

    // Afficher tous les services
    public function index() {
        return $this->services; // Retourner les services
    }

    // Afficher un service
    public function show($index) {
        if (isset($this->services[$index])) {
            $service = $this->services[$index];
            require 'views/serviceShow.php';
        } else {
            echo "Service non trouvé";
        }
    }

    // Ajouter un service
    public function add() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Récupérer les données du formulaire
            $title = $_POST["title"];
            $image = $_POST["image"];
            $description = $_POST["description"];

            // Créer un nouveau service
            $service = new Service($title, $image, $description, $this->conn);

            // Ajouter le nouveau service à la base de données
            $service->save();

            // Rediriger vers la liste des services
            header("Location: /services");
            exit();
        }
    }

    // Mettre à jour un service
    public function update($index, $title, $image, $description) {
        if (isset($this->services[$index])) {
            $service = $this->services[$index];
            $service->setTitle($title);
            $service->setImage($image);
            $service->setDescription($description);
            $this->index(); // Rediriger vers la liste des services
        } else {
            echo "Service non trouvé";
        }
    }

    // Supprimer un service
    public function delete($index) {
        if (isset($this->services[$index])) {
            array_splice($this->services, $index, 1);
            $this->index(); // Rediriger vers la liste des services
        } else {
            echo "Service non trouvé";
        }
    }
}