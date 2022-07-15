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
    ?>
    <main class="blur-el" id="neon_font">

        <?
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

        //récupere le nickname du user
        $qF = 'SELECT * FROM users';
        $reqF = $bdd->query($qF);
        $resultsF = $reqF->fetchAll(PDO::FETCH_ASSOC);

        //récupere la description du user

        foreach($resultsF as $user){
          if($user['email'] == $_SESSION['email']){
           $reel['description'] = $user['description'];
          }
        }

        foreach($resultsF as $user){
          if($user['email'] == $_SESSION['email']){
           $reel['nickname'] = $user['nickname'];
          }
        }

        //Récupere le nombre de posts du user
        $qNbP = 'SELECT * FROM POST,USERS WHERE POST.user = USERS.id';
        $reqNbP = $bdd->query($qNbP);
        $resultsNbP = $reqNbP->fetchAll(PDO::FETCH_ASSOC);
        $compteur = 0;
        foreach ($resultsNbP as $key => $value) {
          $compteur = $compteur +1;
        }

        //Récupere l'avatar du user
        $qAvatar = "SELECT avatar_assets FROM USER_AVATAR WHERE  USER_AVATAR.users = $id";
        $reqAvatar = $bdd->query($qAvatar);
        $resultsAvatar = $reqAvatar->fetch(PDO::FETCH_ASSOC);

        // Récupere le nombre de followers du user
        $qFollowed = 'SELECT user_followed FROM USER_FOLLOWS,USERS WHERE USER_FOLLOWS.user_followed = USERS.id';
        $reqFollowed = $bdd->query($qFollowed);
        $resultsFollowed = $reqFollowed->fetchAll(PDO::FETCH_ASSOC);
        $compteurFollowers = 0;

        foreach ($resultsFollowed as $key => $value) {
          if ($value['user_followed']==$reel['id']){

            $compteurFollowers = $compteurFollowers +1;
          }
        }

        // Récupere le nombre de following du user
        $qFollowing= 'SELECT follower FROM USER_FOLLOWS,USERS WHERE USER_FOLLOWS.follower = USERS.id';
        $reqFollowing = $bdd->query($qFollowing);
        $resultsFollowing = $reqFollowing->fetchAll(PDO::FETCH_ASSOC);
        $compteurFollowing = 0;

        foreach ($resultsFollowing as $key => $value) {
          if ($value['follower']==$reel['id']){

            $compteurFollowing = $compteurFollowing +1;
          }
        }
        ?>

        <div class="banner_profil">

            <div class="d-flex align-items-center barre_profil">
              <div class="container-fluid div_centered">
              <div class=" justify-content-end  row">
                <div class="col-4">

                </div>
                <div class="col-auto ">
                    <p><?php echo $reel['nickname'] ?></p>
                </div>
                <div class="col-auto ">
                    <p>posts : <?php echo $compteur ?></p>
                </div>
                <div class="col-auto ">
                    <p>followers : <?php echo $compteurFollowers ?></p>
                </div>
                <div class="col-auto">
                    <p>following : <?php echo $compteurFollowing ?></p>
                </div>
              </div>

            </div>

          </div>
          <?php echo '<img src="uploads/file-' . $resultsAvatar['avatar_assets'] . '.png"> '?>
        </div>

        <div class="container-fluid div_centered">
            <button id="show-edit"><img src="img/Color.svg"></button>
            <div class="row">
                <div class="col">
                    <div class="d-flex align-items-center justify-content-center filtre_div">
                        <div class="d-flex align-items-center justify-content-center row">
                            <div class="col-6">
                                <p><?php echo $reel['description'] ?></p>
                            </div>
                            <div class="col-1">

                            </div>
                            <div class="d-flex align-items-center justify-content-center col-4">
                              <?php
                                if ($user['email'] == $_SESSION['email']){
                                    echo '<form action="settings.php"><button type="sumbit" class="btn btn-secondary " id="myButtonSettings"><img src="img/Settings.svg"></button></form>';
                                }else{
                                  echo '<button type="button" class="btn btn-secondary " id="myButtonFollow">Follow</button>';
                                }
                               ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col">
                    <div class="barre_fine"></div>
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
