<?php

// On vérifie que la méthode POST est utilisée
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // On vérifie si le champ "recaptcha-response" contient une valeur
    if(empty($_POST['recaptcha-response'])){
        header('Location: contact.php');
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
            header('Location: contact.php');
        }else{
            $data = json_decode($response);
            if($data->success){
                if(
                    isset($_POST['name']) && !empty($_POST['name']) &&
                    isset($_POST['email']) && !empty($_POST['email']) &&
                    isset($_POST['sujet']) && !empty($_POST['sujet']) &&
                    isset($_POST['message']) && !empty($_POST['message'])
                ){
                    // On nettoie le contenu
                    $email = strip_tags($_POST['name']);
                    $email = strip_tags($_POST['email']);
                    $sujet = strip_tags($_POST['sujet']);
                    $message = htmlspecialchars($_POST['message']);

                    // Ici vous traitez vos données

                    echo "<div class='echoValid'>Message de {$email} envoyé 
                    <br>
                    <a href='./blog.php' style='text-decoration: none'>Retour au blog</a></div>";
                }
            }else{
                header('Location: contact.php');
            }
        }
    }
}else{
    http_response_code(405);
    echo 'Méthode non autorisée';
}


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = SMTP::DEBUG_OFF;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'gaetan.turben@gmail.com';
    $mail->Password = 'wuurcdbbanyoqxbw';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom("{$_POST['email']}", "{$_POST['name']}");
    $mail->addAddress('gaetan.turben@outlook.com', 'Gaetan Turben');

    $mail->isHTML(true);
    $mail->Subject = "{$_POST['sujet']}";
    $mail->Body = "{$_POST['message']}";
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
