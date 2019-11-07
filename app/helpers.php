<?php
require_once 'db_config.php';

if (!function_exists('old')) {

  /**
   *
   * Restore the value from a field input.
   *
   * @param    string  $fn The input name
   * @return   string
   *
   */
  function old($fn)
  {
    return $_REQUEST[$fn] ?? '';
  }
}


if (!function_exists('csrf_token')) {

  /**
   * 
   * generate random string
   * 
   * @return string
   */
  function csrf_token()
  {
    $token = sha1('$$' . rand(1, 1000) . 'cinematalk');
    $_SESSION['token'] = $token;
    return $token;
  }
}

if (!function_exists('auth_user')) {

  function auth_user()
  {
    $auth = false;
    if (isset($_SESSION['user_id'])) {
      if (isset($_SESSION['user_ip']) && $_SESSION['user_ip'] == $_SERVER['REMOTE_ADDR']) {
        if (isset($_SESSION['user_agent']) && $_SESSION['user_agent'] == $_SERVER['HTTP_USER_AGENT']) {
          $auth = true;
        }
      }
    }
    return $auth;
  }
}

if (!function_exists('email_exist')) {
  /**
   * Checks if an email address exists in the system
   * 
   * @return boolean
   */
  function email_exist($email, $link)
  {
    $exist = false;
    $sql = "SELECT email FROM users WHERE email= '$email'";
    $result = mysqli_query($link, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
      $exist = true;
    }
    return $exist;
  }
}
