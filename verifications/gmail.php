<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require_once('PHPMailer/src/PHPMailer.php');
require_once('PHPMailer/src/Exception.php');
require_once('PHPMailer/src/SMTP.php');

define('EMAIL_RETROSPECTIVE', 'retrospective.esgi@gmail.com');
define('PASSWORD_RETROSPECTIVE', 'kwdlwwgqvrcmcrem');

function sendMail($subject, $type, $to, $nickname, $token){

    $mail = new PHPMailer();

    $mail->isSMTP();

    $mail->SMTPDebug = 0;
    
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    
    $mail->SMTPAuth = true;
    
    $mail->Username = EMAIL_RETROSPECTIVE;
    
    $mail->Password = PASSWORD_RETROSPECTIVE;
    
    $mail->setFrom(EMAIL_RETROSPECTIVE, 'Retrospective Company');
    
    $mail->addReplyTo(EMAIL_RETROSPECTIVE);
    
    $mail->addAddress($to);
    
    $mail->Subject = $subject;
    
    $mail -> charSet = "UTF-16"; 

    if($type == 'verification'){

        $mail->msgHTML('
        <head>
        <meta charset="utf-8">
        <title>Email</title>
        <style>

            *{
                box-sizing: border-box;
                padding: 0;
                margin: 0;
            }

            body{
                background-color: #19215E;
            }

            .mail{
                height: 25rem;
                width: 20rem;
                background-color: rgb(216, 216, 216);
                margin: 20vh auto;
                border: none;
                border-radius: 1rem;
                box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
                text-align: center;
                padding: 3rem 4rem;
            }

            .title{
                margin-bottom: 3rem;
                font-size: 2rem;
            }

            .sentence{
                margin-bottom: 2rem;
                font-size: 1.3rem;
            }

            .code{
                font-size: 2.5rem;
                color: #6973c0;
            }
        </style>
    </head>
    <body>
        <main>
            <div class="mail">
                <h1 class="title">Bienvenue ' . $nickname . '</h1>
                <h2 class="sentence">Voici votre code : </h2>
                <h2 class="code">' . $token . '</h2>
            </div>
        </main>
    </body>');
    
    }else if($type == 'password'){
        $mail->msgHTML('
        <head>
        <meta charset="utf-8">
        <title>Email</title>
        <style>

            *{
                box-sizing: border-box;
                padding: 0;
                margin: 0;
            }

            body{
                background-color: #19215E;
            }

            .mail{
                height: 25rem;
                width: 20rem;
                background-color: rgb(216, 216, 216);
                margin: 20vh auto;
                border: none;
                border-radius: 1rem;
                box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
                text-align: center;
                padding: 3rem 4rem;
            }

            .title{
                margin-bottom: 3rem;
                font-size: 2rem;
            }

            .sentence{
                margin-bottom: 1.8rem;
                font-size: 1.1rem;
            }

            .code{
                font-size: 0.8rem;
                color: #6973c0;
            }
        </style>
    </head>
    <body>
        <main>
            <div class="mail">
                <h1 class="title">Coucou ' . $nickname . '</h1>
                <h2 class="sentence">Voici votre lien pour changer de mot de passe : </h2>
                <h2 class="code">' . $token . '</h2>
            </div>
        </main>
    </body>');
    }
    
    $mail->addAttachment('../img/logo.svg');

    
    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }else{
        echo '<h1>Le mail a été envoyé avec succès !</h1>';
    }
}