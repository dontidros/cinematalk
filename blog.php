<?php
require_once 'app/helpers.php';
session_start();

$page_title = 'Blog Page';
$link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
$sql = "SELECT u.name, up.avatar, p.* , DATE_FORMAT(p.date, '%d/%m/%Y %H:%i:%s') AS post_date 
        FROM posts p 
        JOIN users u ON u.id=p.user_id 
        JOIN users_profile up ON u.id=up.user_id
        ORDER BY p.date DESC";
$result = mysqli_query($link, $sql);

$uid = $_SESSION['user_id'] ?? false;

?>

<?php include 'tpl/header.php'; ?>

<main>
  <div class="container mt-5 col-lg-9">
    <div class="row">
      <div class="col mt-5">
        <h1 class="display-4">Posts</h1>
        <p class="mt-3">
          <?php if (isset($_SESSION['user_id'])) : ?>
            <a href="add_post.php" class="text-secondary lead">
              <img src="images/add_post.png" width="55">
              <strong>Add new Post</strong>
            </a>
          <?php else : ?>
            <a href="signup.php" class="text-secondary lead"><strong>Open Account</strong></a>
          <?php endif; ?>
        </p>
      </div>
    </div>
    <?php if ($result && mysqli_num_rows($result) > 0) : ?>
      <div class="row">
        <?php while ($post = mysqli_fetch_assoc($result)) : ?>
          <div class="col-12 mt-5">
            <div class="card">
              <div class="card-header">
                <span><img class="img-thumbnail rounded-circle" width="50" src="images/<?= $post['avatar']; ?>" alt="user avatar image"><?= htmlentities($post['name']); ?></span>
                <span class="float-right mt-2"><?= $post['post_date']; ?></span>
              </div>
              <div class="card-body">
                <h4><?= htmlentities($post['title']); ?></h4>
                <p class="lead"><strong><?= str_replace("\n", '<br>', htmlentities($post['article'])); ?></strong></p>
                <?php if ($uid && $uid == $post['user_id']) : ?>
                  <div class="dropdown float-right">
                    <button type="button" id="dropdown-menu-button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">More</button>
                    <div class="dropdown-menu" aria-labelledby="dropdown-menu-button">
                      <a href="edit_post.php?pid=<?= $post['id']; ?>" class="dropdown-item">
                        <i class="fa fa-pencil mr-2" aria-hidden="true"></i>Edit</a>
                      <a class="dropdown-item" data-toggle="modal" data-target="#confirm-delete" style="cursor:pointer;"><i class="fa fa-eraser mr-2" aria-hedden="true"></i>Delete</a>
                    </div>
                  </div>
                  <!-- modal start -->
                  <div id="confirm-delete" class="modal fade" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Are you sure you want to delete this post?</h5>
                          <button class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;<span class="sr-only">close</span></span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p class="lead">This document may contain valuable or neaningful data. think again whether you like to delete it or not </p>
                        </div>
                        <div class="modal-footer">
                          <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <a href="delete_post.php?pid=<?= $post['id']; ?>" class="btn btn-primary ml-3">I'm Sure</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- modal end -->
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>
  </div>
</main>

<?php include 'tpl/footer.php' ?>