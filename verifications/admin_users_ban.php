<?php

include('../includes/db.php');

$q = 'UPDATE USERS SET is_banned = 1 WHERE id = ?';
$req = $bdd->prepare($q);
$req->execute([$_POST['id']]);

var_dump($req);
var_dump($_POST['id']);

header('location: ../admin.php?page=users');
?>