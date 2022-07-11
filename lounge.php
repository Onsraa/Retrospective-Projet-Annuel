<?php session_start(); ?>
<!DOCTYPE html>
<html>
<?php 
  $title = 'Lounge';
  include("includes/head.php");
?>

<body>
  <?php
  include("includes/header.php");
  if (!isset($_SESSION['email'])) {
    include("includes/log_forms.php");
  }
  ?>

<main <?php echo !isset($_SESSION['email']) ? 'onclick="fermer()" class="blur-el"' : ''; ?>>
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
    </section>
  </main>
  <?php include("includes/footer.php") ?>
  <script src="js/index.js"></script>
</body>

</html>