<!doctype html>
<html lang="<?=$language ?? 'de'?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?=$BASE?>/css/boostrap4-vzg.css">
<?php
foreach (($css ?? []) as $href) {
    echo "  <link rel='stylesheet' href='$href'>\n";
}
?>
  <title><?=$short ?? $title?></title>
</head>
<header>
  <nav class="navbar navbar-dark navbar-expand">
    <a href="//www.gbv.de/" alt="VZG" class="navbar-brand expand-lg d-none d-lg-block">
    <img src="<?=$BASE?>/img/vzg-logo.jpg"/>
    </a>
    <nav aria-label="breadcrumb" class="collapse navbar-collapse">
      <ul class="navbar-nav mr-auto">
<?php foreach (($breadcrumb ?? []) as $href => $name) { ?>
        <li class="navbar-item">
          <a href="<?=$BASE.$href?>" class="nav-link"><?=$name?></a>
        </li>
<?php } ?>
        <li class="navbar-item active">
          <a href="<?=$URI?>" class="nav-link"><b><?=$title?></b></a>
        </li>
      </ul>
    </nav>
  </nav>
</header>
<main role="main" class="container">
<?php
if ($VIEW) {
    echo \View::instance()->render($VIEW);
} elseif ($BODY) {
    echo \View::instance()->raw($BODY);
}
include 'seealso.php';
?>
</main>
<footer class="footer">
  <div class="container-fluid text-secondary">
    <div class="float-right">
      <a href="<?=$BASE?>/about">about</a>
    </div>
    <p><a href="https://www.gbv.de/">Verbundzentrale des GBV (VZG)</a></p>
  </div>
</footer>
</body>
<?php
foreach (($javascript ?? []) as $js) {
    if (preg_match('/[\r\n]/', $js)) {
        echo "<script>\n$js</script>\n";
    } elseif (!preg_match('!^(https:)?//!', $js)) {
        echo "<script src=\"$BASE/$js\"></script>\n";
    } else {
        echo "<script src=\"$js\"></script>\n";
    }
}
?>
</html>
