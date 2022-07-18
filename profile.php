<?php session_start(); ?>
<!DOCTYPE html>
<html>
<?php
$title = 'Profile';
include("includes/head.php")
?>

<body>
  <?php include("includes/header.php"); ?>
  <main>
    <?php
    require("includes/servers/db.php");
    if (isset($_GET['user'])) {

      $q = 'SELECT 
                USERS.nickname as nickname, 
                USERS.region as region,
                USERS.creation_date as creation_date, 
                USERS.description as description, 
                USERS.background_profile as background_profile,
                (SELECT USER_AVATAR.avatar_assets FROM USER_AVATAR WHERE USER_AVATAR.users = USERS.id) as pfp ,
                (SELECT COUNT(id) FROM POST WHERE POST.user = USERS.id) as post ,
                (SELECT COUNT(follower) FROM USER_FOLLOWS WHERE USER_FOLLOWS.user_followed = USERS.id) as followers,
                (SELECT COUNT(user_followed) FROM USER_FOLLOWS WHERE USER_FOLLOWS.follower = USERS.id) as following                 
                FROM USERS WHERE USERS.id = ?';

      $req = $bdd->prepare($q);
      $req->execute([$_GET['user']]);
      $result = $req->fetch(PDO::FETCH_ASSOC);
      if (empty($result)) {
        header('location: index.php');
        exit;
      } else {
        echo '<div class="background-profile" style="background-image: url(\'uploads/background_profile/background-' . $result['background_profile'] . '\')">
                            <div class="information-profile">
                                <div class="nickname-profile">' . $result['nickname'] . '</div>
                                <div class="posts-profile">posts : ' . $result['post'] . '</div>
                                <div class="followers-profile"> followers : ' . $result['followers'] . '</div>
                                <div class="following-profile"> following : ' . $result['following'] . '</div>
                            </div>
                            <div class="pfp-profile"><img src="uploads/pfp/' . $result['pfp'] . '.png"/></div>
                        </div>
                        <div class="body-profile">
                        <div class="section-profile">
                            <div class="description-profile"><p>' . (($result['description'] !== null) ? $result['description'] : "Pas de description.") . '</p></div>';

        if (isset($_SESSION['id']) && $_SESSION['id'] == $_GET['user']) {
          echo '<button><a href="settings.php"><i class="fa-solid fa-gear"></i></a></button>';
        } else {
          if (!isset($_SESSION['id'])) {
            echo '<button onclick="login()">Connect to follow</button>';
          } else {

            $q = 'SELECT user_followed FROM USER_FOLLOWS WHERE user_followed = ? AND follower = ?';
            $req = $bdd->prepare($q);
            $req->execute([
              $_GET['user'],
              $_SESSION['id']
            ]);
            $result = $req->fetch(PDO::FETCH_ASSOC);

            if (!empty($result)) {
              echo '<button onclick="" class="unfollow-button">unfollow</button>';
            } else {
              echo '<button onclick="" class="follow-button">follow</button>';
            }
          }
        }
        echo    '</div>';
        echo    '<hr class="separation-profile">';
        echo    '</div>';
      }
    } else {
      header('location: index.php');
      exit;
    }
    ?>   
  </main>
  <?php include("includes/footer.php"); ?>
  <script src="js/index.js"></script>
</body>

</html>