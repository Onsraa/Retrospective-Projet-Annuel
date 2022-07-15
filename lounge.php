<?php session_start(); ?>
<!DOCTYPE html>
<html>
<?php
$title = 'Lounge';
include("includes/head.php")
?>

<body>
  <?php
  include("includes/header.php");
  if (!isset($_SESSION['email'])) {
    include("includes/log_forms.php");
}
  ?>
  <?php

  echo '
    <div class="add-post-div">
    <i onclick="removeAddPost()" class="fa-solid fa-xmark"></i>
    <h1>Post something !</h1>';
  
  if(
    isset($_GET['message_post']) && !empty($_GET['message_post']) &&
    isset($_GET['type_post']) && !empty($_GET['type_post'])){
    echo '<p class=' . $_GET['type_post'] . '>' . $_GET['message_post'] . '</p>';
  }

  echo '<form method="post" action="verifications/post_verification.php" id="add-post-form" enctype="multipart/form-data">
        <div>
          <label>Title</label>
          <input type="text" name="title">
        </div>
        <div>
          <label>Content</label>
          <textarea type="text" name="content" form="add-post-form"></textarea>
        </div>
        <div class="add-post-post2">
          <div>
            <label>Category</label>
            <select name="category">
              <option value="gaming">gaming</option>
              <option value="fun">fun</option>
              <option value="chat">chat</option>
              <option value="other">other</option>
            </select>
          </div>
          <div>
          <label>Your image</label>
          <input id="image-file-post" type="file" name="image">
          </div>
        </div>
        
        <button type="submit">Add post</button>
      </form>    
    </div>
  '

  ?>
  <main <?php echo !isset($_SESSION['email']) ? 'onclick="fermer()" class="blur-el"' : 'class="blur-el"'; ?>>
    <section class="banner"></section>
    <section class="post-section container-fluid">
      <div class="sort-bar row">
        <div class="search-bar col-md-4">
          <label>Research</label>
          <input type="text">
        </div>
        <div class="categories-bar col-md-3">
          <label>Categories : </label>
          <select name="categories" id="categories-select">
            <option value="all">all</option>
            <option value="gaming">gaming</option>
            <option value="fun">fun</option>
            <option value="chat">chat</option>
          </select>
        </div>
        <div class="opinion-bar col-md-3">
          <label>Sorted by : </label>
          <select name="sort" id="sort-select">
            <option value="decreasing">date ↓</i></option>
            <option value="increasing">date ↑</i></option>
            <option value="ratio">ratio</option>
            <option value="like">like</option>
            <option value="dislike">dislike</option>
          </select>
        </div>
        <button type="button" class="col-md-2" onclick="postAjax(sortPost, <?php echo (isset($_GET['page']) && $_GET['page'] !== 0) ? $_GET['page'] : '1' ?>)">Sort</button>
      </div>
      <div class="users-posts-main">
      </div>
      <?php
        if (isset($_SESSION['id'])) {
          echo '<button onclick="addPost()" id="add-post" type="button"><i class="fa-solid fa-plus"></i></button>';
        }
      ?>
    </section>
  </main>
  <?php include("includes/footer.php") ?>
  <script src="js/index.js"></script>
</body>

</html>