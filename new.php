<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./assets/css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Inscription</title>
</head>

<body id="main">
  <div id="back-main">
    <a href="./index.html"><i class="fa-solid fa-arrow-left-long"></i></a>
  </div>
  <div id="new-user">
    <?php
    $user = $_POST['user'] ?? null;
    $user = htmlspecialchars($user);
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    //on fait qq verif
    if (!is_null($user) && filter_var($email, FILTER_VALIDATE_EMAIL) && !is_null($password)) {

      require_once 'cnxBdd.php';

      $req = $pdo->prepare('insert into user values (null, :user, :email, :password)');
      if ($req->execute([
        ':user' => $user,
        ':email' => $email,
        ':password' => password_hash($password, PASSWORD_ARGON2I)
      ])) {
        echo '
            <div>
              <strong>Bravo!</strong> Compte créer avec succès
              <br>
              <a href="./blog.php"> Accédez au blog </a>
            </div>
            ';
      } else {
        echo '
            <div>
              <strong>Une erreur est survenue lors de la création du compte</strong>
            </div>
            ';
      }
    }
    ?>
    <form action="" method="POST">
      <h4>Nom d'utilisateur :</h4>
      <input class="userInput inputForm" type="text" placeholder="Nom d'utilisateur" name="user" required />
      <h4>Email :</h4>
      <input class="emailInput inputForm" type="email" placeholder="email@email.com" name="email" required />
      <h4>Retaper Email :</h4>
      <input class="emailInput2 inputForm" type="email" placeholder="email@email.com" name="email2" required />
      <h4>Mot de passe :</h4>
      <input class="passwordInput inputForm" type="password" placeholder="Mot de passe" name="password" required />
      <br />
      <button id="btnSubmitNewUser" class="btn-submit">Valider</button>
    </form>
  </div>
  <div id="errorMessage"></div>
</body>
<script src="./assets/js/scriptNewUser.js"></script>

</html>