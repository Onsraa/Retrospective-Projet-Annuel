<?php

session_start();

if( !isset($_POST['title']) || empty($_POST['content']) || !isset($_POST['content']) || empty($_POST['title'])) {
  header('location:../lounge.php?message_post=Veuillez remplir les champs obligatoires&type_post=alert-post');
  exit;
}

if(
  $_POST['category'] !== 'gaming' &&
  $_POST['category'] !== 'fun' &&
  $_POST['category'] !== 'chat' &&
  $_POST['category'] !== 'other'){
  header('location:../lounge.php?message_post=Erreur au niveau de la catégorie du post.&type_post=alert-post');
  exit;
  }

if(!empty($_FILES['image'])){
      $acceptable = [
      				'image/jpeg',
      				'image/png'
      			];
      if(!in_array($_FILES['image']['type'], $acceptable)){
      	header('location:../lounge.php?message_post=Type de fichier incorrect.&type_post=alert-post');
      	exit;
      }

      // Si le fichier fait plus de 2Mo : redirection
      $maxSize = 2 * 1024 * 1024; // 2Mo
      if($_FILES['image']['size'] > $maxSize){
        header('location:../lounge.php?message_post=Fichier trop lourd (2Mo max).&type_post=alert-post');
        exit;
      }

      // Si le dossier uploads n'existe pas, le créer
      $chemin = 'uploads/post';
      if(!file_exists($chemin)){
        mkdir($chemin);
      }

      // renommer le fichier
      $array = explode('.', $filename);
      $extension = end($array);

      $filename = 'post-' . time() . '.' . $extension;


      $destination = $chemin . '/' . $filename;

      // Déplacer le fichier vers son emplacement définitif
      move_uploaded_file($_FILES['image']['tmp_name'], $destination);

}else{
  $filename = 'default_post.png';
}

require('../includes/servers/db.php');

