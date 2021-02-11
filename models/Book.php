<?php

  class book {

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

  interface bookDAOInterface {

    public function buildbook($data);
    public function findAll();
    public function getLatestbooks();
    public function getbooksByCategory($category);
    public function getbooksByUserId($id);
    public function findById($id);
    public function findByTitle($title);
    public function create(book $book);
    public function update(book $book);
    public function destroy($id);

  }