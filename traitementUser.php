<?php
// On vérifie que la méthode POST est utilisée
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // On vérifie si le champ "recaptcha-response" contient une valeur
    if (empty($_POST['recaptcha-response'])) {
        header('Location: ./user.php');
    } else {
        // On prépare l'URL
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=6Lcum6IgAAAAALtyfCpbkk8Gnk_Z61jnadTooprr&response={$_POST['recaptcha-response']}";

        // On vérifie si curl est installé
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
            header('Location: user.php');
        } else {
            $data = json_decode($response);
            if ($data->success) {
                if (
                    isset($_POST['email']) && !empty($_POST['email']) &&
                    isset($_POST['password']) && !empty($_POST['password'])
                ) {
                    $email = $_POST['email'] ?? null;
                    $password = $_POST['password'] ?? null;
                    $password = htmlspecialchars($password);

                    if (!is_null($password) && filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
                        require_once 'cnxBdd.php';

                        $stmt = $pdo->prepare("select * from user where email = :email");

                        if ($stmt->execute([
                            ':email' => $email
                        ])) {
                            if ($stmt->rowCount() === 1) {
                                $login = $stmt->fetch();

                                if (password_verify($password, $login['password'])) {
                                    session_start();
                                    $_SESSION['login'] = $login;
                                    header('Location:./blog.php');
                                    exit;
                                } else {
                                    header('Location: user.php');
                                    exit;
                                }
                            } else {
                                throw new Exception('<br>Adresse email ou mot de passe incorrect !');
                            }
                        }
                    }
                }
            } else {
                header('Location: user.php');
            }
        }
    }
} else {
    http_response_code(405);
    echo 'Méthode non autorisée';
}