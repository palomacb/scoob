<?php

  class Book {

    public $id;
    public $title;
    public $description;
    public $image;
    public $category;
    public $users_id;

    public function imageGenerateName() {
      return bin2hex(random_bytes(60)) . ".jpg";
    }

  }

  interface BookDAOInterface {

    public function buildBook($data);
    public function findAll();
    public function getLatestBooks();
    public function getBooksByCategory($category);
    public function getBooksByUserId($id);
    public function findById($id);
    public function findByTitle($title);
    public function create(Book $book);
    public function update(Book $book);
    public function destroy($id);

  }