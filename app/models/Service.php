<?php

namespace Models;

class Service {
    private $title;
    private $image;
    private $description;
    private $conn;

    public function __construct($title, $image, $description, $conn) {
        $this->title = $title;
        $this->image = $image;
        $this->description = $description;
        $this->conn = $conn;
    }
    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    // Méthode pour ajouter le service à la base de données
    public function save() {
        try {
            // Requête SQL pour insérer un nouveau service dans la table services
            $sql = "INSERT INTO services (title, image, description) VALUES (:title, :image, :description)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':image', $this->image);
            $stmt->bindParam(':description', $this->description);
            $stmt->execute();

            echo ('Le service a été rentré dans la base de données');
        } catch (\PDOException $e) {
            // Gérer les erreurs de base de données
            echo "Error: " . $e->getMessage();
        }
    }
}