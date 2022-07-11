<?php

$title = 'Inscription';
include('../includes/logging.php');

if (isset($_POST['nickname']) && !empty($_POST['nickname'])) {
    setcookie('nickname', $_POST['nickname'], time() + 3600 * 24);
}

if (isset($_POST['email']) && !empty($_POST['email'])) {
    setcookie('email', $_POST['email'], time() + 3600 * 24);
}

if (isset($_POST['nickname']) && !empty($_POST['nickname'])) {
    setcookie('nickname', $_POST['nickname'], time() + 3600 * 24);
}

if (!isset($_POST['email']) || empty($_POST['email']) || !isset($_POST['password']) || empty($_POST['password'])) {
    header('location: ../index.php?message_createAccount=Veuillez remplir les deux champs.&type_createAccount=alert');
    exit;
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    header('location: ../index.php?message_createAccount=Email invalide.&type_createAccount=alert');
    exit;
}

if (strlen($_POST['password']) < 5 || !preg_match('/[A-Z]/', $_POST['password']) || !preg_match('/[0-9]/', $_POST['password'])) {
    header('location: ../index.php?message_createAccount=Veuillez entrer un mot de passe avec au moins 8 caractères dont une majuscule, une minuscule et un chiffre.&type_createAccount=alert');
    exit;
}

if($_POST['password'] != $_POST['repassword']){
    header('location: ../index.php?message_createAccount=Les mots de passe ne sont pas identiques.&type_createAccount=alert');
    exit;
}


require('../includes/servers/db.php');

$q = 'SELECT id FROM users WHERE email = ? AND is_banned = ?';
$req = $bdd -> prepare($q);
$req -> execute([$_POST['email'],1]);

$result = $req -> fetchAll(PDO::FETCH_ASSOC);

if(!empty($result)){
    header('location: ../index.php?message_createAccount=Le compte associé à cet email est banni.?type_createAccount=alert');
    exit;
}

$q = 'SELECT id FROM users WHERE email = ?';
$req = $bdd->prepare($q);
$req->execute([$_POST['email']]);
$result = $req->fetchAll(PDO::FETCH_ASSOC);

if (!empty($result)) {
    header('location: ../index.php?message_createAccount=Email déjà utilisé.&type_createAccount=alert');
    exit;
}

$q = 'SELECT id FROM users WHERE nickname = ?';
$req = $bdd->prepare($q);
$req->execute([$_POST['nickname']]);
$result = $req->fetch(PDO::FETCH_ASSOC);

if (!empty($result)) {
    header('location: ../index.php?message_createAccount=Pseudo déjà utilisé.&type_createAccount=alert');
    exit;
}

?>