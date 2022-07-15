<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require_once('PHPMailer/src/PHPMailer.php');
require_once('PHPMailer/src/Exception.php');
require_once('PHPMailer/src/SMTP.php');

define('EMAIL_RETROSPECTIVE', 'retrospective.esgi@gmail.com');
define('PASSWORD_RETROSPECTIVE', 'kwdlwwgqvrcmcrem');

function sendMail($subject, $message, $altMessage, $to){

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

    $mail->msgHTML($message);
    
    $mail->AltBody = $altMessage;
    
    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }else{
        echo '<h1>Le mail a été envoyé avec succès !</h1>';
    }
}