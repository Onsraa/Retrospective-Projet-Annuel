<?php session_start() ?>
<!DOCTYPE html>
<html>
<?php $title = 'Profil';
include("includes/head.php") ?>

<body>
    <?php
    include("includes/header.php");
    if (!isset($_SESSION['email'])) {
        include("includes/log_forms.php");
    }

    include('includes/db.php');

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

    //Récupere l'avatar du user
    $qAvatar = "SELECT avatar_assets FROM USER_AVATAR WHERE  USER_AVATAR.users = $id";
    $reqAvatar = $bdd->query($qAvatar);
    $resultsAvatar = $reqAvatar->fetch(PDO::FETCH_ASSOC);

    ?>
    <main class="blur-el" id="neon_font">
      <div class="header_background">

      </div>

      <div class="container-fluid">
        <div class="row">

          <div class="settings_background">
            <form action="verifications/settings_verification.php" method="post">
              <h1>Settings</h1>
                <div class="row">
                  <div class="col-4">
                    <h3>Profil Info</h3>
                    <div class="row">
                      <div class="col-6">
                        <p>Avatar</p>
                        <div class="row">
                          <div class="col">

                          <?php echo '<img src="uploads/file-' . $resultsAvatar['avatar_assets'] . '.png"> '?>

                        </div>
                        </div>
                        <div class="row">
                          <div class="d-flex justify-content-center col">
                            <button type="button" name="button" id="edit_avatar">Edit</button>
                          </div>
                        </div>
                      </div>

                      <div class="col-6 statut">
                        <p>Statut</p>
                        <button type="button" name="button" id="change">Change</button>
                      </div>
                    </div>

                    <hr>

                    <div class="row">
                      <div class="col-12">

                        <p>Pseudo</p>
                        <input type="text" name="nickname" placeholder="<?php echo $nickname ?>">

                      </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                        <p>Description</p>
                        <textarea name="content" id="content" placeholder="<?php echo $description ?>"></textarea>

                      </div>
                    </div>
                  </div>
                  <div class="col-8">
                    <h3>Personal Info</h3>
                    <div class="row">

                      <div class="col-6">
                        <p>Firstname</p>
                        <input type="text" name="first_name"  placeholder="<?php echo $first_name ?>">
                      </div>
                      <div class="col-6">
                        <p>Lastname</p>
                        <input type="text" name="last_name"  placeholder="<?php echo $last_name ?>">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <p>Email</p>
                        <input type="email" name="email" placeholder="<?php echo $email ?>">
                      </div>
                      <div class="col-6">
                        <p>Phone number</p>
                        <input type="number" name="phone"  placeholder="<?php echo $phone ?>">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-4">
                        <p>Birth-date : <?php echo $birth_date ?> </p>
                      </div>
                      <div class="col-4">
                        <p>Gender : <?php echo $gender ?></p>
                      </div>
                      <div class="col-4">
                        <p>Region : <?php echo $region ?></p>
                      </div>
                    </div>
                    <div class="row">

                      <hr>
                    </div>
                    <h3>Security</h3>
                    <div class="row">
                      <div class="col-6">
                        <p>Current password</p>
                        <input type="password" name="actualpassword" placeholder="Current password">
                        </div>
                      </div>
                    <div class="row">
                      <div class="col-6">
                        <p>New password</p>
                        <input type="password" name="password" placeholder="New password">
                        </div>
                      <div class="col-6">
                        <p>Again</p>
                        <input type="password" name="repassword" placeholder="New password">
                      </div>

                  </div>
                </div>
                <div class="row">
                  <div class="d-flex justify-content-center  col-12">
                    <button type="sumbit" name="button" id="save">Save</button>

                  </div>
                </div>
                <div class="row">
                  <div class="col">
                      <?php  include("includes/message.php"); ?>
                  </div>
                </div>

            </form>
          </div>

        </div>
      </div>

    </main>
    <script type="text/javascript">

    </script>
    <?php include("includes/footer.php") ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="js/index.js"></script>
</body>

</html>
