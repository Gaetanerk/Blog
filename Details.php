<?php
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./assets/css/style.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
          integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>Détails</title>
</head>
<body>

<?php
require_once 'cnxBdd.php';

$id = $_POST['idArticle'];
$id = (int)$id;

if ($id <= 0) {
    $req = $pdo->query('select * from article where id = :id');
    $req->execute([
        ':id' => $id
    ]);
}

$stmt = $pdo->query("select * from article order by id");
$result = $stmt->fetchAll();

foreach ($result as $key => $article) {
    if ($id == $article['id']) {
        echo "
        <div id='back-main'>
            <a href='./blog.php'><i class='fa-solid fa-arrow-left-long'></i></a>
        </div>
        <div class='detail'>
            <img class='detailPict' src='./images/{$article['id']}/{$article['picture']}'></img>
            <h6 class='detailTitle'>{$article['title']}</h6>
            <p class='detailCategory'>{$article['category']}</p>
            <p class='detailDescription'>{$article['description']}</p>
        </div>";
    }
}
?>
</body>
</html>