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
    <form action="traitementUser.php" method="POST">
      <h4>Adresse Email :</h4>
      <input class="userInput inputForm" type="email" placeholder="Entrer votre adresse email" name="email" required />
      <h4>Mot de passe :</h4>
      <input class="passwordInput inputForm" type="password" placeholder="Mot de passe" name="password" required />
      <br />
        <input type="hidden" id="recaptchaResponse" name="recaptcha-response">
      <button id="btnSubmitNewUser" class="btn-submit">Valider</button>
    </form>
      <script src="https://www.google.com/recaptcha/api.js?render=6Lcum6IgAAAAAFyux_5a6zWsS3IrqvhRqViNXYSY"></script>
      <script>
          grecaptcha.ready(function() {
              grecaptcha.execute('6Lcum6IgAAAAAFyux_5a6zWsS3IrqvhRqViNXYSY', {action: 'homepage'}).then(function(token) {
                  document.getElementById('recaptchaResponse').value = token
              });
          });
      </script>
  </div>
  <div id="errorMessage"></div>
</body>
<script src="./assets/js/scriptNewUser.js"></script>

</html>