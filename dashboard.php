<?php
  require_once("templates/header.php");

  // Verifica se usuário está autenticado
  require_once("models/User.php");
  require_once("dao/UserDAO.php");
  require_once("dao/BookDAO.php");

  $user = new User();
  $userDao = new UserDao($conn, $BASE_URL);
  $bookDao = new BookDAO($conn, $BASE_URL);

  $userData = $userDao->verifyToken(true);

  $userBooks = $bookDao->getBooksByUserId($userData->id);

?>
  <div id="main-container" class="container-fluid">
    <h2 class="section-title">Dashboard</h2>
    <p class="section-description">Adicione ou atualize as informações dos livros que você enviou</p>
    <div class="col-md-12" id="add-book-container">
      <a href="<?= $BASE_URL ?>newbook.php" class="btn card-btn">
        <i class="fas fa-plus"></i> Adicionar Livro
      </a>
    </div>
    <div class="col-md-12" id="books-dashboard">
      <table class="table">
        <thead>
          <th scope="col">#</th>
          <th scope="col">Título</th>
          <th scope="col">Nota</th>
          <th scope="col" class="actions-column">Ações</th>
        </thead>
        <tbody>
          <?php foreach($userBooks as $book): ?>
          <tr>
            <td scope="row"><?= $book->id ?></td>
            <td><a href="<?= $BASE_URL ?>book.php?id=<?= $book->id ?>" class="table-book-title"><?= $book->title ?></a></td>
            <td><i class="fas fa-star"></i> <?= $book->rating ?></td>
            <td class="actions-column">
              <a href="<?= $BASE_URL ?>editbook.php?id=<?= $book->id ?>" class="edit-btn">
                <i class="far fa-edit"></i> Editar
              </a>
              <form action="<?= $BASE_URL ?>book_process.php" method="POST">
                <input type="hidden" name="type" value="delete">
                <input type="hidden" name="id" value="<?= $book->id ?>">
                <button type="submit" class="delete-btn">
                  <i class="fas fa-times"></i> Deletar
                </button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
<?php
  require_once("templates/footer.php");
?>