<?php

function addLike($option, $user_id, $post_id, $bdd){
    $q = 'SELECT user FROM user_post_' . $option . ' WHERE user = ? && post = ?';
    $res = $bdd -> prepare($q);
    $res -> execute([$user_id, $post_id]);
    $result = $res -> fetch(PDO::FETCH_ASSOC);

    if(empty($result)){
        $q = 'INSERT INTO user_post_' . $option . '(user, post) VALUES (:user, :post)';
        $res = $bdd -> prepare($q);
        $res -> execute([
            'user' => $user_id,
            'post' => $post_id
            ]
        );
    }else{
        $q = 'DELETE FROM user_post_' . $option . ' WHERE user = :user && post = :post';
        $res = $bdd -> prepare($q);
        $res -> execute([
            'user' => $user_id,
            'post' => $post_id
            ]
        );
    }
}

function checkOther($option, $user_id, $post_id, $bdd){
    $q = 'SELECT user FROM user_post_' . $option . ' WHERE user = ? && post = ?';
    $res = $bdd -> prepare($q);
    $res -> execute([$user_id, $post_id]);
    $result = $res -> fetch(PDO::FETCH_ASSOC);

    if(!empty($result)){
        $q = 'DELETE FROM user_post_' . $option . ' WHERE user = :user && post = :post';
        $res = $bdd -> prepare($q);
        $res -> execute([
            'user' => $user_id,
            'post' => $post_id
            ]
        );
    }
}

?>