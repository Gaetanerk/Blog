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
      <a href=""><i class="fa-solid fa-house"></i></a>
    </div>
    <div id="contact">
      <form action="" method="post">
        <h4>Email :</h4>
        <input
          class="contactEmailInput inputForm"
          type="email"
          placeholder="email@email.com"
        />
        <h4>Votre message :</h4>
        <textarea class="messageContact" rows="15" cols="50"></textarea>
        <br />
        <button id="btnSubmitContact" class="btn-submit">Valider</button>
      </form>
    </div>
    <div id="errorMessage"></div>
  </body>
  <script src="./assets/js/scriptContact.js"></script>
</html>