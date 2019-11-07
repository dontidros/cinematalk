<?php
require_once 'app/helpers.php';
session_start();
if (!auth_user()) {
  header('location: signin.php');
  exit;
}

$uid = $_SESSION['user_id'];
$page_title = 'Blog Page';
$link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
$sql = "SELECT u.name, up.avatar, p.*, DATE_FORMAT(p.date, '%d/%m/%Y %H:%i:%s') AS post_date 
        FROM posts p, users u, users_profile up 
        WHERE u.id=$uid AND p.user_id=u.id AND up.user_id=u.id 
        ORDER BY p.date";
$result = mysqli_query($link, $sql);

?>

<?php include 'tpl/header.php'; ?>

<main>
  <div class="container col-lg-6" style="margin-top:90px; margin-bottom:90px">
    <div class="row">
      <div class="col">
        <h1 class="display-4 text-center">Hello <?= $_SESSION['user_name'] ?></h1>
      </div>
    </div>
    <?php if ($result && mysqli_num_rows($result) > 0) : ?>
      <div class="row">
        <?php while ($post = mysqli_fetch_assoc($result)) : ?>
          <div class="col-12 mt-5">
            <div class="card">
              <div class="card-header">
                <span><mark><?= $post['post_date']; ?></mark></span>
              </div>
              <div class="card-body">
                <h4><?= htmlentities($post['title']); ?></h4>
                <p><?= str_replace("\n", '<br>', htmlentities($post['article'])); ?></p>
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

<?php include 'tpl/fixed_footer.php' ?>