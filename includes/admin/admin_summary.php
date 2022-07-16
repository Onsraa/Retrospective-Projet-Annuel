<?php

$q = 'SELECT 
    (SELECT COUNT(*) FROM USERS) AS count_users, 
    (SELECT COUNT(*) FROM POST) AS count_post, 
    (SELECT COUNT(*) FROM MEDIA_POST) AS count_media';
$req = $bdd->prepare($q);
$req->execute();
$results = $req->fetch();


$title = 'Admin_resume';
include('includes/logging.php');

$usersArray = array();
$usersFile = fopen('logs/users.txt', 'r');
$usersFileArray = explode("\n", fread($usersFile, filesize('logs/users.txt')));
for($i = 0; $i < sizeof($usersFileArray)-1; $i++)
{
    list($k, $v) = explode(" - ", $usersFileArray[$i]);
    $usersArray[$k] = intval($v);
}

$postsArray = array();
$postsFile = fopen('logs/posts.txt', 'r');
$postsFileArray = explode("\n", fread($postsFile, filesize('logs/posts.txt')));
for($i = 0; $i < sizeof($postsFileArray)-1; $i++)
{
    list($k, $v) = explode(" - ", $postsFileArray[$i]);
    $postsArray[$k] = intval($v);
}

$mediasArray = array();
$mediasFile = fopen('logs/medias.txt', 'r');
$mediasFileArray = explode("\n", fread($mediasFile, filesize('logs/medias.txt')));
for($i = 0; $i < sizeof($mediasFileArray)-1; $i++)
{
    list($k, $v) = explode(" - ", $mediasFileArray[$i]);
    $mediasArray[$k] = intval($v);
}
?>

<script type="text/javascript">
    var userData = <?= json_encode($usersArray); ?>; 
    var postData = <?= json_encode($postsArray); ?>; 
    var mediaData = <?= json_encode($mediasArray); ?>; 

    var datas = [userData, postData, mediaData];
    var pos = ["usersChart", "postsChart", "mediasChart"];
</script>
<script type="text/javascript" src="js/admin_resume.js"></script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<table class="sum table table-dark align-middle">
    <thead>
        <tr class="d-flex justify-content-space-between">
            <th class="col-4">Users</th>
            <th class="col-4">Posts</th>
            <th class="col-4">Medias</th>
        </tr>
    </thead>
    <tbody>
        <tr class="d-flex justify-content-center">
            <td class="col-4">
                <label>Now : <?= $usersArray[date('d/m/Y')] ?></label>
                <label>Max : <?= max($usersArray); ?></label>
                <div id="usersChart" class="graph col-12"></div>
            </td>
            <td class="col-4">
                <label>Now : <?= $postsArray[date('d/m/Y')] ?></label>
                <label>Max : <?= max($postsArray); ?></label>
                <div id="postsChart" class="graph col-12"></div>
            </td>
            <td class="col-4">
                <label>Now : <?= $mediasArray[date('d/m/Y')] ?></label>
                <label>Max : <?= max($mediasArray); ?></label>
                <div id="mediasChart" class="graph col-12"></div>
            </td>
        </tr>
    </tbody>
</table>
