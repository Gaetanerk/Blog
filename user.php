<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./assets/css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Connexion</title>
</head>

<body id="main">
  <div id="back-main">
    <a href="./index.html"><i class="fa-solid fa-arrow-left-long"></i></a>
  </div>
  <div id="new-user">
    <?php

    try {
      $email = $_POST['email'] ?? null;
      $mdp = $_POST['password'] ?? null;
      $mdp = htmlspecialchars($mdp);

      if (!is_null($mdp) && filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
        require_once 'cnxBdd.php';

        $stmt = $pdo->prepare("select * from user where email = :email");

        if ($stmt->execute([
          ':email' => $email
        ])) {
          if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch();

            if (password_verify($mdp, $user['password'])) {
              session_start();
              $_SESSION['user'] = $user;

              echo '
            <div>
              <strong>Bravo!</strong> Connecté avec succès
              <br>
              <a href="blog.php" > Accèder au blog  </a>.
            </div>
            ';
            }
          } else {
            throw new Exception('<br>Adresse email ou mot de passe incorrect !');
          }
        }
      }
    } catch (PDOException | Exception $Exception) {
      echo '
            <div>
              <strong>Erreur!</strong> ' . $Exception->getMessage() . '
            </div>
            ';
    }

    ?>
    <form action="" method="POST">
      <h4>Adresse Email :</h4>
      <input class="userInput inputForm" type="text" placeholder="Entrer votre adresse email" name="email" required />
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