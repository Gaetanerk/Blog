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
        $req = $pdo->prepare('select *  from article where id = :id');
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
    ?>
    <form id="addNew" action="" method="POST" enctype="multipart/form-data">
        <h4>Titre de votre article :</h4>
        <input class="addTitle" type="text" name="title" value="<?php echo $article['title'] ?>"/>
        <h4>Pays :</h4>
        <input class="addCat" type="text" name="category" value="<?php echo $article['category'] ?>"/>
        <h4>Choisir une photo :</h4>
        <input type="hidden" name="MAX_FILE_SIZE" value="200000" />
        <input class="addPict" type="file" name="newPicture" accept="image/jpeg"/>
        <br />
        <h4>Décrire votre voyage :</h4>
        <textarea class="addDesc" cols="100" rows="20" name="desc" ><?php echo $article['description'] ?></textarea>
        <br />
        <input type="hidden" name="id" value="<?php echo $article["id"] ?>" >
        <button class="btn-submit" type="upSubmit" >Modifier</button>
    </form>
    <?php
    require_once 'cnxBdd.php';

    $id = $_POST['id'] ?? null;
    $id = (int)$id;
    $title = $_POST['title'] ?? null;
    $category = $_POST['category'] ?? null;
    $picture = $article['picture'] ?? null;
    $desc = $_POST['desc'] ?? null;
    $login = $_SESSION['login']['login'] ?? false;
    $newPicture = $_FILES['newPicture'] ?? false;

    if ($newPicture!==false) {
        $picture = "pict".date("dmYHis")."."."jpg";
        $stmt = $pdo->query("select * from article order by id desc");
        $result = $stmt->fetchAll();
        foreach ($result as $key => $article){
            if ($article['id'] === $id && $article['login'] === $_SESSION['login']['login']) {
                    $file = "./images/{$article['id']}/{$article['picture']}";
                    unlink($file);
                    $originName = $_FILES['newPicture']['name'];
                    $elementsPath = pathinfo($originName);
                    $extensionFile = $elementsPath['extension'];
                    $extensionAutorised = array("jpg");
                    if (!(in_array($extensionFile, $extensionAutorised))) {
                        echo "Le fichier n'a pas l'extension attendue";
                    } else {
                        $folderDestination = dirname(__FILE__) . "/images/{$article['id']}/";
                        $nameDestination = "pict" . date("dmYHis") . "." . $extensionFile;
                        move_uploaded_file($_FILES["newPicture"]["tmp_name"],
                            $folderDestination . $nameDestination);
                    }
                }
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

        header('Location:blog.php');
    }
    ?>
</main>
</body>
</html>