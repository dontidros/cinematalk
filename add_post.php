<?php

require_once 'app/helpers.php';
session_start();

if (!auth_user()) {
  header('location: signin.php');
  exit;
}

$page_title = "Add Post Page";
$errors['title'] = $errors['article'] = '';

if (isset($_POST['submit'])) {
  $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  $article = filter_input(INPUT_POST, 'article', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

  $form_valid = true;

  if (!$title || mb_strlen($title) < 3 || mb_strlen($title) > 255) {
    $errors['title'] = 'Title is required for minimum 3 characters and maximum 255 characters';
    $form_valid = false;
  }
  if (!$article || mb_strlen($article) < 3) {
    $errors['article'] = 'Article is required at least 3 characters';
    $form_valid = false;
  }

  if ($form_valid) {
    $uid = $_SESSION['user_id'];
    $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
    mysqli_query($link, "SET NAMES utf8");
    $title = mysqli_real_escape_string($link, $title);
    $article = mysqli_real_escape_string($link, $article);
    $sql = "INSERT INTO posts VALUES (null, $uid, '$title', '$article', NOW() )";
    $result = mysqli_query($link, $sql);
    if ($result && mysqli_affected_rows($link) > 0) {
      header('location: blog.php');
      exit;
    }
  }
}
?>
<?php include 'tpl/header.php'; ?>

<main>
  <div class="container col-lg-6" style="margin-top:90px;">
    <h1 class="h2">Add your new post</h1>
    <div class="row">
      <div class="col">
        <form action="" method="POST" novalidate="novalidate" autocomplete="off">
          <div class="form-group">
            <label for="title"><mark>Title</mark></label>
            <input type="text" name="title" id="title" value="<?= old('title'); ?>" class="form-control">
            <span class="text-danger lead"><?= $errors['title']; ?></span>
          </div>
          <div class="form-group">
            <label for="article"><mark>Article</mark></label>
            <textarea name="article" id="article" value="<?= old('article'); ?>" rows="8" class="form-control" style="resize:none"></textarea>
            <span class="text-danger lead"><?= $errors['article']; ?></span>
          </div>
          <div class="form-group d-none d-lg-block mt-4">
            <button type="submit" class="btn btn-primary mr-4" name="submit">Save Post</button>
            <a href="blog.php" class="btn btn-secondary">Cancel</a>
          </div>
          <div class="form-group d-lg-none mt-4">
            <button type="submit" class="btn btn-primary btn-block btn-sm" name="submit">Save Post</button>
            <a href="blog.php" class="btn btn-secondary btn-block btn-sm">Cancel</a>
          </div>
        </form>

      </div>
    </div>
  </div>
</main>

<?php include 'tpl/fixed_footer.php'; ?>