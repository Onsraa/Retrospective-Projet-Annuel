<?php

function generateChangePasswordFrom($message){
    echo '
    <h2>Changez votre mot de passe :</h2>' . '<p style="color: red">' . $message . '</p>
    <form>
        <div class="changePassword">
            <label class="labelChangePassword">Nouveau mot de passe</label>
            <input id="changePassword" class="changePassword-el" name="password" type="password" onkeyup="verifyPassword(this.value)" value="">
        </div>
        <div class="changeRepassword">
            <label class="labelChangeRepassword">Encore une fois</label>
            <input id="changeRepassword" class="changeRepassword-el" name="repassword" type="password" onkeyup="verifyChangedRepassword()" value="">
        </div class="changeRepassword">
        <div id="regex">
            <p class="is_not_valid" id="constat_upper">
                <i class="fa-solid fa-xmark" id="constat_upper_status"></i> Une
                majuscule
            </p>
            <p class="is_not_valid" id="constat_lower">
                <i class="fa-solid fa-xmark" id="constat_lower_status"></i> Une
                minuscule
            </p>
            <p class="is_not_valid" id="constat_number">
                <i class="fa-solid fa-xmark" id="constat_number_status"></i> Un
                chiffre
            </p>
            <p class="is_not_valid" id="constat_special">
                <i class="fa-solid fa-xmark" id="constat_special_status"></i> Un
                caractère spécial
            </p>
            <p class="is_not_valid" id="constat_five">
                <i class="fa-solid fa-xmark" id="constat_five_status"></i> 5
                caractères au minimum
            </p>
            <p class="is_not_valid" id="constat_identical">
                <i class="fa-solid fa-xmark" id="constat_identical_status"></i> Les
                mots de passe sont identiques
            </p>
        </div>
        <button type="button" onclick="passwordChange(\'' . $_POST['q'] . '\', \'changePassword\', \'changeRepassword\')" class="changePasswordBtn">Sauvegarder</button>
    </form>';
}


if(!isset($_POST['q']) || empty($_POST['q']) || $_POST['q'] == ''){
    generateChangePasswordFrom("Une erreur est survenue.");
    exit;
}

$pwdVerif =  "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ \/\%^&*-]).{5,}$/";

if(!preg_match($pwdVerif, $_POST['password'])){
    generateChangePasswordFrom("Les mots de passe ne respectent pas les conditions.");
    exit;
}

if($_POST['password'] !== $_POST['repassword']){
    generateChangePasswordFrom("Les mots de passe ne sont pas identiques.");
    exit;
}


require("../includes/servers/db.php");

$q = 'SELECT id FROM USERS WHERE token = ?';
$req = $bdd -> prepare($q);
$req -> execute([$_POST['q']]);
$id = $req -> fetch(PDO::FETCH_ASSOC);

if(empty($id)){
    generateChangePasswordFrom("Une erreur est survenue");
    exit;
}
else{
 
$salt = '$c53.*?é';
$salted_password = hash('sha256', $_POST['password'] . $salt);
 
$q = 'SELECT id FROM USERS WHERE password = ? AND token = ?';
$req = $bdd -> prepare($q);
$req -> execute([$salted_password, $_POST['q']]);
$result = $req -> fetchAll(PDO::FETCH_ASSOC);

if(!empty($result)){
    generateChangePasswordFrom("Entrez un mot de passe différent de l'ancien.");
    exit;
}

$q = 'UPDATE USERS SET password = :password, token = :token WHERE id = :id';
$req = $bdd -> prepare($q);
$status = $req -> execute([
    'password' => $salted_password,
    'token' => null,
    'id' => $id['id']
]);

if($status){
    echo '<h1 style="color: green">Mot de passe changé avec succès.</h1>';
    exit;
}else{
    generateChangePasswordFrom("Une erreur est survenue.");
    exit;
}
}
