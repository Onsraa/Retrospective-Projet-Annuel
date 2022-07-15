<?php

var_dump($_POST);
exit;

$title = 'Admin_users_verif';
include('../includes/logging.php');

if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
{
    header('location: ../admin.php?page=users&msg=Email invalide&type=danger');
    exit;
}

include('../includes/db.php');

$q = 'UPDATE USERS SET email = :email, nickname = :nickname, phone = :phone, first_name = :first_name, last_name = :last_name, birth_date = :birth_date, status = :status, region = :region, gender = :gender, creation_date = :creation_date WHERE id = :id';
$req = $bdd->prepare($q);
$req->execute([
    'email' => (empty($_POST['email'])) ? null : $_POST['email'],
    'nickname' => (empty($_POST['nickname'])) ? null : $_POST['nickname'],
    'phone' => (empty($_POST['phone'])) ? null : $_POST['phone'],
    'first_name' => (empty($_POST['first_name'])) ? null : $_POST['first_name'],
    'last_name' => (empty($_POST['last_name'])) ? null : $_POST['last_name'],
    'birth_date' => (empty($_POST['birth_date'])) ? null : $_POST['birth_date'],
    'status' => (empty($_POST['status'])) ? null : $_POST['status'],
    'region' => (empty($_POST['region'])) ? null : $_POST['region'],
    'gender' => (empty($_POST['gender'])) ? null : $_POST['gender'],
    'creation_date' => (empty($_POST['creation_date'])) ? null : $_POST['creation_date'],
    'id' => $_POST['id']
]);
$results = $req->fetchAll();

header('location: ../admin.php?page=users');

?>