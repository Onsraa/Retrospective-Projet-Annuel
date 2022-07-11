<?php

$title = 'Connexion';
include('../includes/logging.php');

if (isset($_POST['email']) && !empty($_POST['email'])) {
    setcookie('email', $_POST['email'], time() + 3600 * 24);
}

if (!isset($_POST['email']) || empty($_POST['email']) || !isset($_POST['password']) || empty($_POST['password'])) {
    header('location: ../index.php?message_connection=Veuillez remplir les deux champs.&type_connection=alert');
    exit;
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    header('location: ../index.php?message_connection=Email invalide.&type_connection=alert');
    exit;
}

require('../includes/servers/db.php');

$q = 'SELECT id FROM users WHERE email = ? AND is_banned = ?';
$req = $bdd->prepare($q);
$req->execute([$_POST['email'], 1]);

$result = $req->fetchAll(PDO::FETCH_ASSOC);

if (!empty($result)) {
    header('location: ../index.php?message_connection= Le compte associé à cet email est banni.?type_connection=alert');
    exit;
}



$salt = '$c53.*?é';
$salted_password = hash('sha256', $_POST['password'] . $salt);


$q = 'SELECT id FROM users WHERE email = :email AND password = :password';
$req = $bdd->prepare($q);
$req->execute(['email' => $_POST['email'], 'password' => $salted_password]);
$result = $req->fetch(PDO::FETCH_ASSOC);

if (empty($result)) {
    header('location: ../index.php?message_connection=Identifiants incorrects.&type_connection=alert');
    exit;
}

$q = 'SELECT id FROM users WHERE email = :email AND status = :status';
$req = $bdd->prepare($q);
$req->execute(['email' => $_POST['email'],'status' => 'not_verified']);
$result = $req->fetch(PDO::FETCH_ASSOC);

if (!empty($result)) {

    $token = rand(222222, 999999);

    $q = 'UPDATE users SET token = ? WHERE email = ?';
    $req = $bdd->prepare($q);
    $send_status = $req->execute([$token, $_POST['email']]);

    if ($send_status) {

        require_once('gmail.php');

        $subject = 'Retrospective verification code.';
        $message = '<h1>Voici votre code de vérification : ' . $token . '</h1>';
        $altMessage = 'Voici votre code de vérification : ' . $token;
        $to = $_POST['email'];

        sendMail($subject, $message, $altMessage, $to);
        header('location: ../index.php?message_connection= Le compte associé à cet email n\'a pas été vérifié, un code a été renvoyé.&type_connection=alert&resend=1&email=' . $_POST['email']);
        exit;
    } else {
        header('location: ../index.php?message_connection= Le compte associé à cet email n\'a pas été vérifié, et un mail n\'a pas pu être renvoyé.&type_connection=alert&resend=1');
        exit;
    }
}

session_start();
$_SESSION['email'] = $_POST['email'];
$_SESSION['id'] =  $result['id'];
header('location: ../index.php');
exit;
