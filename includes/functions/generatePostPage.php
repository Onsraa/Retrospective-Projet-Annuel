<?php

function generatePost($limitedPost, $allPost, $number_of_post_per_page){

    if(empty($limitedPost)){
        echo '<h2 class="post-information">Il n\'y a malheureusement aucun post..</h2>';
    }else{
        $count = 0;
    echo '<div class="users-posts">';

    foreach($limitedPost as $post){
        $count++;
        echo    '<div class="user-post" id="post-id-' . $post['id'] . '">';
        echo        '<div class="post-header">';
        echo            '<p>' . $post['date'] . '</p>';
        echo            '<p>' . $post['category'] . '</p>';
        echo            '<div class ="like-dislike-post" id="like-dislike-post-' . (int)$post['id'] . '">';
        echo                '<i class="fa-solid fa-thumbs-up" ';
        if(isset($_SESSION['id'])){
            echo 'onclick="likePost(likeCheck,\'like\',' . (int)$post['id'] . ')"';
        } 
        echo '></i>';
        echo '<p id="count-like-' . $post['id'] . '">' . $post['likes'] . '</p>';
        echo '<i class="fa-solid fa-thumbs-down" ';
        if(isset($_SESSION['id'])){
            echo 'onclick="likePost(likeCheck,\'dislike\',' . (int)$post['id'] . ')"';
        } 
        echo '></i>';
        echo                '<p id="count-dislike-' . $post['id'] . '">' . $post['dislikes'] . '</p>';
        echo            '</div>';
        echo            '<a href=""><i class="fa-solid fa-eye"></i></a>';
        echo        '</div>';
        echo        '<div class="post-body">';
        echo            '<img class="post-image-';
        
        if($count%2 == 1){
            echo 'left"';
        }else{
            echo 'right"';
        }
        echo ' src="uploads/post/post-' . $post['image'] .'">';
        echo                '<div class="post-body-description">';
        echo                    '<h2 class="post-title">' . $post['title'] . '</h2>';
        echo                    '<p class="post-description">' . $post['description'] . '</p>';
        echo                    '<p class="post-comments">Comments : ' . $post['comments'] . '</p>';
        echo                    '<p class="post-user"><a href="profile.php?user=' . $post['user_id'] . '">By : ' . $post['author'] . '</a></p>';
        echo                '</div>';
        echo        '</div>';
        echo  '</div>';
    }
    echo '</div>';
    echo '<div class="pages-numbers-post">';

    $number_of_post = count($allPost);
    $number_of_pages = ceil($number_of_post/$number_of_post_per_page);
    
    if(!empty($allPost)){
        for($i = 1 ; $i <= (int)$number_of_pages ; $i++){
            echo '<button class="page-number-post" type="button" onclick="postAjax(sortPost,' . $i .')">' . $i . '</button>';
        }
    }
    echo'</div>';
    }

    
}
