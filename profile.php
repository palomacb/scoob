<?php
  require_once("templates/header.php");

  // Verifica se usuário está autenticado
  require_once("models/User.php");
  require_once("dao/UserDAO.php");
  require_once("dao/BookDAO.php");

  $user = new User();
  $userDao = new UserDAO($conn, $BASE_URL);
  $bookDao = new BookDAO($conn, $BASE_URL);

  // Receber id do usuário
  $id = filter_input(INPUT_GET, "id");

  if(empty($id)) {

    if(!empty($userData)) {

      $id = $userData->id;

    } else {

      $message->setMessage("Usuário não encontrado!", "error", "index.php");

    }

  } else {

    $userData = $userDao->findById($id);

    // Se não encontrar usuário
    if(!$userData) {
      $message->setMessage("Usuário não encontrado!", "error", "index.php");
    }

  }

  $fullName = $user->getFullName($userData);

  if($userData->image == "") {
    $userData->image = "user.png";
  }

  // livros que o usuário adicionou
  $userBooks = $bookDao->getBooksByUserId($id);

?>
  <div id="main-container" class="container-fluid">
    <div class="col-md-8 offset-md-2">
      <div class="row profile-container">
        <div class="col-md-12 about-container">
          <h1 class="page-title"><?= $fullName ?></h1>
          <div id="profile-image-container" class="profile-image" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $userData->image ?>')"></div>
          <h3 class="about-title">Sobre:</h3>
          <?php if(!empty($userData->bio)): ?>
            <p class="profile-description"><?= $userData->bio ?></p>
          <?php else: ?>
            <p class="profile-description">O usuário ainda não escreveu nada aqui...</p>
          <?php endif; ?>
        </div>
        <div class="col-md-12 added-books-container">
          <h3>livros que enviou:</h3>
          <div class="books-container">
            <?php foreach($userBooks as $book): ?>
              <?php require("templates/book_card.php"); ?>
            <?php endforeach; ?>
            <?php if(count($userBooks) === 0): ?>
              <p class="empty-list">O usuário ainda não enviou livros.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php
  require_once("templates/footer.php");
?>