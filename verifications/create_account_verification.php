<?php

$title = 'Inscription';
include('../includes/logging.php');

if (isset($_POST['nickname']) && !empty($_POST['nickname'])) {
    setcookie('nickname', $_POST['nickname'], time() + 3600 * 24);
}

if (isset($_POST['email']) && !empty($_POST['email'])) {
    setcookie('email', $_POST['email'], time() + 3600 * 24);
}

if (!isset($_POST['email']) || empty($_POST['email']) || !isset($_POST['password']) || empty($_POST['password'])) {
    header('location: ../index.php?'); //error 1 : Veuillez remplir les deux champs.
    exit;
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    header('location: ../index.php'); //error 2 : Email invalide.
    exit;
}

$pwdVerif =  "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{5,}$/";


if(!preg_match($pwdVerif, $_POST['password'])){
    header('location: ../index.php?');
    exit;
}



if($_POST['password'] != $_POST['repassword']){
    header('location: ../index.php?');
    exit;
}

require('../includes/servers/db.php');

$q = 'SELECT id FROM USERS WHERE email = ? AND is_banned = ?';
$req = $bdd -> prepare($q);
$req -> execute([$_POST['email'],1]);

$result = $req -> fetchAll(PDO::FETCH_ASSOC);

if(!empty($result)){
    header('location: ../index.php?message_createAccount=1.?type_createAccount=alert-color');
    exit;
}

$q = 'SELECT id FROM USERS WHERE email = ?';
$req = $bdd->prepare($q);
$req->execute([$_POST['email']]);
$result = $req->fetchAll(PDO::FETCH_ASSOC);

if (!empty($result)) {
    header('location: ../index.php?message_createAccount=2.&type_createAccount=alert-color');
    exit;
}

$q = 'SELECT id FROM USERS WHERE nickname = ?';
$req = $bdd->prepare($q);
$req->execute([$_POST['nickname']]);
$result = $req->fetch(PDO::FETCH_ASSOC);

if (!empty($result)) {
    header('location: ../index.php?message_createAccount=3.&type_createAccount=alert-color');
    exit;
}

?>