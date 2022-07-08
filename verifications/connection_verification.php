<?php

    $title = 'Connexion';
    include('../includes/logging.php');

    if(isset($_POST['email']) && !empty($_POST['email'])){
        setcookie('email', $_POST['email'], time() + 3600 * 24);
    }

    if (isset($_POST['email']) && !empty($_POST['email'])) {
        setcookie('email', $_POST['email'], time() + 3600 * 24);
    }

    if (!isset($_POST['email']) || empty($_POST['email']) || !isset($_POST['password']) || empty($_POST['password'])) {
        header('location: ../index.php?message_connection=Veuillez remplir les deux champs.&type=alert');
        exit;
    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        header('location: ../index.php?message_connection=Email invalide.&type=alert');
        exit;
    }

    require('../includes/db.php');

    $q = 'SELECT id FROM users WHERE email = ? AND is_banned = ?';
    $req = $bdd->prepare($q);
    $req->execute([$_POST['email'], 1]);

    $result = $req->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($result)) {
        header('location: ../index.php?message_connection= Le compte associé à cet email est banni.?type=alert');
        exit;
    }



    $salt = '$c53.*?é';
    $salted_password = hash('sha256', $_POST['password'] . $salt);


    $q = 'SELECT email FROM users WHERE email = :email AND password = :password';
    $req = $bdd->prepare($q);
    $req->execute(['email' => $_POST['email'], 'password' => $salted_password]);
    $res = $req->fetch(PDO::FETCH_ASSOC);

    if (empty($res)) {
        header('location: ../index.php?message_connection=Identifiants incorrects.&typeConnection=alert');
        exit;
    }

    $q = 'SELECT id FROM users WHERE email = ? AND status = ?';
    $req = $bdd->prepare($q);
    $req->execute([$_POST['email'], 'not_verified']);
    $result = $req->fetchAll(PDO::FETCH_ASSOC);

if (!empty($result)) {

    $token = rand(222222, 999999);

    $q = 'UPDATE users SET token = ? WHERE email = ?';
    $req = $bdd->prepare($q);
    $result = $req->execute([$token, $_POST['email']]);

    if ($result) {
        require_once('gmail.php');

        $subject = 'Retrospective verification code.';
        $message = '<h1>Voici votre code de vérification : ' . $token . '</h1>';
        $altMessage = 'Voici votre code de vérification : ' . $token;
        $to = $_GET['email'];

        sendMail($subject, $message, $altMessage, $to);
        header('location: ../index.php?message_connection= Le compte associé à cet email n\'a pas été vérifié, un code a été renvoyé.?type=alert?resend=1');
        exit;
    } else {
        header('location: ../index.php?message_connection= Le compte associé à cet email n\'a pas été vérifié, et un mail n\'a pas pu être renvoyé.?type=alert?resend=1');
        exit;
    }
}

session_start();
$_SESSION['email'] = $_POST['email'];
$_SESSION['id'] =  $res['id'];
header('location: ../index.php');
exit;
