<?php
namespace Controllers;

require_once __DIR__ . '/../models/User.php';

use Models\User;

class UserController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Get all users
    public function index() {
        try {
            $users = array();
            // SQL query to get all users from the database
            $sql = "SELECT * FROM users";
            $stmt = $this->conn->query($sql);

            // Get the results of the query
            while ($row = $stmt->fetch()) {
                $user = new User(
                    $row['first_name'],
                    $row['last_name'],
                    $row['email'], 
                    $row['password'],
                    $row['role'],
                    $this->conn
                );
                $user->setId($row['id']);
                $users[] = $user;
            }

            // If no users found, return null
            if (empty($users)) {
                return null;
            }

            return $users; // Return the users
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Get a user by its ID
    public function getById($id) {
        try {
            // SQL query to get a user by its ID
            $sql = "SELECT * FROM users WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch();

            // If a user is found, return a User object
            if ($row) {
                $user = new User(
                    $row['first_name'],
                    $row['last_name'],
                    $row['email'], // Utilisation de l'email au lieu du username
                    $row['password'],
                    $row['role'], // Ajout du rôle
                    $this->conn
                );
                $user->setId($row['id']);
                return $user;
            } else {
                return null; // Return null if no user found with the given ID
            }
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Add a user
    public function add($firstName, $lastName, $email, $password, $role) {
        try {
            // Create a new user
            $user = new User($firstName, $lastName, $email, $password, $role, $this->conn);
            // Add the new user to the database
            $user->save();

            // Redirect to the /users route
            header("Location: /users");
            exit();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Update a user
    public function update($id, $firstName, $lastName, $email, $password, $role) {
        try {
            // Get the user to update
            $user = $this->getById($id);
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setEmail($email); 
            $user->setPassword($password);
            $user->setRole($role); // Mise à jour du rôle

            // Update the user in the database
            $user->update();

            // Redirect to the /users route
            header("Location: /users");
            exit();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Delete a user
    public function delete($id) {
        try {
            // Récupérer l'ID de l'utilisateur à supprimer depuis le tableau
            $id = $id['id'];
            
            // Récupérer l'utilisateur par son ID
            $user = $this->getById($id);

            // Supprimer l'utilisateur
            $user->delete();

            // Rediriger vers la route /users
            header("Location: /users");
            exit();

        } catch (\PDOException $e) {
            // Gérer les erreurs de base de données
            echo "Erreur : " . $e->getMessage();
        }
    }
}