<?php

namespace Models;

class User {
    private $id; 
    private $firstName;
    private $lastName;
    private $email;
    private $password;
    private $role;
    private $conn;

    public function __construct($firstName, $lastName, $email, $password, $role, $conn) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role; 
        $this->conn = $conn;
    }

    public function getId() { 
        return $this->id;
    }

    public function setId($id) { 
        $this->id = $id;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    // Ajouter les méthodes pour gérer le rôle de l'utilisateur
    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function user() {
        return $this->firstName . ' ' . $this->lastName;
    }

    // Méthode pour enregistrer l'utilisateur dans la base de données
    public function save() {
        try {
            // Requête SQL pour insérer un nouvel utilisateur dans la table users
            $sql = "INSERT INTO users (first_name, last_name, email, password, role) VALUES (:firstName, :lastName, :email, :password, :role)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':firstName', $this->firstName);
            $stmt->bindParam(':lastName', $this->lastName);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':role', $this->role); // Ajout du rôle
            $stmt->execute();

            // Récupérer l'ID de l'utilisateur ajouté
            $this->id = $this->conn->lastInsertId();

            // Affichage d'un message de débogage pour vérifier l'ID
            echo "ID de l'utilisateur ajouté : " . $this->id;

            echo ('L\'utilisateur a été ajouté à la base de données avec l\'ID ' . $this->id);
        } catch (\PDOException $e) {
            // Gérer les erreurs de base de données
            echo "Error: " . $e->getMessage();
        }
    }

    // Méthode pour mettre à jour l'utilisateur dans la base de données
    public function update() {
        try {
            // Requête SQL pour mettre à jour un utilisateur dans la table users
            $sql = "UPDATE users SET first_name = :firstName, last_name = :lastName, email = :email, password = :password, role = :role WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':firstName', $this->firstName);
            $stmt->bindParam(':lastName', $this->lastName);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':role', $this->role); // Ajout du rôle
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();

            echo ('L\'utilisateur a été mis à jour dans la base de données');
        } catch (\PDOException $e) {
            // Gérer les erreurs de base de données
            echo "Error: " . $e->getMessage();
        }
    }

    // Méthode pour supprimer l'utilisateur de la base de données
    public function delete() {
        try {
            // Requête SQL pour supprimer un utilisateur de la table users
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();

            echo ('L\'utilisateur a été supprimé de la base de données');
        } catch (\PDOException $e) {
            // Gérer les erreurs de base de données
            echo "Erreur : " . $e->getMessage();
        }
    }
}