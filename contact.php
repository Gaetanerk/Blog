<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./assets/css/style.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
      integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <title>Contact</title>
  </head>
  <body>
    <div id="navBlog">
      <a href="./blog.php"><i class="fa-solid fa-house"></i></a>
    </div>
    <div id="contact">
      <form action="traitementContact.php" method="post">
        <h4>Votre nom :</h4>
        <input type="text" name="name">
        <h4>Email :</h4>
        <input
          class="contactEmailInput inputForm"
          type="email"
          placeholder="email@email.com"
          name="email"
        />
        <h4>Sujet :</h4>
        <input type="text" name="sujet">
        <h4>Votre message :</h4>
        <textarea class="messageContact" rows="15" cols="50" name="message"></textarea>
        <br />
          <input type="hidden" id="recaptchaResponse" name="recaptcha-response">
        <button id="btnSubmitContact" class="btn-submit">Envoyer</button>
      </form>
    </div>

    <script src="https://www.google.com/recaptcha/api.js?render=6Lcum6IgAAAAAFyux_5a6zWsS3IrqvhRqViNXYSY"></script>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('6Lcum6IgAAAAAFyux_5a6zWsS3IrqvhRqViNXYSY', {action: 'homepage'}).then(function(token) {
                document.getElementById('recaptchaResponse').value = token
            });
        });
    </script>

    <div id="errorMessage"></div>
  </body>
  <script src="./assets/js/scriptContact.js"></script>
</html>
