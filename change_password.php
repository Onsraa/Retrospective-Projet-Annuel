<!DOCTYPE html>
<html>
<?php
$title = "Change Password";
require("includes/head.php");
?>

<body class="change-password-body">
    <div class="change-password-div">
        <h2>Changez votre mot de passe :</h2>
        <form>
            <input type="hidden" name="token" value="<?php echo isset($_GET['q']) ? $_GET['q'] : ''; ?>">
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
            <button type="button" onclick="passwordChange('<?php echo isset($_GET['q']) ? $_GET['q'] : '' ;?>', 'changePassword', 'changeRepassword')" class="changePasswordBtn">Sauvegarder</button>
        </form>
    </div>
    <script src="js/index.js"></script>
</body>

</html>