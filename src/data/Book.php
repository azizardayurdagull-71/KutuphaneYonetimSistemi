<?php
// src/data/Book.php

class Book {
    private $id;
    private $title;
    private $author;
    private $isbn;
    private $publish_year;
    private $genre;
    private $shelf_location;
    private $stock;
    private $cover_image;

    public function __construct($data = []) {
        $this->title = $data['title'] ?? null;
        $this->author = $data['author'] ?? null;
        $this->isbn = $data['isbn'] ?? null;
        $this->publish_year = $data['publish_year'] ?? null;
        $this->genre = $data['genre'] ?? null;
        $this->shelf_location = $data['shelf_location'] ?? null;
        $this->stock = $data['stock'] ?? 0;
        $this->cover_image = $data['cover_image'] ?? null;
    }

    // Getter Metotları (Kapsülleme gereği)[cite: 1]
    public function getTitle() { return $this->title; }
    public function getAuthor() { return $this->author; }
    public function getIsbn() { return $this->isbn; }
    public function getPublishYear() { return $this->publish_year; }
    public function getGenre() { return $this->genre; }
    public function getShelfLocation() { return $this->shelf_location; }
    public function getStock() { return $this->stock; }
    public function getCoverImage() { return $this->cover_image; }
}
?>