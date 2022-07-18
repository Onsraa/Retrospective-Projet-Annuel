<?php

$title = 'New password';
include('../logging.php');


if (!isset($_POST['email']) || empty($_POST['email'])) {
    echo '<h1 class="passwordAccountTitle-el">Récupération de mot de passe</h1>';
    echo '<p class="alert-password">Veuillez entrer un mail.</p>';
    exit;
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    echo '<h1 class="passwordAccountTitle-el">Récupération de mot de passe</h1>';
    echo '<p class="alert-password">Email invalide.</p>';
    exit;
}

require("../servers/db.php");

$q = 'SELECT id FROM USERS WHERE email = ?';
$req = $bdd -> prepare($q);
$req -> execute([$_POST['email']]);
$result = $req -> fetch(PDO::FETCH_ASSOC);

if(empty($result)){
    echo '<h1 class="passwordAccountTitle-el">Récupération de mot de passe</h1>';
    echo '<p class="alert-password">Compte inexistant.</p>';
    exit;
}

$q = 'SELECT id FROM USERS WHERE email = ? && is_banned = ?';
$req = $bdd -> prepare($q);
$req -> execute([$_POST['email'], 1]);
$result = $req -> fetch(PDO::FETCH_ASSOC);

if(!empty($result)){
    echo '<h1 class="passwordAccountTitle-el">Récupération de mot de passe</h1>';
    echo '<p class="alert-password">Compte banni.</p>';
    exit;
}

$q = 'SELECT id FROM USERS WHERE email = ? && token != ? && status = ?';
$req = $bdd -> prepare($q);
$req -> execute([$_POST['email'], null, 'not_verified']);
$result = $req -> fetch(PDO::FETCH_ASSOC);

if(!empty($result)){
    echo '<h1 class="passwordAccountTitle-el">Récupération de mot de passe</h1>';
    echo '<p class="alert-password">Compte non vérifié. Pensez à le vérifier en vous connectant une première fois.</p>';
    exit;
}

do{
    $str=rand();
    $random_token = md5($str);

    $q = 'SELECT id FROM USERS WHERE token = ?';
    $req = $bdd -> prepare($q);
    $req -> execute([$random_token]);
    $result = $req -> fetch(PDO::FETCH_ASSOC);

}while(!empty($result));


$q = 'UPDATE USERS SET token = ? WHERE email = ?';
$req = $bdd -> prepare($q);
$verify = $req -> execute([$random_token, $_POST['email']]);

$q = 'SELECT nickname FROM USERS WHERE email = ?';
$req = $bdd -> prepare($q);
$req -> execute([$_POST['email']]);
$result = $req -> fetch(PDO::FETCH_ASSOC);

if($verify){

    require("../../verifications/gmail.php");

    $subject = 'Retrospective change password link.';
    $type = 'password';
    $to = $_POST['email'];

    $generate_link = "http://localhost/Projet%20annuel%20RETROSPECTIVE%20FULL/change_password.php?q=" . $random_token;

    sendMail($subject, $type, $to, $result['nickname'], $generate_link);
    echo '<p class="success-password">Courez chercher votre lien !</p>';
    exit;
}else{
    echo '<h1 class="passwordAccountTitle-el">Récupération de mot de passe</h1>';
    echo '<p class="alert-password">Le lien n\'a pas pu être renvoyé à votre mail.</p>';
    exit;
}




?>
