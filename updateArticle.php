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
              <button type="button" ></button>
              <strong>Une erreur est survenue : ' . $exception->getMessage() . '</strong>
            </div>
            ';
    }

    $id = $_POST['id'] ?? null;
    $id = (int)$id;
    $title = $_POST['title'] ?? null;
    $category = $_POST['category'] ?? null;
    $picture = $_POST['picture'] ?? null;
    $desc = $_POST['desc'] ?? null;
    $user = $_SESSION['user'] ?? false;
    $user = htmlspecialchars($user);

    if (strlen($title) > 0 && $category > 0 && $desc > 0) {

        try {
            require_once 'cnxBdd.php';

            $req = $pdo->prepare('update article set null, :title, :category, :picture, :desc, :user, NOW()');
            $req->execute([
                ':title' => $title,
                ':category' => $category,
                ':picture' => $picture,
                ':desc' => $desc,
                ':user' => $user
            ]);

            echo '
            <div>
              <strong>Bravo!</strong> Article modifié avec succès 
              <a href="blog.php" > Voir le blog </a>.
            </div>
            ';

//        } catch (Exception $Exception){
        } catch (PDOException|DomainException $Exception) {
            echo '
            <div>
              <button type="button" ></button>
              <strong>Erreur!</strong> <a href="#" >Une erreur est survenue : ' . $Exception->getMessage() . '
            </a>
            </div>
            ';
        }
    }

    ?>
    <form id="addNew" action="" method="POST">
        <h4>Titre de votre article :</h4>
        <input class="addTitle" type="text" name="title" value="<?php echo $article['title'] ?>" />
        <h4>Catégorie :</h4>
        <input class="addCat" type="text" name="category" value="<?php echo $article['category'] ?>" />
        <h4>Choisir une photo :</h4>
        <input class="addPict" type="file" name="picture" accept="image/jpeg" />
        <br />
        <h4>Décrire votre voyage :</h4>
        <textarea class="addDesc" cols="100" rows="20" name="desc" value="<?php echo $article['desc'] ?>" ></textarea>
        <br />
        <input type="hidden" name="id" value="<?php echo $article["id"] ?>" >
        <button class="btn-submit" type="submit" >Modifier</button>

    </form>
</main>
</body>
</html>