<?php

namespace Models;

class Review {
    private $id;
    private $pseudo;
    private $content;
    private $isPublished;

    private $conn;

    public function __construct($id, $pseudo, $content, $conn,$isPublished = null) {
        $this->id = $id;
        $this->pseudo = $pseudo;
        $this->content = $content;
        $this->isPublished = $isPublished;
        $this->conn = $conn;
    }

    public function getId() {
        return $this->id;
    }

    public function getPseudo() {
        return $this->pseudo;
    }

    public function setPseudo($pseudo) {
        $this->pseudo = $pseudo;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getIsPublished() {
        return $this->isPublished;
    }

    public function setIsPublished($isPublished) {
        $this->isPublished = $isPublished;
    }

    // Method to save a review to the database
    public function save() {
        try {
            $sql = "INSERT INTO reviews (pseudo, content, isPublished) 
                    VALUES (:pseudo, :content, :isPublished)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':pseudo', $this->pseudo);
            $stmt->bindParam(':content', $this->content);
            $stmt->bindParam(':isPublished', $this->isPublished);
            $stmt->execute();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Method to update a review in the database
    public function update() {
        try {
            $sql = "UPDATE reviews SET pseudo = :pseudo, 
                    content = :content, isPublished = :isPublished WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':pseudo', $this->pseudo);
            $stmt->bindParam(':content', $this->content);
            $stmt->bindParam(':isPublished', $this->isPublished);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Method to delete a review from the database
    public function delete() {
        try {
            $sql = "DELETE FROM reviews WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }
}