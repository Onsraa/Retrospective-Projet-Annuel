<?php

session_start();

require_once("../functions/sorts.php");
require_once("db.php");

$number_of_post_per_page = 5;

$mainQuery = 'SELECT 
            POST.id as id,
            POST.title as title,            
            POST.content as description,    
            POST.category as category, 
            POST.date as date, 
            POST.user as user_id,
            MEDIA_POST.src as image,
            (SELECT COUNT(id) FROM COMMENT WHERE COMMENT.post = POST.id) as comments,
            (SELECT COUNT(user) FROM USER_POST_LIKE WHERE USER_POST_LIKE.post = POST.id) as likes,
            (SELECT COUNT(user) FROM USER_POST_DISLIKE WHERE USER_POST_DISLIKE.post = POST.id) as dislikes,
            (SELECT USERS.nickname FROM USERS WHERE USERS.id = POST.user) as author
            FROM POST 
            INNER JOIN MEDIA_POST ON POST.id = MEDIA_POST.post' . (!isset($_POST['category']) || isset($_POST['category']) && $_POST['category'] == 'all' ? ' ORDER BY POST.id DESC' : '');

if(isset($_POST['category']) && !empty($_POST['category']) && $_POST['category'] !== 'all'){
    $q = $mainQuery . ' WHERE POST.category = ? ORDER BY POST.id DESC';
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
