<?php
session_start();

if (isset($_POST['password']) && !empty($_POST['password']) && (strlen($_POST['password']) < 8 || !preg_match('/[A-Z]/', $_POST['password']) || !preg_match('/[0-9]/', $_POST['password']))) {
    header('location: ../settings.php?message=Veuillez entrer un mot de passe avec au moins 8 caractères dont une majuscule, une minuscule et un chiffre.&type=danger');
    exit;
}

if(isset($_POST['password']) && !empty($_POST['password']) && ($_POST['password'] != $_POST['repassword'])){
    header('location: ../settings.php?message=Les mots de passe ne sont pas identiques.&type=danger');
    exit;
}

if(isset($_POST['phone']) && !empty($_POST['phone']) && (!preg_match('/^0[1678]([\.\-]?([0-9]{2}){4}$)/', $_POST['phone']))){
    header('location: ../settings.php?message=Veuillez entrer un numéro valide.&type=danger');
    exit;
}


include('../includes/db.php');

//récupere l'id de l'user
$qF = 'SELECT * FROM users';
$reqF = $bdd->query($qF);
$resultsF = $reqF->fetchAll(PDO::FETCH_ASSOC);


foreach($resultsF as $user){
  if($user['email'] == $_SESSION['email']){
   $reel['id'] = $user['id'];
  }
}

$id = $reel['id'];

$email=$_SESSION["email"];

$qF = "SELECT * FROM users WHERE email= '$email'";
$reqF = $bdd->query($qF);
$resultsF = $reqF->fetch(PDO::FETCH_ASSOC);


$nickname = $resultsF['nickname'];
$first_name =$resultsF['first_name'];
$last_name = $resultsF['last_name'];
$birth_date = $resultsF['birth_date'];
$description = $resultsF['description'];
$status= $resultsF['status'];
$region= $resultsF['region'];
$gender= $resultsF['gender'];
$phone= $resultsF['phone'];

if (isset($_POST['nickname']) && !empty($_POST['nickname'])) {
  $nickname = $_POST['nickname'];
}

if (isset($_POST['first_name']) && !empty($_POST['first_name'])) {
  $first_name = $_POST['first_name'];
}

if (isset($_POST['last_name']) && !empty($_POST['last_name'])) {
  $last_name = $_POST['last_name'];
}

if (isset($_POST['description']) && !empty($_POST['description'])) {
  $description  = $_POST['description'];
}

if (isset($_POST['phone']) && !empty($_POST['phone'])) {
  $phone = $_POST['phone'];
}

$data = [
    'nickname' => $nickname,
    'first_name' => $first_name,
    'last_name' => $last_name,
    'description' => $description,
    'phone' => $phone,
];
$sql = "UPDATE users SET nickname=:nickname, first_name=:first_name, last_name=:last_name,description=:description,phone=:phone   WHERE id=$id";
$stmt= $bdd->prepare($sql);
$stmt->execute($data);

if(!$stmt){
	header('location: ../settings.php?message=Erreur lors du changement.&type=danger');
	exit;
}
else{
	header('location: ../settings.php?message=Votre profil a bien été mis à jours.&type=success');
	exit;
}

?>
