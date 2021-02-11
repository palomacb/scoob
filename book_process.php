<?php

  require_once("globals.php");
  require_once("db.php");
  require_once("models/book.php");
  require_once("models/Message.php");
  require_once("dao/UserDAO.php");
  require_once("dao/bookDAO.php");

  $message = new Message($BASE_URL);
  $userDao = new UserDAO($conn, $BASE_URL);
  $bookDao = new bookDAO($conn, $BASE_URL);

  // Resgata o tipo do formulário
  $type = filter_input(INPUT_POST, "type");

  // Resgata dados do usuário
  $userData = $userDao->verifyToken();

  if($type === "create") {

    // Receber os dados dos inputs
    $title = filter_input(INPUT_POST, "title");
    $description = filter_input(INPUT_POST, "description");
    $category = filter_input(INPUT_POST, "category");

    $book = new book();

    // Validação mínima de dados
    if(!empty($title) && !empty($description) && !empty($category)) {

      $book->title = $title;
      $book->description = $description;
      $book->category = $category;
      $book->users_id = $userData->id;

      // Upload de imagem do Livro
      if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

        $image = $_FILES["image"];
        $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
        $jpgArray = ["image/jpeg", "image/jpg"];

        // Checando tipo da imagem
        if(in_array($image["type"], $imageTypes)) {

          // Checa se imagem é jpg
          if(in_array($image["type"], $jpgArray)) {
            $imageFile = imagecreatefromjpeg($image["tmp_name"]);
          } else {
            $imageFile = imagecreatefrompng($image["tmp_name"]);
          }

          // Gerando o nome da imagem
          $imageName = $book->imageGenerateName();

          imagejpeg($imageFile, "./img/books/" . $imageName, 100);

          $book->image = $imageName;

        } else {

          $message->setMessage("Tipo inválido de imagem, insira png ou jpg!", "error", "back");

        }

      }

      $bookDao->create($book);

    } else {

      $message->setMessage("Você precisa adicionar pelo menos: título, descrição e categoria!", "error", "back");

    }

  } else if($type === "delete") {

    // Recebe os dados do form
    $id = filter_input(INPUT_POST, "id");

    $book = $bookDao->findById($id);

    if($book) {

      // Verificar se o Livro é do usuário
      if($book->users_id === $userData->id) {

        $bookDao->destroy($book->id);

      } else {

        $message->setMessage("Informações inválidas!", "error", "index.php");

      }

    } else {

      $message->setMessage("Informações inválidas!", "error", "index.php");

    }

  } else if($type === "update") { 

    // Receber os dados dos inputs
    $title = filter_input(INPUT_POST, "title");
    $description = filter_input(INPUT_POST, "description");
    $category = filter_input(INPUT_POST, "category");
    $id = filter_input(INPUT_POST, "id");

    $bookData = $bookDao->findById($id);

    // Verifica se encontrou o Livro
    if($bookData) {

      // Verificar se o Livro é do usuário
      if($bookData->users_id === $userData->id) {

        // Validação mínima de dados
        if(!empty($title) && !empty($description) && !empty($category)) {

          // Edição do Livro
          $bookData->title = $title;
          $bookData->description = $description;
          $bookData->category = $category;
          
          // Upload de imagem do Livro
          if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

            $image = $_FILES["image"];
            $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
            $jpgArray = ["image/jpeg", "image/jpg"];

            // Checando tipo da imagem
            if(in_array($image["type"], $imageTypes)) {

              // Checa se imagem é jpg
              if(in_array($image["type"], $jpgArray)) {
                $imageFile = imagecreatefromjpeg($image["tmp_name"]);
              } else {
                $imageFile = imagecreatefrompng($image["tmp_name"]);
              }

              // Gerando o nome da imagem
              $book = new book();

              $imageName = $book->imageGenerateName();

              imagejpeg($imageFile, "./img/books/" . $imageName, 100);

              $bookData->image = $imageName;

            } else {

              $message->setMessage("Tipo inválido de imagem, insira png ou jpg!", "error", "back");

            }

          }

          $bookDao->update($bookData);

        } else {

          $message->setMessage("Você precisa adicionar pelo menos: título, descrição e categoria!", "error", "back");

        }

      } else {

        $message->setMessage("Informações inválidas!", "error", "index.php");

      }

    } else {

      $message->setMessage("Informações inválidas!", "error", "index.php");

    }
  
  } else {

    $message->setMessage("Informações inválidas!", "error", "index.php");

  }