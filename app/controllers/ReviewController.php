<?php

namespace Controllers;

require_once __DIR__ . '/../models/Review.php';

use Models\Review;

class ReviewController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Get all reviews
    public function index() {
        try {
            $reviews = array();
            // SQL query to get all reviews from the database
            $sql = "SELECT * FROM reviews";
            $stmt = $this->conn->query($sql);

            // Get the results of the query
            while ($row = $stmt->fetch()) {
                $review = new Review(
                    $row['id'],
                    $row['pseudo'],
                    $row['content'],
                    $row['isPublished'],
                    $this->conn
                );
                $reviews[] = $review;
            }

            // If no reviews found, return null
            if (empty($reviews)) {
                return null;
            }

            return $reviews; // Return the reviews
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Get unpublished reviews
    public function getUnpublishedReviews() {
        try {
            $unpublishedReviews = array();
            // SQL query to get unpublished reviews from the database
            $sql = "SELECT * FROM reviews WHERE isPublished = 0";
            $stmt = $this->conn->query($sql);

            // Get the results of the query
            while ($row = $stmt->fetch()) {
                $review = new Review(
                    $row['id'],
                    $row['pseudo'],
                    $row['content'],
                    $row['isPublished'],
                    $this->conn
                );
                $unpublishedReviews[] = $review;
            }

            // If no unpublished reviews found, return null
            if (empty($unpublishedReviews)) {
                return null;
            }

            return $unpublishedReviews; // Return the unpublished reviews
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Get published reviews
    public function getPublishedReviews() {
        try {
            $publishedReviews = array();
            // SQL query to get published reviews from the database
            $sql = "SELECT * FROM reviews WHERE isPublished = 1";
            $stmt = $this->conn->query($sql);

            // Get the results of the query
            while ($row = $stmt->fetch()) {
                $review = new Review(
                    $row['id'],
                    $row['pseudo'],
                    $row['content'],
                    $row['isPublished'],
                    $this->conn
                );
                $publishedReviews[] = $review;
            }

            // If no published reviews found, return null
            if (empty($publishedReviews)) {
                return null;
            }

            return $publishedReviews; // Return the published reviews
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Get a review by its ID
// Get a review by its ID
    public function getById($id) {
        try {
            // SQL query to get a review by its ID
            $sql = "SELECT * FROM reviews WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch();

            // If a review is found, return a Review object
            if ($row) {
                return new Review(
                    $row['id'],
                    $row['pseudo'],
                    $row['content'],
                    $this->conn, // Pass the connection to the Review object
                    $row['isPublished']
                );
            } else {
                return null; // Return null if no review found with the given ID
            }
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    // Add a review
    public function add($pseudo, $content, $isPublished = 0) {
        try {

            $isPublished = 0;
            // Create a new review
            $review = new Review(null, $pseudo, $content, $this->conn, $isPublished);
            // Add the new review to the database
            $review->save();

            // Redirect to the /reviews route
            header("Location: /reviews");
            exit();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }


    // Update a review
    public function update($id, $pseudo, $content, $isPublished) {
        try {
            // Get the review to update
            $review = $this->getById($id);
            $review->setPseudo($pseudo);
            $review->setContent($content);
            $review->setIsPublished($isPublished);

            // Update the review in the database
            $review->update();

            // Redirect to the /reviews route
            header("Location: /reviews/validation");
            exit();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    // Delete a review
    public function delete($id) {
        try {
            // Get the review by its ID
            $review = $this->getById($id);

            // Delete the review
            $review->delete();

            // Redirect to the /reviews route
            header("Location: /reviews");
            exit();
        } catch (\PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }
}