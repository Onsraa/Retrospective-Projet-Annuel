<?php

session_start();

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

    $q = 'SELECT (SELECT COUNT(user) FROM USER_POST_LIKE WHERE USER_POST_LIKE.post = ' . $post_id . ') as likes, (SELECT COUNT(user) FROM USER_POST_DISLIKE WHERE USER_POST_DISLIKE.post = ' . $post_id . ') as dislikes FROM POST WHERE POST.id = ' . $post_id;
    $res = $bdd -> query($q);
    $result = $res -> fetch(PDO::FETCH_ASSOC);

    echo '<i class="fa-solid fa-thumbs-up"';
    if(isset($_SESSION['id'])){
        echo 'onclick="likePost(likeCheck, \'like\',' . $post_id . ')"';
    } 
    echo '></i>';
    echo '<p id="count-like-' . $post_id  . '">' . $result['likes'] . '</p>';
    echo '<i class="fa-solid fa-thumbs-down"';
    if(isset($_SESSION['id'])){
        echo 'onclick="likePost(likeCheck, \'dislike\',' . $post_id . ')"';
    } 
    echo '></i>';
    echo '<p id="count-dislike-' . $post_id . '">' . $result['dislikes'] . '</p>';
}
?>
