<?php

$q = 'SELECT * FROM post';
$req = $bdd->prepare($q);
$req->execute();
$results = $req->fetchAll();
?>

<div class="row">
    <table class="table table-striped table-dark table-hover table-sm align-middle">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Title</th>
                <th scope="col">Content</th>
                <th scope="col">Date</th>
                <th scope="col">User's id</th>
                <th scope="col">Options</th>
            </tr>
        </thead>

    <?php

    foreach($results as $key => $value){
        echo
        '<tr class="row' . $value['id'] . '">
            <th scope="row">' . $value['id'] . '</td>
            <td>' . $value['title'] . '</td>
            <td>' . $value['content'] . '</td>
            <td>' . $value['date'] . '</td>
            <td>' . $value['user'] . '</td>
            <td><button type="button" class="btn btn-outline-info btn-sm" onclick="admin_edit(\'.row' . $value['id'] . '\')">Edit</button> <button type="button" class="btn btn-outline-warning btn-sm">Warn</button> <button type="button" class="btn btn-outline-danger btn-sm">Ban</button></td>
        </tr>';
    }

    ?>

    </table>
</div>