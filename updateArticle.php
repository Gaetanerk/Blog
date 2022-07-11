<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un article</title>
    <link rel="stylesheet" href="./assets/css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
          integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<main>
    <h1 class="modTitle">Modifier un article</h1>
    <?php

    try {
        require_once 'cnxBdd.php';

        $id = $_POST['id'] ?? false;
        $id = (int)$id;

        if ($id <= 0) {
            throw new Exception('Erreur lors de la récuperation de l\'article (id)');
        }
        //je prépare ma requet1e
        $req = $pdo->prepare('select *  from article where id = :id');
        // je l'execute avec les parametres necessaire
        $req->execute([
            ':id' => $id
        ]);

        $article = $req->fetch(PDO::FETCH_ASSOC) ?? null;

    } catch (Exception $exception) {
        echo '
            <div>
              <strong>Une erreur est survenue : ' . $exception->getMessage() . '</strong>
            </div>
            ';
    }

    $id = $_POST['id'] ?? null;
    $id = (int)$id;
    $title = $_POST['title'] ?? null;
    $category = $_POST['category'] ?? null;
    $picture = "pict".date("dmYHis")."."."jpg" ?? false;
    $desc = $_POST['desc'] ?? null;
    $login = $_SESSION['login']['login'] ?? false;
    $newPicture = $_POST['picture'] ?? false;

    if (!$newPicture===false) {
        echo "ok not false<br>";
        $stmt = $pdo->query("select * from article order by id desc");
        $result = $stmt->fetchAll();
        if ($article['id'] == $id && $article['login'] == $_SESSION['login']['login']) {
                $file = "./images/{$article['id']}/{$article['picture']}";
                unlink($file);
                $newOriginName = $_FILES['picture']['name'];
                $newElementsPath = pathinfo($newOriginName);
                $newExtensionFile = $newElementsPath['extension'];
                $newExtensionAutorised = array("jpg");
                if (!(in_array($newExtensionFile, $newExtensionAutorised))) {
                    echo "Le fichier n'a pas l'extension attendue";
                } else {
                    $newFolderDestination = dirname(__FILE__) . "/images/{$article['id']}/";
                    $newNameDestination = "pict" . date("dmYHis") . "." . $newExtensionFile;
                    move_uploaded_file($_FILES["picture"]["tmp_name"],
                        $newFolderDestination . $newNameDestination);
                }
                echo 'ok 1';
            }
        }

    if ($title > 0 && $category > 0 && $desc > 0) {
        require_once 'cnxBdd.php';

        $req = $pdo->prepare('update article set title = :title, category =  :category,picture =  :picture, description = :description, login = :login where id = :id');
        $req->execute([
            ':id' => $id,
            ':title' => $title,
            ':category' => $category,
            ':picture' => $picture,
            ':description' => $desc,
            ':login' => $login
        ]);
        echo 'ok 2';
//        header('Location:blog.php');

}

    ?>
    <form id="addNew" action="" method="POST">
        <h4>Titre de votre article :</h4>
        <input class="addTitle" type="text" name="title" value="<?php echo $article['title'] ?>" />
        <h4>Pays :</h4>
        <input class="addCat" type="text" name="category" value="<?php echo $article['category'] ?>" />
        <h4>Choisir une photo :</h4>
        <input type="hidden" name="MAX_FILE_SIZE" value="200000" />
        <input class="addPict" type="file" name="picture" accept="image/jpeg" />
        <br />
        <h4>Décrire votre voyage :</h4>
        <textarea class="addDesc" cols="100" rows="20" name="desc" ><?php echo $article['description'] ?></textarea>
        <br />
        <input type="hidden" name="id" value="<?php echo $article["id"] ?>" >
        <button class="btn-submit" type="upSubmit" >Modifier</button>

    </form>
</main>
</body>
</html>