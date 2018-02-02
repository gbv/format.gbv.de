<!doctype html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="<?=$BASE?>/css/boostrap4-vzg.css">
  <title><?=$shorttitle ?? $title?></title>
</head>
<header>
  <nav class="navbar navbar-dark navbar-expand">
    <a href="//www.gbv.de/" alt="VZG" class="navbar-brand expand-lg d-none d-lg-block">
    <img src="<?=$BASE?>/img/vzg-logo.jpg"/>
    </a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav mr-auto">
<?php
foreach (($navigation ?? []) as $href => $name) { ?>
        <li class="navbar-item">
          <a href="<?=$BASE.$href?>." class="nav-link"><?=$name?></a>
        </li>
<?php } ?>
        <li class="navbar-item active">
          <a href="<?=$URI?>" class="nav-link"><?=$title?></a>
        </li>
      </ul>
    </div>
  </nav>
</header>
<main role="main" class="container">
<?= Parsedown::instance()->text(View::instance()->raw($MARKDOWN)) ?>
</main>
<footer class="footer">
  <div class="container-fluid text-secondary">
    <div class="float-right">
      <a href="https://github.com/gbv/PicaHelpRest">sources</a>
    </div>
    <p><a href="https://www.gbv.de/">Verbundzentrale des GBV (VZG)</a></p>
  </div>
</footer>
</body>
<?php
  foreach (($javascript ?? []) as $src) {
    if (!preg_match('!^(https:?)//!', $src)) {
      $src = $BASE . $src;
    }
    echo "<script src=\"$src\"></script>";
  }
?>
</html>
