<?php
require_once 'app/helpers.php';
session_start();
$page_title = 'Home Page';
?>
<?php include 'tpl/header.php'; ?>
<main>
  <div class="container my-4 d-none d-lg-block">
    <div class="row">
      <div class="col">
        <h1 class="display-4 text-center mt-5" style="color:	#440326 !important;">Welcome to <span style="font-family: 'Saira Stencil One', cursive;"><i class="fa fa-film"></i>cinematalk</span></h1>
      </div>
    </div>
    <div class="card-deck ">
      <div class="card border-0">
        <div class="card-body">
          <p class="card-text"><mark>
              Anyone of us (at certain age) realizes that he or she has been seeing thousands of movies during their lifetime. There is notning equivalent for that, even if someone really loves to read its still doesn't reach for this spectrum. Besides that, there are many different ways for experiencing movies: you can concentrate real hard or just stare at the screen. You can get emotionally involved with the occurrences or just be a distant observer. You can treat movies as a form of art but you can also use them for killing time. either way movies are fun and every one of us has his own authentic experience with them. When it comes to movies, like almost anything else, often times it happens that we read reviews at the newspaper or hear opinions which we don't agree with. A lot of times we say to ourselves "This person doesn't know what he is talking about" or "I could phrase that much better" or "They are all missing the point here". So this Blog is for people who feel like writing or even just saying something about movies</mark> <strong><a href="about.php"> read more...</a></strong>
          </p>
        </div>
      </div>
      <div class="card border-0">
        <img src="images/audrey.jpg" alt="Audrey Hepburn image" class="card-img">
        <div class="card-img-overlay"></div>
      </div>
    </div>
  </div>

  <!-- the small and medium devices version -->
  <div class="container mt-5 d-lg-none">
    <div class="row">
      <div class="col">
        <h1 class="text-center mt-5" style="color:	#440326 !important;">Welcome to <span style="font-family: 'Saira Stencil One', cursive;display:block;"><i class="fa fa-film"></i>cinematalk</span></h1>
      </div>
    </div>
    <div class="card-deck ">
      <div class="card border-0">
        <div class="card-body">
          <p class="card-text"><mark>
              Anyone of us (at certain age) realizes that he or she has been seeing thousands of movies during their lifetime. There is notning equivalent for that, even if someone really loves to read its still doesn't reach for this spectrum. Besides that, there are many different ways for experiencing movies: you can concentrate real hard or just stare at the screen. You can get emotionally involved with the occurrences or just be a distant observer. You can treat movies as a form of art but you can also use them for killing time. either way movies are fun and every one of us has his own authentic experience with them. When it comes to movies, like almost anything else, often times it happens that we read reviews at the newspaper or hear opinions which we don't agree with. A lot of times we say to ourselves "This person doesn't know what he is talking about" or "I could phrase that much better" or "They are all missing the point here". So this Blog is for people who feel like writing or even just saying something about movies</mark> <strong><a href="about.php"> read more...</a></strong>
          </p>
        </div>
      </div>
      <div class="card border-0">
        <img src="images/audrey.jpg" alt="Audrey Hepburn image" class="card-img">
        <div class="card-img-overlay"></div>
      </div>
    </div>
  </div>
</main>


<!-- fixed footer for desktop -->
<footer class="d-none d-lg-block bg-primary pt-3 mt-5 fixed-bottom" style="background: url(images/certain.jpg)">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <p class="text-center text-muted" style="font-size:25px;">
          <span><i class="fa fa-film mr-2"></i><span style="font-family: 'Saira Stencil One', cursive;">cinematalk</span> &copy;<?= date('Y'); ?></span>
        </p>
      </div>
    </div>
  </div>
</footer>

<!-- regular footer for mobile and tablet -->
<footer class="d-block d-lg-nonebg-primary pt-3" style="background: url(images/certain.jpg)">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <p class="text-center text-muted" style="font-size:25px;">
          <span><i class="fa fa-film mr-2"></i><span style="font-family: 'Saira Stencil One', cursive;">cinematalk</span> &copy;<?= date('Y'); ?></span>
        </p>
      </div>
    </div>
  </div>
</footer>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>
</body>

</html>