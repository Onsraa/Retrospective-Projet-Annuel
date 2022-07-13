<?php

$sort = (isset($_GET['sort']) && !empty($_GET['sort']) ? $_GET['sort'] : 'id');
$order = (isset($_GET['order']) && !empty($_GET['order']) ? $_GET['order'] : 'ASC');

$q = 'SELECT id, email, nickname, phone, first_name, last_name, birth_date, status, region, gender, creation_date, is_banned FROM USERS ORDER BY :sort';
$req = $bdd->prepare($q);
if (isset($_GET['sort']) && !empty($_GET['sort'])){
    $req->execute(['sort' => $_GET['sort']]);
} else {
    $req->execute([
        'sort' => 'email'
    ]);
}

$req->execute();
$results = $req->fetchAll();

$c = 'SELECT * FROM USER_AVATAR';
$req = $bdd->prepare($c);
$req->execute();
$results_avatar = $req->fetchAll();

$title = 'Admin_users';
include('includes/logging.php');

?>

<div class="row">
    <form action="verifications/admin_users_verif.php" method="post" enctype="multipart/form-data" id="admin-user-form">
        <table class="table table-striped table-dark table-hover table-sm align-middle table-responsive">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Mail</th>
                    <th scope="col">Nickname</th>
                    <th scope="col">Avatar</th>
                    <th scope="col">Phone</th>
                    <th scope="col">First name</th>
                    <th scope="col">Last name</th>
                    <th scope="col">Birth date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Region</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Creation date</th>
                    <th scope="col">Options</th>
                </tr>
            </thead>

        <?php
        foreach($results as $key => $value){
            $date = explode('-', $value['creation_date']);
            echo 
            '<tr class="row' . $value['id'] . ' row-' . (($value['is_banned'] == 0) ? $value['status'] : "banned") . '">
                <th scope="row">' . $value['id'] . '</td>
                <td class="col emailtd">' . $value['email'] . '</td>
                <td class="col">' . $value['nickname'] . '</td>';
                foreach($results_avatar as $key2 => $value2){
                    if ($value2['users']==$value['id']) {
                    echo '<td class="avatar"><img class="img-in" src="uploads/pfp/'. $value2['avatar_assets'] . '.png"></td>';
                    }
                }
                echo
                '<td class="col">' . $value['phone'] . '</td>
                <td class="col">' . $value['first_name'] . '</td>
                <td class="col">' . $value['last_name'] . '</td>
                <td>' . $value['birth_date'] . '</td>
                <td>' . $value['status'] . '</td>
                <td>' . $value['region'] . '</td>
                <td class="col">' . $value['gender'] . '</td>
                <td class="col">' . $value['creation_date'] . '</td>
                <td class="col-1">
                    <div class="options_buttons">
                    <button type="button" class="btn btn-outline-warning btn-sm">Warn</button>';
                    if ($value['is_banned'])
                    {
                        echo '<button type="button" class="btn btn-outline-secondary btn-sm" onclick="admin_ban(\'.row' . $value['id'] . '\', 1)">Unban</button>';
                    } else {
                        echo '<button type="button" class="btn btn-outline-danger btn-sm" onclick="admin_ban(\'.row' . $value['id'] . '\', 0)">Ban</button>';
                    }
                    echo '<button type="button" class="btn btn-outline-info btn-sm" onclick="admin_edit(\'.row' . $value['id'] . '\')">Edit</button>
                    </div>
                </td>
            </tr>';
        }
        ?>

        </table>
    </form>
</div>