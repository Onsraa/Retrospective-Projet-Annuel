<?php

require_once("../functions/sorts.php");
require_once("db.php");

$number_of_post_per_page = 3;

$mainQuery = 'SELECT 
            post.id as id,
            post.title as title, 
            post.content as description, 
            post.category as category, 
            post.date as date, 
            media_post.src as image,
            (SELECT COUNT(user) FROM user_post_like WHERE user_post_like.post = post.id) as likes,
            (SELECT COUNT(user) FROM user_post_dislike WHERE user_post_dislike.post = post.id) as dislikes,
            (SELECT users.nickname FROM users WHERE users.id = post.user) as author
            FROM post 
            INNER JOIN media_post ON post.id = media_post.post';

if(isset($_POST['category']) && !empty($_POST['category']) && $_POST['category'] !== 'all'){
    $q = $mainQuery . ' WHERE post.category = ?';
    $res = $bdd -> prepare($q);
    $res -> execute([$_POST['category']]);
    $result = $res -> fetchAll(PDO::FETCH_ASSOC);
}else{
    $q = $mainQuery;
    $res = $bdd -> query($q);
    $result = $res -> fetchAll(PDO::FETCH_ASSOC);
}

$searchQuery = $_REQUEST['search'];

$research = [];

if($searchQuery !== ""){
    $searchQuery = strtolower($searchQuery);
    $len = strlen($searchQuery);
    foreach ($result as $event){
        if(stristr($searchQuery, substr($event['title'], 0, $len))){
            $research[] = $event;
        }
    }
}else{
    $research = $result;
}

if(isset($_POST['sort']) && !empty($_POST['sort'])){

    if($_POST['sort'] == 'like'){
        $research = decrease_Sort($research, 'likes');
    }
    else if($_POST['sort'] == 'dislike'){
        $research = decrease_Sort($research, 'dislikes');
    }
    else if($_POST['sort'] == 'ratio'){
        $research = ratio_Sort($research, 'likes', 'dislikes');
    }
    else if($_POST['sort'] == 'increasing'){
        $research = increase_Sort($research, 'date');
    }
    else if($_POST['sort'] == 'decreasing'){
        $research = decrease_Sort($research, 'date');
    }
}

$limitedResearch = [];
$offset = ($_POST['page'] - 1) * $number_of_post_per_page;

if($number_of_post_per_page < count($research)){
    $temp = $offset;

    while($offset <= ($number_of_post_per_page + $temp - 1) && $offset <= count($research) - 1){
        $limitedResearch[] = $research[$offset];
        $offset++;
    }
}else{
    $limitedResearch = $research;
}

include("../functions/generatePostPage.php");

generatePost($limitedResearch, $research, $number_of_post_per_page);

?>
