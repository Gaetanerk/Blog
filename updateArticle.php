<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./assets/css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
                            integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
                            crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Modifier Article</title>
</head>
<body>
<div>
    <?php

    try {
        require_once 'cnxBdd.php';

        $id = $_POST['id'] ?? null;
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
              <button type="button"></button>
              <strong>Erreur!</strong> <a href="#" >Une erreur est survenue : ' . $exception->getMessage() . '
            </a>
            </div>
            ';
    }


    if (!is_null($title) && !is_null($category) && !is_null($picture) && !is_null($desc)) {

        try {
            require_once 'cnxBdd.php';



            echo '
            <div>
              <strong>Bravo!</strong> Article modifier avec succès 
              <a href="blog.php" > Voir le blog </a>.
            </div>
            ';

//        } catch (Exception $Exception){
        } catch (PDOException|DomainException $Exception) {
            echo '
            <div>
              <strong>Erreur!</strong> <a href="#" >Une erreur est survenue : ' . $Exception->getMessage() . '
            </a>
            </div>
            ';
        }
    }

    ?>

</body>
</html>







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
    <h1>Modifier un article</h1>
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
            <div class="alert alert-dismissible alert-danger">
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              <strong>Erreur!</strong> <a href="#" class="alert-link">Une erreur est survenue : ' . $exception->getMessage() . '
            </a> and try submitting again.
            </div>
            ';
    }

    //on récupere les info du formulaire
    $id = $_POST['id'] ?? null;
    $id = (int)$id;
    $title = $_POST['title'] ?? null;
    $category = $_POST['category'] ?? null;
    $picture = $_POST['picture'] ?? null;
    $desc = $_POST['desc'] ?? null;

    if (strlen($title) > 0 && $category > 0 && $desc > 0) {

        try {
            require_once 'cnxBdd.php';

            $req = $pdo->prepare('update article set title = :title, category = :category, picture = :picture, desc = :desc where id = :id');
            $req->execute([
                ':id' => $id,
                ':title' => $title,
                ':category' => $category,
                ':picture' => $picture,
                ':desc' => $desc,
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
        <input class="addTitle" type="text" name="title" />
        <h4>Catégorie :</h4>
        <input class="addCat" type="text" name="category" />
        <h4>Choisir une photo :</h4>
        <input class="addPict" type="file" name="picture" accept="image/jpeg" />
        <br />
        <h4>Décrire votre voyage :</h4>
        <textarea class="addDesc" cols="100" rows="20" name="desc"></textarea>
        <br />
        <input type="hidden" name="id" value="<?php echo $article["id"] ?>">
        <button type="submit" >Modifier</button>

    </form>
</main>
</body>
</html>