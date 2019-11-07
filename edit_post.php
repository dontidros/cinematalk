<?php
require_once 'app/helpers.php';
session_start();

if (!auth_user()) {
  header('location: signin.php');
  exit;
}

$pid = filter_input(INPUT_GET, 'pid', FILTER_SANITIZE_STRING);
$uid = $_SESSION['user_id'];
if (is_numeric($pid)) {
  $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
  mysqli_query($link, "SET NAMES utf8");
  $pid = mysqli_real_escape_string($link, $pid);
  $sql = "SELECT * FROM posts WHERE id=$pid AND user_id=$uid";
  $result = mysqli_query($link, $sql);
  if ($result && mysqli_num_rows($result) > 0) {
    $post = mysqli_fetch_assoc($result);
  } else {
    header('location: blog.php');
    exit;
  }
} else {
  header('location: blog.php');
  exit;
}

$page_title = 'Edit Post Page';
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
    $errors['article'] = 'Article must contain at least three characters';
    $form_valid = false;
  }

  if ($form_valid) {
    $title = mysqli_real_escape_string($link, $title);
    $article = mysqli_real_escape_string($link, $article);
    $sql = "UPDATE posts SET title='$title' , article='$article' WHERE id=$pid AND user_id=$uid";
    $result = mysqli_query($link, $sql);
    header('location: blog.php');
    exit;
  }
}
?>

<?php include 'tpl/header.php'; ?>
<main>
  <div class="container col-lg-6" style="margin-top:90px;">
    <div class="row">
      <div class="col-12">
        <h1 class="h2">Edit post</h1>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <form action="" method="POST" novalidate="novalidate" autocomplete="off">
          <div class="form-group">
            <label for="title"><mark>Title</mark></label>
            <input type="text" class="form-control" name="title" id="title" value="<?= $post['title']; ?>">
            <span class="text-danger"><?= $errors['title']; ?></span>
          </div>
          <div class="form-group">
            <label for="article"><mark>Article</mark></label>
            <textarea name="article" class="form-control" id="article" rows="8" style="resize:none;"><?= $post['article']; ?></textarea>
            <span class="text-danger"><?= $errors['article']; ?></span>
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