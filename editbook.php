<?php
  require_once("templates/header.php");

  // Verifica se usuário está autenticado
  require_once("models/User.php");
  require_once("dao/UserDAO.php");
  require_once("dao/bookDAO.php");

  $user = new User();
  $userDao = new UserDao($conn, $BASE_URL);

  $userData = $userDao->verifyToken(true);

  $bookDao = new bookDAO($conn, $BASE_URL);

  $id = filter_input(INPUT_GET, "id");

  if(empty($id)) {

    $message->setMessage("O Livro não foi encontrado!", "error", "index.php");

  } else {

    $book = $bookDao->findById($id);

    // Verifica se o Livro existe
    if(!$book) {

      $message->setMessage("O Livro não foi encontrado!", "error", "index.php");

    }

  }

  // Checar se o Livro tem imagem
  if($book->image == "") {
    $book->image = "book_cover.jpg";
  }

?>
  <div id="main-container" class="container-fluid">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-6 offset-md-1">
          <h1><?= $book->title ?></h1>
          <p class="page-description">Altere os dados do Livro no fomrulário abaixo:</p>
          <form id="edit-book-form" action="<?= $BASE_URL ?>book_process.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="type" value="update">
            <input type="hidden" name="id" value="<?= $book->id ?>">
            <div class="form-group">
              <label for="title">Título:</label>
              <input type="text" class="form-control" id="title" name="title" placeholder="Digite o título do seu Livro" value="<?= $book->title ?>">
            </div>
            <div class="form-group">
              <label for="image">Imagem:</label>
              <input type="file" class="form-control-file" name="image" id="image">
            </div>
            <div class="form-group">
              <label for="category">Category:</label>
              <select name="category" id="category" class="form-control">
                <option value="">Selecione</option>
                <option value="Ação" <?= $book->category === "Ação" ? "selected" : "" ?>>Ação</option>
                <option value="Drama" <?= $book->category === "Drama" ? "selected" : "" ?>>Drama</option>
                <option value="Comédia" <?= $book->category === "Comédia" ? "selected" : "" ?>>Comédia</option>
                <option value="Fantasia / Ficção" <?= $book->category === "Fantasia / Ficção" ? "selected" : "" ?>>Fantasia / Ficção</option>
                <option value="Romance" <?= $book->category === "Romance" ? "selected" : "" ?>>Romance</option>
              </select>
            </div>
            <div class="form-group">
              <label for="description">Descrição:</label>
              <textarea name="description" id="description" rows="5" class="form-control" placeholder="Descreva o Livro..."><?= $book->description ?></textarea>
            </div>
            <input type="submit" class="btn card-btn" value="Editar Livro">
          </form>
        </div>
        <div class="col-md-3">
          <div class="book-image-container" style="background-image: url('<?= $BASE_URL ?>img/books/<?= $book->image ?>')"></div>
        </div>
      </div>
    </div>
  </div>
<?php
  require_once("templates/footer.php");
?>
