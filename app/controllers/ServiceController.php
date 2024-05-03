<?php
namespace Controllers;

require_once __DIR__ . '/../models/Service.php';

use Models\Service;

class ServiceController {
    private $services = array();

    public function __construct() {
        // Initialisation avec quelques services
        $service1 = new Service("Service 1", "image1.jpg", "Description du service 1");
        $service2 = new Service("Service 2", "image2.jpg", "Description du service 2");
        $service3 = new Service("Service 3", "image3.jpg", "Description du service 3");

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
    public function add($title, $image, $description) {
        $service = new Service($title, $image, $description);
        $this->services[] = $service;
        $this->index(); // Rediriger vers la liste des services
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