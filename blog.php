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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    <i id="iconAddMore" class="fa-solid fa-plus"></i>
    <button class="addLink" type="submit">
       Ajouter un article
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
      $user = $_SESSION['user'] ?? false;

    if (strlen($title) > 0 && strlen($category) > 0 && strlen($desc) > 0) {

        try {
            require_once 'cnxBdd.php';

            $req = $pdo->prepare('insert into article values (null, :title, :category, :picture, :desc, :user, NOW())');
            $req->execute([
                ':title' => $title,
                ':category' => $category,
                ':picture' => $picture,
                ':desc' => $desc,
                ':user' => $user
            ]);
        } catch
        (PDOException|DomainException $Exception) {
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
      <button class='submitAddNewArticle' type='submit' name="submitArticle">Valider</button>
    </form>
  </div>

  <div id='new-articles'>
    <ul class='ulBlog'>

<?php
require_once 'cnxBdd.php';

$stmt = $pdo->query("select * from article order by id desc");
$result = $stmt->fetchAll();

foreach ($result as $key => $article) {
    if (isset($_POST['submitArticle'])) {
        $originName = $_FILES['picture']['name'];
        $elementsPath = pathinfo($originName);
        $extensionFile = $elementsPath['extension'];
        $extensionAutorised = array("jpg");
        if (!(in_array($extensionFile, $extensionAutorised))) {
            echo "Le fichier n'a pas l'extension attendue";
        } else {
            $folderDestination = dirname(__FILE__) . "/images/{$article['id']}/";
            $nameDestination = "pict" . date("dmYHis") . "." . $extensionFile;
            if (!file_exists($folderDestination)) {
                mkdir($folderDestination, 0777, true);
            }
            move_uploaded_file($_FILES["picture"]["tmp_name"],
                $folderDestination . $nameDestination);
        }
    }
}

    foreach ($result as $key => $article) {
        $dateCreation = new DateTime($article['dateCreation']);
        echo "
          <li>
          <img class='newAddPict' src='./images/{$article['id']}/{$article['picture']}'></img>
          <h6 class='newAddTitle'>{$article['title']}</h6>
          <p class='newCatBlog'>{$article['category']}</p>
          <button class='newAddBtn'>Voir les détails</button>
          <p>Posté le {$dateCreation->format('d/m/Y H:i:s')} par {$article['user']}</p>
          <p class='btnModify'></p>
            <form action='updateArticle.php' method='POST' class='formUpdate'>
              <input type='hidden' name='id' value='{$article['id']}'>
              <button class='btnEditArticle' type='submit' ><i class='fa-solid fa-pencil'></i> Modifier</button>
            </form>
            <form action='deleteArticle.php' method='POST' class='formDelete'>
              <input type='hidden' name='id' value='{$article['id']}'>
              <button class='btnDeleteArticle' type='submit' ><i class='fa-solid fa-x'></i> Supprimer</button>
          </p>
            </form>
          </li>
          ";
}
      ?>
    </ul>
  </div>
</body>
<script src="./assets/js/scriptNewArticle.js"></script>

</html>