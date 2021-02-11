<?php
  require_once("templates/header.php");

  require_once("dao/BookDAO.php");

  // DAO dos livros
  $bookDao = new BookDAO($conn, $BASE_URL);

  $latestBooks = $bookDao->getLatestBooks();

  $fantasyBooks = $bookDao->getBooksByCategory("Fantasia");

  $comedyBooks = $bookDao->getBooksByCategory("Comédia");

?>
  <div id="main-container" class="container-fluid">
    <h2 class="section-title">livros novos</h2>
    <p class="section-description">Veja as críticas dos últimos livros adicionados no scoob</p>
    <div class="books-container">
      <?php foreach($latestBooks as $book): ?>
        <?php require("templates/book_card.php"); ?>
      <?php endforeach; ?>
      <?php if(count($latestBooks) === 0): ?>
        <p class="empty-list">Ainda não há livros cadastrados!</p>
      <?php endif; ?>
    </div>
    <h2 class="section-title">Fantasia / Ficção</h2>
    <p class="section-description">Veja os melhores livros de Fantasia e Ficção</p>
    <div class="books-container">
      <?php foreach($fantasyBooks as $book): ?>
        <?php require("templates/book_card.php"); ?>
      <?php endforeach; ?>
      <?php if(count($fantasyBooks) === 0): ?>
        <p class="empty-list">Ainda não há livros de Fantasia / Ficção cadastrados!</p>
      <?php endif; ?>
    </div>
    <h2 class="section-title">Comédia</h2>
    <p class="section-description">Veja os melhores livros de comédia</p>
    <div class="books-container">
      <?php foreach($comedyBooks as $book): ?>
        <?php require("templates/book_card.php"); ?>
      <?php endforeach; ?>
      <?php if(count($comedyBooks) === 0): ?>
        <p class="empty-list">Ainda não há livros de comédia cadastrados!</p>
      <?php endif; ?>
    </div>
  </div>
<?php
  require_once("templates/footer.php");
?>