<?php

namespace Controllers;

require_once __DIR__ . '/../models/Service.php';

use Models\Service;

class ServiceController {
    private $services = array();
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Afficher tous les services
    public function index() {
        try {
            $services = array();
            // Requête SQL pour récupérer tous les services depuis la base de données
            $sql = "SELECT * FROM services";
            $stmt = $this->conn->query($sql);

            // Récupérer les résultats de la requête
            while ($row = $stmt->fetch()) {
                $service = new Service($row['title'], $row['image'], $row['description'], $this->conn);
                $services[] = $service;
            }

            return $services; // Retourner les services
        } catch (\PDOException $e) {
            // Gérer les erreurs de base de données
            echo "Error: " . $e->getMessage();
        }
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