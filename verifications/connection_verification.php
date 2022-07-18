<?php

$title = 'Connexion';
include('../includes/logging.php');

if (isset($_POST['email']) && !empty($_POST['email'])) {
    setcookie('email', $_POST['email'], time() + 3600 * 24);
}

if (!isset($_POST['email']) || empty($_POST['email']) || !isset($_POST['password']) || empty($_POST['password'])) {
    header('location: ../index.php');
    exit;
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    header('location: ../index.php');
    exit;
}

require('../includes/servers/db.php');

$q = 'SELECT id FROM USERS WHERE email = ? AND is_banned = ?';
$req = $bdd->prepare($q);
$req->execute([$_POST['email'], 1]);

$result = $req->fetchAll(PDO::FETCH_ASSOC);

if (!empty($result)) {
    header('location: ../index.php?message_connection=1&type_connection=alert-color');
    exit;
}



$salt = '$c53.*?é';
$salted_password = hash('sha256', $_POST['password'] . $salt);


$q = 'SELECT id FROM USERS WHERE email = :email AND password = :password';
$req = $bdd->prepare($q);
$req->execute(['email' => $_POST['email'], 'password' => $salted_password]);
$result = $req->fetch(PDO::FETCH_ASSOC);

if (empty($result)) {
    header('location: ../index.php?message_connection=2&type_connection=alert-color');
    exit;
}

$q = 'SELECT id, nickname FROM USERS WHERE email = :email AND status = :status';
$req = $bdd->prepare($q);
$req->execute(['email' => $_POST['email'],'status' => 'not_verified']);
$result = $req->fetch(PDO::FETCH_ASSOC);

if (!empty($result)) {

    $token = rand(222222, 999999);

    $q = 'UPDATE USERS SET token = ? WHERE email = ?';
    $req = $bdd->prepare($q);
    $send_status = $req->execute([$token, $_POST['email']]);

    if ($send_status) {

        require_once('gmail.php');

        $subject = 'Retrospective verification code.';
        $type = 'verification';
        $to = $_POST['email'];

        sendMail($subject, $type, $to, $result['nickname'], $token);
        header('location: ../index.php?message_connection=3&type_connection=alert-color&resend=1&email=' . $_POST['email']);
        exit;
    } else {
        header('location: ../index.php?message_connection=4&type_connection=alert-color&resend=1');
        exit;
    }
}

$q = 'SELECT id FROM USERS WHERE email = ?';
$req = $bdd -> prepare($q);
$req -> execute([$_POST['email']]);
$result = $req -> fetch(PDO::FETCH_ASSOC);

session_start();
$_SESSION['email'] = $_POST['email'];
$_SESSION['id'] =  $result['id'];
header('location: ../index.php');
exit;
