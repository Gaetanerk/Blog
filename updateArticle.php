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
              <button type="button" ></button>
              <strong>Une erreur est survenue : ' . $exception->getMessage() . '</strong>
            </div>
            ';
    }

        $id = $_POST['id'] ?? null;
        $id = (int)$id;
        $title = $_POST['uptitle'] ?? null;
        $category = $_POST['upcategory'] ?? null;
        $picture = $_POST['uppicture'] ?? null;
        $description = $_POST['updesc'] ?? null;
        $login = $_SESSION['login']['login'] ?? false;


    if (isset($title) && isset($category) && isset($description)) {
        require_once 'cnxBdd.php';

        $req = $pdo->prepare('update article set title = :title, category = :category, picture = :picture, description = :description, login = :login where id = :id');
                $req->execute([
                    ':title' => $title,
                    ':category' => $category,
                    ':picture' => $picture,
                    ':description' => $description,
                    ':login' => $login,
                    ':id' => $id
                ]);
                header('location:blog.php');
        }
    ?>
    <form id="addNew" action="" method="POST">
        <h4>Titre de votre article :</h4>
        <input class="addTitle" type="text" name="uptitle" value="<?php echo $article['title'] ?>" />
        <h4>Catégorie :</h4>
        <input class="addCat" type="text" name="upcategory" value="<?php echo $article['category'] ?>" />
        <h4>Choisir une photo :</h4>
        <input class="addPict" type="file" name="uppicture" accept="image/jpeg" />
        <br />
        <h4>Décrire votre voyage :</h4>
        <textarea class="addDesc" cols="80" rows="20" name="updesc" ><?php echo $article['description'] ?></textarea>
        <br />
        <input type="hidden" name="id" value="<?php echo $article["id"] ?>" >
        <button class="btn-submit" type="submit" >Modifier</button>
    </form>
</main>
</body>
</html>