<?php
require_once 'app/helpers.php';
session_start();

if (auth_user()) {
  header('location: ./');
  exit;
}

$page_title = 'Signin Page';
$error = '';
if (isset($_POST['submit'])) {
  if (isset($_POST['token']) && isset($_SESSION['token']) && $_POST['token'] == $_SESSION['token']) {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if (!$email) {
      $error = '* A valid email is required';
    } elseif (!$password) {
      $error = 'Password is required';
    } else {
      $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
      $email = mysqli_real_escape_string($link, $email);
      $password = mysqli_real_escape_string($link, $password);
      $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
      $result = mysqli_query($link, $sql);

      if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
          $_SESSION['user_id'] = $user['id'];
          $_SESSION['user_name'] = $user['name'];
          $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
          $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
          header('location: ./');
        } else {
          $error = '* Wrong email and password combination';
        }
      } else {
        $error = '* Wrong email and password combination';
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

  <div class="container col-md-6" style="margin-top:90px;">
    <h1 class="h2">Signin</h1>
    <form action="signin.php" method="POST" autocomplete="off" novalidate="novalidate">
      <input type="hidden" name="token" value="<?= $token ?>">
      <div class="form-group mt-4">
        <div class="input-group ">
          <div class="input-group-prepend ">
            <label for="email" class="sr-only">email</label>
            <span class="input-group-text text-white" style="background-color:#7A0B3E !important;"><i class="fa fa-envelope"></i></span>
          </div>
          <input type="email" value="<?= old('email') ?>" name="email" id="email" class="form-control" placeholder="Email">
        </div>
      </div>
      <div class="form-group my-4">
        <div class="input-group">
          <div class="input-group-prepend">
            <label for="password" class="sr-only">password</label>
            <span class="input-group-text text-white" style="background-color:#7A0B3E !important;">
              <i class="fa fa-key"></i>
            </span>
          </div>
          <input type="password" name="password" id="password" class="form-control" placeholder="Password">
        </div>
      </div>
      <button type="submit" class="d-lg-none btn btn-outline-secondary btn-block mt-2" name="submit">Sign In</button>
      <button type="submit" class="d-none d-lg-block btn btn-outline-secondary btn-lg mt-2" name="submit">Sign In</button>
      <span class="text-danger lead"><?= $error ?></span>
    </form>
  </div>
</main>

<?php include 'tpl/fixed_footer.php'; ?>