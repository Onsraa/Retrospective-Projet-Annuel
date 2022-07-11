<?php

if( !isset($_POST['title']) || empty($_POST['content']) || !isset($_POST['content']) || empty($_POST['title'])) {
  header('location:../lounge.php?message=Veuillez remplir les champs obligatoires&type=alert');
  exit;
}

// si une image est postée
if(!empty($_FILES['file'])){

      // vérifier que le fichier est de type jpg, png ou gif : sinon redirection
      $acceptable = [
      				'image/jpeg',
      				'image/png'
      			];
      // Si le type de fichier n'est pas dans $acceptable : redirection
      if(!in_array($_FILES['file']['type'], $acceptable)){
      	header('location:../lounge.php?message=Type de fichier incorrect.&type=danger');
      	exit;
      }

      // Si le fichier fait plus de 2Mo : redirection
      $maxSize = 2 * 1024 * 1024; // 2Mo
      if($_FILES['file']['size'] > $maxSize){
        header('location:../lounge.php?message=Fichier trop lourd (2Mo max).&type=danger');
        exit;
      }

      // Si le dossier uploads n'existe pas, le créer
      $chemin = 'uploads';
      if(!file_exists($chemin)){
        mkdir($chemin);
      }

      // renommer le fichier
      $array = explode('.', $filename);
      $extension = end($array);

      $filename = 'file-' . time() . '.' . $extension;


      $destination = $chemin . '/' . $filename;

      // Déplacer le fichier vers son emplacement définitif
      move_uploaded_file($_FILES['file']['tmp_name'], $destination);

}

// Insérer un nouveau Post
require('../includes/servers/db.php');

$q = 'INSERT INTO  POST(title,content) VALUES (:title, :content)';
$req = $bdd->prepare($q); // Préparation de la requete
$result = $req->execute([
						'title' => $_POST['title'],
						'content' => $_POST['content'],
						]);



if(!$result){
	header('location: ../lounge.php?message=Erreur lors du poste.&type=danger');
	exit;
}
else{
	header('location: ../lounge.php?message=Votre poste a bien été ajouté.&type=success');
	exit;
}
