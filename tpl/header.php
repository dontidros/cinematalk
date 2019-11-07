<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Saira+Stencil+One&display=swap" rel="stylesheet">
  <link rel="shortcut icon" href="images/film_icon.png">
  <link rel="stylesheet" href="styles/style.css">
  <title><?= $page_title; ?></title>
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm fixed-top" style="background: url(images/certain.jpg)">
      <a class="text-muted mr-4" style="font-size:35px;font-family: 'Saira Stencil One', cursive;" href="./"><i class="fa fa-film mr-2"></i>cinematalk</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-supported-content" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
      <div class="collapse navbar-collapse" id="navbar-supported-content">
        <ul class="navbar-nav mr0">
          <li class="nav-item">
            <a href="about.php" class="nav-link">About</a>
          </li>
          <li class="nav-item">
            <a href="blog.php" class="nav-link">Blog</a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <?php if (!auth_user()) : ?>
            <li class="nav-item">
              <a href="signin.php" class="nav-link">Signin</a>
            </li>
            <li class="nav-item">
              <a href="signup.php" class="nav-link">Signup</a>
            </li>
          <?php else : ?>
            <li class="nav-item">
              <a href="profile.php" class="nav-link text-primary"><?= htmlentities($_SESSION['user_name']); ?></a>
            </li>
            <li class="nav-item">
              <a href="logout.php" class="nav-link">Logout</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </nav>
  </header>