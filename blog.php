<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./assets/css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Mon Blog</title>
</head>

<body id="bodyBlog">
  <div id="navBlog">
    <a href="https://facebook.com"><i class="fa-brands fa-facebook-f"></i></a>
    <a href="https://twitter.com"><i class="fa-brands fa-twitter"></i></a>
    <a href="./contact.php"><i class="fa-solid fa-envelope"></i></a>
    <a href="./index.html"><i class="fa-solid fa-power-off"></i></a>
  </div>
  <div id="blogTitle">
    <h3>Blog Voyageur</h3>
  </div>
  <div id="lignGreen"></div>
  <div id="addArticle">
    <button class="addLink" type="submit">
      <i class="fa-solid fa-plus"></i> Ajouter un article
    </button>
  </div>
  <div id="lignGreen"></div>
  <div id="addPost">
    <form id="addNew" action="" method="POST">
      <h4>Titre de votre article :</h4>
      <input class="addTitle" type="text" name="title" />
      <h4>Catégorie :</h4>
      <input class="addCat" type="text" name="category" />
      <h4>Choisir une photo :</h4>
      <input class="addPict" type="file" name="picture" accept="image/jpeg" />
      <br />
      <h4>Décrire votre voyage :</h4>
      <textarea class="addDesc" cols="100" rows="20" name="desc"></textarea>
      <br />
      <button class="submitAddNewArticle" type="submit">Valider</button>
      <button class="cancelAddNewArticle" type="submit">Annuler</button>
    </form>
  </div>
  <div id="new-articles">
    <ul class="ulBlog">

      <?php
      $title = $_POST['title'] ?? false;
      $title = htmlspecialchars($title);
      $category = $_POST['category'] ?? false;
      $category = htmlspecialchars($category);
      $picture = $_POST['picture'] ?? false;
      $desc = $_POST['desc'] ?? false;
      $desc = htmlspecialchars($desc);
      $dateCreation = new DateTime($article['dateCreation']);

      if (strlen($title) > 0 && strlen($category) > 0 && strlen($desc) > 0) {

        require_once 'cnxBdd.php';

        $req = $pdo->prepare('insert into article values (null, :title, :category, :picture, :desc, NOW() )');
        if ($req->execute([
          ':title' => $title,
          ':category' => $category,
          ':picture' => $picture,
          ':desc' => $desc
        ])) {
          echo '
          <li>
          <img class="newAddPict">{$article["picture"]}</img>
          <h6 class="newAddTitle">{$article["title"]}</h6>
          <p class="newCatBlog">{$article["category"]}</p>
          <button class="newAddBtn">Voir les détails</button>
          <p class="newAaddDesc">{$article["description"]}</p>
          <p>{$dateCreation->format("d/m/Y H:i:s")}</p>
          <p>
            <form action="updateArticle.php" method="post" >
              <input type="hidden" name="id" value="{$article["id"]}">
              <button type="submit" >Modifier</button>
            </form>
            <form action="deleteArticle.php" method="post" >
              <input type="hidden" name="id" value="{$article["id"]}">
              <button type="submit" >Supprimer</button>
            </form>
          </p>
          </li>';
        } else {
          echo '
          <div class="alert alert-dismissible alert-danger">
          <button type="button" data-bs-dismiss="alert"></button>
          <strong>Erreur!</strong> <a href="#" >Une erreur est survenue lors de la création de l\'article
          </a> and try submitting again.
          </div>
          ';
        }
      }
      ?>
    </ul>
  </div>
</body>
<script src="./assets/js/scriptNewArticle.js"></script>

</html>