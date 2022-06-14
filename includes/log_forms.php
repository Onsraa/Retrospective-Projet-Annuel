<div class="loginAccount-el">
    <h1>Connexion</h1>
    <?php if(isset($_GET['message'])){
        echo '<p class="' . $_GET['alert'] . '">' . $_GET['message_connection'] . '</p>';
    }?>
    <form class="login-form" action="verifications/connection_verification.php" method="post">
        <input class="input-verification input-el email-el-login" name="email" type="email" value="<?php echo isset($_COOKIE['email']) ? $_COOKIE['email'] : '' ?>" placeholder="Identifiant" />
        <input class="input-verification input-el password-el-login" name="password"  value="<?php echo isset($_COOKIE['email']) ? $_COOKIE['password'] : '' ?>" type="password" placeholder="Mot de passe" />
        <button class="form-submit-no" id="submit-button-login">
            <i id="submit-icon-login" class="fa-solid fa-xmark"></i>
        </button>
    </form>
    <p onclick="passwordAccount()" class="forget-password-el">mot de passe oublié</p>
    <br />
    <p onclick="createAccount()" class="create-account-el">créer un compte</p>
</div>
<div class="createAccount-el">
    <i onclick="login()" class="fa-2xl fa-solid fa-angle-left"></i>
    <h1>Inscription</h1>
    <?php if(isset($_GET['message'])){
        echo '<p class="' . $_GET['alert'] . '">' . $_GET['message_createAccount'] . '</p>';
    }?>
    <form class="createAccount-form" action="verifications/create_account_verification.php" method="post">
        <input class="input-verification input-create-el nickname-el-create" name="nickname" type="text"  value="<?php echo isset($_COOKIE['nickname']) ? $_COOKIE['nickname'] : '' ?>" placeholder="Pseudo" />
        <input class="input-verification input-create-el password-el-create" name="password" type="password"  value="<?php echo isset($_COOKIE['password']) ? $_COOKIE['password'] : '' ?>" placeholder="Mot de passe" />
        <input class="input-verification input-create-el rePassword-el-create" name="repassword" type="password"  value="<?php echo isset($_COOKIE['repassword']) ? $_COOKIE['repassword'] : '' ?>" placeholder="Encore une fois !" />
        <input class="input-verification input-create-el email-el-create" name="email" type="email"  value="<?php echo isset($_COOKIE['email']) ? $_COOKIE['email'] : '' ?>" placeholder="Email" />
        <div id="board"></div>
        <button class="form-submit-no" id="submit-button-create"><i id="submit-icon-create" class="fa-solid fa-xmark"></i></button>
    </form>
</div>
<div class="passwordAccount-el">
    <i onclick="login()" class="fa-2xl fa-solid fa-angle-left"></i>
    <form class="passwordAccount-form">
        <h1 class="passwordAccountTitle-el">Récupération de mot de passe</h1>
        <input class="input-verification input-el email-el-password" name="email" type="email" placeholder="Saisissez votre email de récupération" />
        <button class="form-submit-no" id="submit-button-password"><i id="submit-icon-password" class="fa-solid fa-xmark"></i></button>
        <p class="contact-us-el">Contacter le support</p>
    </form>
</div>