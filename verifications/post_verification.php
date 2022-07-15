<?php

session_start();

if( !isset($_POST['title']) || empty($_POST['content']) || !isset($_POST['content']) || empty($_POST['title'])) {
  header('location:../lounge.php?message_post=Veuillez remplir les champs obligatoires&type_post=alert-color');
  exit;
}

if(
  $_POST['category'] !== 'gaming' &&
  $_POST['category'] !== 'fun' &&
  $_POST['category'] !== 'chat' &&
  $_POST['category'] !== 'other'){
  header('location:../lounge.php?message_post=Erreur au niveau de la catégorie du post.&type_post=alert-color');
  exit;
  }

if($_FILES['image']['error'] == 0){
      $acceptable = [
      				'image/jpeg',
      				'image/png'
      			];

      if(!in_array($_FILES['image']['type'], $acceptable)){
      	header('location:../lounge.php?message_post=Type de fichier incorrect.&type_post=alert-color');
      	exit;
      }

      $maxSize = 2 * 1024 * 1024; // 2Mo
      if($_FILES['image']['size'] > $maxSize){
        header('location:../lounge.php?message_post=Fichier trop lourd (2Mo max).&type_post=alert-color');
        exit;
      }

      $chemin = '../uploads/post';
      if(!file_exists($chemin)){
        mkdir($chemin);
      }

      $array = explode('.', $_FILES['image']['name']);
      $extension = end($array);
      $filename = time() . '.' . $extension;
      $destination = $chemin . '/post-' . $filename;
      move_uploaded_file($_FILES['image']['tmp_name'], $destination);

}else{
  $filename = 'default.png';
}

if(strlen($_POST['content']) > 400){
  header('location:../lounge.php?message_post=Vous avez trop écrit.. au maximum 400 caractères, petit(e) bavard(e).&type_post=alert-color');
  exit;
} 

require("../includes/servers/db.php");

$q ='INSERT INTO POST(title, date, user, content, category) VALUES (:title, CURRENT_DATE(), :user, :content, :category)';
$req = $bdd -> prepare($q);
$result = $req -> execute([
  'title' => $_POST['title'],
  'user' => $_SESSION['id'],
  'content' => $_POST['content'],
  'category' => $_POST['category']
]);

if(!$result){
  header('location:../lounge.php?message_post=Une erreur a eu lieu lors de l\'envoi, ressayez plus tard.&type_post=alert-color');
  exit;
}

$q = 'SELECT MAX(id) as max FROM POST';
$req = $bdd -> query($q);
$last_post = $req -> fetch(PDO::FETCH_ASSOC);

$q = 'INSERT INTO MEDIA_POST(src, post) VALUES(:src, :post)';
$req = $bdd -> prepare($q);
$result = $req -> execute([
  'src' => $filename,
  'post' => $last_post['max']
]);

if(!$result){

  $q = 'DELETE FROM POST WHERE user = ? AND id = ?';
  $req = $bdd -> prepare($q);
  $req -> execute([$_POST['id'], $last_post['max']]);
  
  header('location:../lounge.php?message_post=Une erreur a eu lieu lors de l\'envoi, ressayez plus tard.&type_post=alert-color');
  exit;
}else{
  header('location:../lounge.php');
  exit;
}
