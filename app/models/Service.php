<?php

namespace Models;

class Service {
    private $title;
    private $image;
    private $description;

    public function __construct($title, $image, $description) {
        $this->title = $title;
        $this->image = $image;
        $this->description = $description;
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
}