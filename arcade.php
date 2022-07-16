<?php session_start()?>

<?php
include('includes/servers/db.php');

$q = 'SELECT * FROM GAMES WHERE name = ?';
$req = $bdd->prepare($q);
$req->execute([$_GET['game']]);
$results = $req->fetch();

$desc = explode('/', $results['description']);
array_splice($desc, 0, 1);

$q = 'SELECT id, nickname, games FROM USERS, DEVELOPPED_BY WHERE USERS.id = DEVELOPPED_BY.users AND DEVELOPPED_BY.games = ?';
$req = $bdd->prepare($q);
$req->execute([$_GET['game']]);
$resultsDev = $req->fetch();
?>

<!DOCTYPE html>
<html>
    <?php 
    $title = "Arcade";
    include('includes/head.php'); 
    $game = htmlspecialchars($_GET['game']);
    ?>

    <body class="arcade">
        <?php
        include('includes/header.php');
        ?>

        <main>
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-8 main-roll">
                        <section class="title">
                            <h1><?= strtoupper($game) ?></h1>
                            <h2>PRESS <a href="#download">DOWNLOAD</a> TO PLAY</h2>
                        </section>

                        <section class="subtitle">
                            <h3><?= $desc[0] ?></h3>
                            <p><?= $desc[1] ?></p>
                        </section>

                        <section class="download">
                            <img src='img/games/<?= $game . "/" . $game ?> logo.png' alt="<?= $game?> logo">
                            <a href="games/<?= $game?>.rar" id="download">DOWNLOAD</a>
                        </section>

                        <section class="content row">
                            <div class="col-lg-5">
                                <img src='img/games/<?= $game . "/" . $game ?> screen 1.png' alt="<?= $game?> screen">
                            </div>
                            <div class="col-lg-6 desc offset-lg-1 align-self-center">
                                <h3>Description</h3>
                                <p><?= $desc[2]?></p>
                            </div>

                            <div class="col-lg-6 desc align-self-center">
                                <h3>Info</h3>
                                <ul>
                                    <li>Developped by : <a href="profile.php?user=<?=$resultsDev['id']?>"><?= $resultsDev['nickname']?></a></li>
                                    <li>Publish date : <?= $results['publish_date']?></li>
                                    <li>Size : <?= $results['game_size']?> Mo</li>
                                </ul>
                            </div>
                            <div class="col-lg-5 offset-1">
                                <img src='img/games/<?= $game . "/" . $game ?> screen 2.png' alt="<?= $game?> screen">
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </main>

        <?php
        include('includes/footer.php');
        ?>
    </body>
</html>