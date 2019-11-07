<?php

require_once 'app/helpers.php';
session_start();

if (auth_user()) {
  header('location: ./');
  exit;
}
$errors = [
  'name' => '',
  'email' => '',
  'password' => ''
];
$page_title = 'Signup Page';

if (isset($_POST['submit'])) {
  if (isset($_POST['token']) && isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token']) {
    $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
    mysqli_query($link, "SET NAMES utf8");
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $name = mysqli_real_escape_string($link, $name);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $email = mysqli_real_escape_string($link, $email);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $password = mysqli_real_escape_string($link, $password);
    $form_valid = true;

    if (!$name || mb_strlen($name) < 2 || mb_strlen($name) > 255) {
      $errors['name'] = '* Name is required for minimum 2 characters and maximum 255 characters';
      $form_valid = false;
    }
    if (!$email) {
      $errors['email'] = '* A valid email is required';
      $form_valid = false;
    } elseif (email_exist($email, $link)) {
      $errors['email'] = '* This email is taken';
      $form_valid = false;
    }
    if (!$password || mb_strlen($password) < 6 || mb_strlen($password) > 20) {
      $errors['password'] = '* A password is required for minimum 6 characters and maximum 20 characters';
      $form_valid = false;
    }

    $file_name = 'default-avatar.png';
    if (isset($_FILES['image']['error']) && $_FILES['image']['error'] == 0) {
      $ex = ['png', 'jpeg', 'gif', 'jpg', 'bmp'];
      define('MAX_UPLOAD_SIZE', 1024 * 1024 * 5);
      if (isset($_FILES['image']['tmp_name']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
        if (isset($_FILES['image']['size']) && $_FILES['image']['size'] <= MAX_UPLOAD_SIZE) {
          $parts = pathinfo($_FILES['image']['name']);
          if (in_array(strtolower($parts['extension']), $ex)) {
            $file_name = date('Y.m.d.H.i.s') . '-' . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . $file_name);
          }
        }
      }
    }
    if ($form_valid) {
      $password = password_hash($password, PASSWORD_BCRYPT);
      $sql = "INSERT INTO users VALUES (null, '$name', '$email', '$password')";
      $result = mysqli_query($link, $sql);

      if ($result && mysqli_affected_rows($link) > 0) {
        $uid = mysqli_insert_id($link);
        $sql = "INSERT INTO users_profile VALUES (null, $uid,'$file_name')";
        $result = mysqli_query($link, $sql);
        if ($result && mysqli_affected_rows($link) > 0) {
          $_SESSION['user_id'] = $uid;
          $_SESSION['user_name'] = $name;
          $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
          $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
          header('location: blog.php');
        }
      }
    }
  }
  $token = csrf_token();
} else {
  $token = csrf_token();
}
?>

<?php include 'tpl/header.php'; ?>

<main>
  <div class="container col-lg-6" style="margin-top:90px;">
    <div class="row">
      <div class="col">
        <h1 class="h2">Signup for new account</h1>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <form method="POST" action="" autocomplete="off" novalidate="novalidate" enctype="multipart/form-data">
          <input type="hidden" name="token" value="<?= $token; ?>">
          <div class="form-group">
            <label for="name"><mark>Name (mandatory)</mark></label>
            <input type="text" value="<?= old('name'); ?>" name="name" id="name" class="form-control form-control-sm">
            <span class="text-danger"><?= $errors['name']; ?></span>
          </div>
          <div class="form-group">
            <label for="email"><mark>Email (mandatory)</mark></label>
            <input type="email" value="<?= old('email'); ?>" name="email" id="email" class="form-control form-control-sm">
            <span class="text-danger"><?= $errors['email']; ?></span>
          </div>
          <div class="form-group">
            <label for="password"><mark>Password (mandatory)</mark></label>
            <input type="password" name="password" id="password" class="form-control form-control-sm">
            <span class="text-danger"><?= $errors['password']; ?></span>
          </div>
          <div class="form-group">
            <label for="image"><mark>Profile Image (not mandatory)</mark></label>
            <div class="custom-file">
              <input type="file" name="image" class="custom-file-input" id="image">
              <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
            </div>
          </div>

          <!-- <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
            </div>
            <div class="custom-file">
              <input type="file" name="image" class="custom-file-input" id="image">
              <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
            </div>
          </div> -->
          <button type="submit" name="submit" class="d-none d-lg-block btn btn-outline-secondary">Sign Up</button>
          <button type="submit" name="submit" class="d-lg-none btn btn-outline-secondary btn-block">Sign Up</button>
        </form>
      </div>
    </div>
  </div>
</main>


<?php include 'tpl/fixed_footer.php'; ?>