<?php
session_start();
if(isset($_SESSION['user'])){
    var_dump($_SESSION);
}
?>

<?php

try {
    require_once 'cnxBdd.php';

    //je recupere l'id posté
    $id = $_POST['id'] ?? false;
    $id = (int)$id;

    $stmt = $pdo->query('select * from article');
    $result = $stmt->fetchAll();


    //si il n'est pas valide, je declenche une erreur (met fin a l'execution)
    if ($id <= 0) {
        throw new Exception('Erreur lors de la suppression de l\'article (id)');
}

    //je prépare ma requete
    $req = $pdo->prepare('delete from article where id = :id');
    // je l'execute avec les parametres necessaire
    $req->execute([
        ':id' => $id
    ]);
    foreach ($result as $key => $article) {
        if ($article['id'] == $id) {
            $file = "./images/{$article['id']}/{$article['picture']}";
                if(file_exists($file)) {
                    unlink($file);
                    rmdir("./images/{$article['id']}");
                }
        }
    }

    echo '
            <form action="" method="post">
              <strong>Bravo! Article supprimé avec succès !</strong>
              <br>
              <a href="./blog.php">Retour au blog</a>
            </form>
            ';

} catch (Exception $exception) {
    echo '
            <form action="" method="post">
              <strong>Une erreur est survenue : ' . $exception->getMessage() . '</strong>
              <br>
              <a href="./blog.php">Retour au blog</a>
            </form>
            ';
}