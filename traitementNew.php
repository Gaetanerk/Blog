<?php

// On vérifie que la méthode POST est utilisée
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // On vérifie si le champ "recaptcha-response" contient une valeur
    if(empty($_POST['recaptcha-response'])){
        header('Location: new.php');
    }else{
        // On prépare l'URL
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=6Lcum6IgAAAAALtyfCpbkk8Gnk_Z61jnadTooprr&response={$_POST['recaptcha-response']}";

        // On vérifie si curl est installé
        if(function_exists('curl_version')){
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($curl);
        }else{
            // On utilisera file_get_contents
            $response = file_get_contents($url);
        }

        // On vérifie qu'on a une réponse
        if(empty($response) || is_null($response)){
            header('Location: new.php');
        }else{
            $data = json_decode($response);
            if($data->success){
                if(
                    isset($_POST['userName']) && !empty($_POST['userName']) &&
                    isset($_POST['email']) && !empty($_POST['email']) &&
                    isset($_POST['email2']) && !empty($_POST['email2']) &&
                    isset($_POST['password']) && !empty($_POST['password'])
                ){
                    // On nettoie le contenu
                    $userName = strip_tags($_POST['userName']);
                    $email = strip_tags($_POST['email']);
                    $email2 = strip_tags($_POST['email2']);
                    $password = strip_tags($_POST['password']);

                    // Ici vous traitez vos données
                    $userName = $_POST['userName'] ?? null;
                    $userName = htmlspecialchars($userName);
                    $email = $_POST['email'] ?? null;
                    $password = $_POST['password'] ?? null;

//on fait qq verif
                    if (!is_null($userName) && filter_var($email, FILTER_VALIDATE_EMAIL) && !is_null($password)) {

                        require_once 'cnxBdd.php';

                        $req = $pdo->prepare('insert into user values (null, :user, :email, :password)');
                        if ($req->execute([
                            ':user' => $userName,
                            ':email' => $email,
                            ':password' => password_hash($password, PASSWORD_ARGON2I)
                        ])) {
                            echo "
            <div>
              <strong>Bravo!</strong> Compte {$userName} créé avec succès
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
            }else{
                header('Location: new.php');
            }
        }
    }
}else{
    http_response_code(405);
    echo 'Méthode non autorisée';
}