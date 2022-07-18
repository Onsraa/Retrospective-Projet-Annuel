<div class="loginAccount-el">
  <h1>Connexion</h1>
  <?php if (isset($_GET['message_connection'])) {
    echo '<p class="message-el ' . htmlspecialchars($_GET['type_connection']) . '"></p>';
  } ?>

  <?php

  if (isset($_GET['resend']) && $_GET['resend'] == 1 && isset($_GET['email'])) {
    echo '<form class="login2-form" action="verifications/token_verification.php" method="get">';
    echo '<input class="input-el email-el-login" type="hidden" name="email" value="' . (isset($_GET['email']) ? $_GET['email'] : "") . '">';
    echo '<input class="input-el" type="text" name="token" placeholder="token code">';
    echo '<button class="form-submit-yes" id="submit-button-login">
                <i id="submit-icon-login" class="fa-solid fa-check"></i>
              </button>';
    echo '</form>';
  } else {
    echo '<form class="login-form" action="verifications/connection_verification.php" method="post">';
    echo '<label class="email-label">Email</label>';
    echo '<input class="input-verification input-el email-el-login" name="email" type="email" value="' . (isset($_COOKIE['email']) ? $_COOKIE['email'] : "") . '" placeholder="sananes_champagne@esgi.fr" />';
    echo '<label class="password-label">Mot de passe</label>';
    echo '<input class="input-verification input-el password-el-login" name="password"  value="' . (isset($_COOKIE['password']) ? $_COOKIE['password'] : "") . '" type="password" placeholder="Code ultra secret" />';
    echo '<button disabled class="form-submit-no" id="submit-button-login">
                <i id="submit-icon-login" class="fa-solid fa-xmark"></i>
              </button>';
    echo '</form>';
  }

  ?>

  <p onclick="passwordAccount()" class="forget-password-el">mot de passe oublié</p>
  <br />
  <p onclick="createAccount()" class="create-account-el">créer un compte</p>
</div>
<div class="createAccount-el">
  <i onclick="login()" class="fa-2xl fa-solid fa-angle-left"></i>
  <h1>Inscription</h1>
  <?php if (isset($_GET['message_createAccount'])) {
    echo '<p class="message-el ' . htmlspecialchars($_GET['type_createAccount']) . '"></p>';
  } ?>
  <form class="createAccount-form" action="verifications/token_verification.php" method="post">
    <label class="nickname-label">Pseudo</label>
    <input class="input-verification input-create-el nickname-el-create" name="nickname" type="text" value="<?php echo isset($_COOKIE['nickname']) ? $_COOKIE['nickname'] : '' ?>" placeholder="SananesLovesChampagne" />
    <label class="password-label">Mot de passe</label>
    <input class="input-verification input-create-el password-el-create" name="password" type="password" onkeyup="verifyPassword(this.value)" value="<?php echo isset($_COOKIE['password']) ? $_COOKIE['password'] : '' ?>" />
    <label class="repassword-label">Vérifier le mot de passe</label>
    <input class="input-verification input-create-el rePassword-el-create" name="repassword" type="password" onkeyup="verifyIdenticalPassword()" value="<?php echo isset($_COOKIE['repassword']) ? $_COOKIE['repassword'] : '' ?>" />
    <label class="email-label">Email</label>
    <input class="input-verification input-create-el email-el-create" name="email" type="email" value="<?php echo isset($_COOKIE['email']) ? $_COOKIE['email'] : '' ?>" placeholder="sananes_champagne@esgi.fr" />
    <div class="verify-division">
      <div id="board" class=""></div>
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
    </div>

    <button disabled class="form-submit-no" id="submit-button-create"><i id="submit-icon-create" class="fa-solid fa-xmark"></i></button>
  </form>
</div>
<div class="passwordAccount-el">
  <i onclick="login()" class="fa-2xl fa-solid fa-angle-left"></i>
  <form class="passwordAccount-form">
    <h1 class="passwordAccountTitle-el">Récupération de mot de passe</h1>
    <div class="passwordAccount-status"></div>
    <input class="input-verification input-el email-el-password" name="email" type="email" placeholder="Saisissez votre email de récupération" />
    <button type="button" onclick="sendLinkPassword(sendLinkPasswordCheck, 'email-el-password')" class="form-submit-yes" id="submit-button-password"><i id="submit-icon-password" class="fa-solid fa-check"></i></button>
    <p class="contact-us-link"><a href="contactUs.php">Contacter le support</a></p>
  </form>
</div>