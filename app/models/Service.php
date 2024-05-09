<?php
namespace Models;

class Service {
    private $id; 
    private $title;
    private $image;
    private $description;
    private $conn;

    public function __construct($id,$title, $image, $description, $conn) {
        $this->id = $id;
        $this->title = $title;
        $this->image = $image;
        $this->description = $description;
        $this->conn = $conn;
    }

    public function getId() { 
        return $this->id;
    }

        public function setId($id) { 
        $this->id = $id;
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

        // Récupérer l'ID du service ajouté
        $this->id = $this->conn->lastInsertId();

        // Affichage d'un message de débogage pour vérifier l'ID
        echo "ID du service ajouté : " . $this->id;

        echo ('Le service a été rentré dans la base de données avec l\'ID ' . $this->id);
    } catch (\PDOException $e) {
        // Gérer les erreurs de base de données
        echo "Error: " . $e->getMessage();
    }
}


    // Méthode pour mettre à jour le service dans la base de données
    public function update() {
        try {
            // Requête SQL pour mettre à jour un service dans la table services
            $sql = "UPDATE services SET title = :title, image = :image, description = :description WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':image', $this->image);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();

            echo ('Le service a été mis à jour dans la base de données');
        } catch (\PDOException $e) {
            // Gérer les erreurs de base de données
            echo "Error: " . $e->getMessage();
        }
    }

    public function delete() {
        try {
            // Requête SQL pour supprimer un service de la table services
            $sql = "DELETE FROM services WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();

            echo ('Le service a été supprimé de la base de données');
        } catch (\PDOException $e) {
            // Gérer les erreurs de base de données
            echo "Erreur : " . $e->getMessage();
        }
    }
}