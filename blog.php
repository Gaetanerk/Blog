<?php
session_start();
if(isset($_SESSION['user'])){
    var_dump($_SESSION);
}
?>

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
      <?php
      $title = $_POST['title'] ?? false;
      $title = htmlspecialchars($title);
      $category = $_POST['category'] ?? false;
      $category = htmlspecialchars($category);
      $picture = "pict".date("dmYHis")."."."jpg" ?? false;
      $desc = $_POST['desc'] ?? false;
      $desc = htmlspecialchars($desc);

      if (strlen($title) > 0 && strlen($category) > 0 && strlen($desc) > 0) {

          try {
              require_once 'cnxBdd.php';

              $req = $pdo->prepare('insert into article values (null, :title, :category, :picture, :desc, NOW())');
              $req->execute([
                  ':title' => $title,
                  ':category' => $category,
                  ':picture' => $picture,
                  ':desc' => $desc
              ]);
              }
          catch
              (PDOException | DomainException $Exception) {
                  echo '
            <div>
              <strong>Erreur!<br>' . $Exception->getMessage() . '</strong>
            </div>
            ';
              }
        };
      ?>
    <form id='addNew' action='' method='POST' enctype='multipart/form-data'>
      <h4>Titre de votre article :</h4>
      <input class='addTitle' type='text' name='title' />
      <h4>Catégorie :</h4>
      <input class='addCat' type='text' name='category' />
      <h4>Choisir une photo :</h4>
      <input type="hidden" name="MAX_FILE_SIZE" value="600000" />
      <input class='addPict' type='file' name='picture' accept='image/jpeg' />
      <br />
      <h4>Décrire votre voyage :</h4>
      <textarea class='addDesc' cols='60' rows='10' name='desc'></textarea>
      <br />
      <button class='submitAddNewArticle' type='submit'>Valider</button>
    </form>
  </div>

  <div id='new-articles'>
    <ul class='ulBlog'>

<?php
require_once 'cnxBdd.php';

$stmt = $pdo->query("select * from article");
$result = $stmt->fetchAll();

$nomOrigine = $_FILES['picture']['name'];
$elementsChemin = pathinfo($nomOrigine);
$extensionFichier = $elementsChemin['extension'];
$extensionsAutorisees = array("jpg");
if (!(in_array($extensionFichier, $extensionsAutorisees))) {
    echo "Le fichier n'a pas l'extension attendue";
} else {
    $repertoireDestination = dirname(__FILE__)."/images/";
    $nomDestination = "pict".date("dmYHis").".".$extensionFichier;

    if (move_uploaded_file($_FILES["picture"]["tmp_name"],
        $repertoireDestination.$nomDestination)) {
        echo "Le fichier temporaire ".$_FILES["picture"]["tmp_name"].
            " a été déplacé vers ".$repertoireDestination.$nomDestination;
    } else {
        echo "Le fichier n'a pas été uploadé (trop gros ?) ou ".
            "Le déplacement du fichier temporaire a échoué".
            " vérifiez l'existence du répertoire ".$repertoireDestination;
    }
}

foreach ($result as $key => $article) {
    $dateCreation = new DateTime($article['dateCreation']);
    echo"
          <li>
          <img class='newAddPict' src='./images/{$article['picture']}'></img>
          <h6 class='newAddTitle'>{$article['title']}</h6>
          <p class='newCatBlog'>{$article['category']}</p>
          <button class='newAddBtn'>Voir les détails</button>
          <p>Posté le {$dateCreation->format('d/m/Y H:i:s')}</p>
          <p>
            <form action='updateArticle.php' method='POST' >
              <input type='hidden' name='id' value='{$article['id']}'>
              <button type='submit' >Modifier</button>
            </form>
            <form action='deleteArticle.php' method='POST' >
              <input type='hidden' name='id' value='{$article['id']}'>
              <button type='submit' >Supprimer</button>
          </p>
            </form>
          </li>
          ";}
      ?>
    </ul>
  </div>
</body>
<script src="./assets/js/scriptNewArticle.js"></script>

</html>