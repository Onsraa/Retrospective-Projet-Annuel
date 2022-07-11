<?php

require("../functions/like_dislike.php");

if(isset($_SESSION['id'])){

    $query = $_REQUEST['q'];
    $post_id = $_REQUEST['id'];
    $user_id = $_SESSION['id'];

    require("db.php");

    if($query == 'like'){
        addLike($query, $user_id, $post_id, $bdd);
        checkOther('dislike', $user_id, $post_id, $bdd);
    }
    else if($query == 'dislike'){
        addLike($query, $user_id, $post_id, $bdd);
        checkOther('like', $user_id, $post_id, $bdd);
    }

    $q = 'SELECT (SELECT COUNT(user) FROM user_post_like WHERE user_post_like.post = ' . $post_id . ') as likes, (SELECT COUNT(user) FROM user_post_dislike WHERE user_post_dislike.post = ' . $post_id . ') as dislikes FROM post WHERE post.id = ' . $post_id;
    $res = $bdd -> query($q);
    $result = $res -> fetch(PDO::FETCH_ASSOC);

    echo '<button class="like" onclick="likePost(likeCheck, \'like\',' . $post_id . ')">';
    echo    '<i class="fa-solid fa-thumbs-up"></i>';
    echo '</button>';
    echo '<p id="count-like-' . $post_id  . '">' . $result['likes'] . '</p>';
    echo '<button class="dislike" onclick="likePost(likeCheck, \'dislike\',' . $post_id . ')">';
    echo    '<i class="fa-solid fa-thumbs-down"></i>';
    echo '</button>';
    echo '<p id="count-dislike-' . $post_id . '">' . $result['dislikes'] . '</p>';
}
?>
