<?php

namespace Controllers;

require_once __DIR__ . '/../models/Service.php';

use Models\Service;

class ServiceController {
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
            echo "Erreur : " . $e->getMessage();
        }
    }

    // Récupérer un service par son ID
    public function getById($id) {
        try {
            // Requête SQL pour récupérer un service par son ID
            $sql = "SELECT * FROM services WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch();

            // Créer et retourner un objet Service
            return new Service($row['title'], $row['image'], $row['description'], $this->conn);
        } catch (\PDOException $e) {
            // Gérer les erreurs de base de données
            echo "Erreur : " . $e->getMessage();
        }
    }

    // Ajouter un service
    public function add($title, $image, $description) {
        try {
            // Créer un nouveau service
            $service = new Service($title, $image, $description, $this->conn);
            // Ajouter le nouveau service à la base de données
            $service->save();

            // Rediriger vers la route /services
            header("Location: /services");
            exit();
        } catch (\PDOException $e) {
            // Gérer les erreurs de base de données
            echo "Erreur : " . $e->getMessage();
        }
    }

    // Mettre à jour un service
    public function update() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Récupérer les données du formulaire
            $id = $_POST["id"];
            $title = $_POST["title"];
            $image = $_POST["image"];
            $description = $_POST["description"];

            try {
                // Récupérer le service à mettre à jour
                $service = $this->getById($id);
                $service->setTitle($title);
                $service->setImage($image);
                $service->setDescription($description);
                $service->update();
                
                // Rediriger vers la route /services
                header("Location: /services");
                exit();
            } catch (\PDOException $e) {
                // Gérer les erreurs de base de données
                echo "Erreur : " . $e->getMessage();
            }
        }
    }

    // Supprimer un service
    public function delete($id) {
        try {
            // Supprimer le service
            $service = $this->getById($id);
            $service->delete();
            
            // Rediriger vers la route /services
            header("Location: /services");
            exit();
        } catch (\PDOException $e) {
            // Gérer les erreurs de base de données
            echo "Erreur : " . $e->getMessage();
        }
    }
}