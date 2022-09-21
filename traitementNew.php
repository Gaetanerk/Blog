<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['recaptcha-response'])) {
        header('Location: new.php');
    } else {
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=6Lcum6IgAAAAALtyfCpbkk8Gnk_Z61jnadTooprr&response={$_POST['recaptcha-response']}";

        if (function_exists('curl_version')) {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($curl);
        } else {
            $response = file_get_contents($url);
        }

        if (empty($response) || is_null($response)) {
            header('Location: new.php');
        } else {
            $data = json_decode($response);
            if ($data->success) {
                if (
                    isset($_POST['login']) && !empty($_POST['login']) &&
                    isset($_POST['email']) && !empty($_POST['email']) &&
                    isset($_POST['email2']) && !empty($_POST['email2']) &&
                    isset($_POST['password']) && !empty($_POST['password'])

                ) {
                    $login = strip_tags($_POST['login']);
                    $email = strip_tags($_POST['email']);
                    $email2 = strip_tags($_POST['email2']);
                    $password = strip_tags($_POST['password']);

                    $login = $_POST['login'] ?? null;
                    $login = htmlspecialchars($login);
                    $email = $_POST['email'] ?? null;
                    $password = $_POST['password'] ?? null;

//on fait qq verif
                    require_once 'cnxBdd.php';
                    $stmt = $pdo->prepare("SELECT COUNT(*) AS nb FROM user WHERE login=?");
                    $stmt->execute([$login]);
                    $loginbdd = $stmt->fetch();
                    if ($loginbdd['nb'] > 0) {
                        echo "
                        <div>
                        Le nom d'utilisateur existe déjà !!!
                        </br>
                        <a href='new.php'>Retour au formulaire d'inscription</a>
                        </div>";
                    } else {
                        require_once 'cnxBdd.php';
                        $stmt = $pdo->prepare("SELECT COUNT(*) AS nb FROM user WHERE email=?");
                        $stmt->execute([$email]);
                        $emailbdd = $stmt->fetch();
                        if ($emailbdd['nb'] > 0) {
                            echo "
                        <div>
                        L'email existe déjà !!!
                        </br>
                        <a href='new.php'>Retour au formulaire d'inscription</a>
                        </div>";
                        } else {
                            if (!is_null($login) && filter_var($email, FILTER_VALIDATE_EMAIL) && !is_null($password)) {

                                require_once 'cnxBdd.php';

                                $req = $pdo->prepare('insert into user values (null, :login, :email, :password)');
                                if ($req->execute([
                                    ':login' => $login,
                                    ':email' => $email,
                                    ':password' => password_hash($password, PASSWORD_ARGON2I)
                                ])) {
                                    echo "
            <div>
              <strong>Bravo!</strong> Compte {$login} créé avec succès
              <br>
              <a href='./user.php'>Connectez vous</a>
            </div>
            ";
                                } else {
                                    echo '
            <div>
              <strong>Une erreur est survenue lors de la création du compte</strong>
            </div>
            ';
                                }
                            }
                        }
                    }
                } else {
                    header('Location: new.php');
                }
            }
        }
    }
}
else{
        http_response_code(405);
        echo 'Méthode non autorisée';
    }
