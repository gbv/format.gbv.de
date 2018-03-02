<!doctype html>
<html lang="<?=$language ?? 'de'?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="<?=$BASE?>/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?=$BASE?>/css/bootstrap4-vzg.css">
<?php
foreach (($css ?? []) as $href) {
    echo "  <link rel='stylesheet' href='$href'>\n";
}
?>
  <title><?=$short ?? $title?></title>
</head>
<header>
  <nav class="navbar navbar-dark navbar-expand-lg">
    <button class="navbar-toggler" type="button"
            data-toggle="collapse" data-target="#mainMenu"
            aria-controls="mainMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
      <a href="//www.gbv.de/" alt="VZG" class="navbar-brand expand-lg d-none d-lg-block">
        <img src="<?=$BASE?>/img/vzg-logo.jpg"/>
      </a>
    <div class="collapse navbar-collapse" id="mainMenu">
      <ul class="navbar-nav mr-auto">
<?php
$menu = ['index','structure','application','code','schema', 'about'];
$parts = explode('/', $id);
$current = null;
foreach ($menu as $href) {
    $active = $href === (in_array($parts[0], $menu) ? $parts[0] : 'index');
    if ($active) {
        $current = $href;
    }
    $url = "$BASE/" . ($href === 'index' ? '' : $href);
    $p = $PAGES->get($href);
    $name = $p['short'] ?? $p['title'] ?? $href;
    echo "<li class='navbar-item".($active?' active':'')."'>";
    echo "<a href='$url' class='nav-link'>$name</a></li>";
} ?>
      </ul>
    </div>
  </nav>
</header>
<main role="main" class="container">
<?php
if ($id !== $current) {
    echo "<h1>".$title."</h1>";
}
if ($VIEW) {
    echo \View::instance()->render($VIEW);
} elseif ($BODY) {
    echo \View::instance()->raw($BODY);
}
include 'seealso.php';
include 'infobox.php';
?>
</main>
<footer class="footer">
  <div class="container-fluid text-secondary">
    <div class="float-right">
<?php if ($id) { ?>
      <a href="<?="$BASE/$id"?>.json">Daten</a>
      / <a href="https://github.com/gbv/format.gbv.de/tree/master/pages/<?=$id?>.md">Quelltext</a>
      /
<?php } ?>
      <a href="<?=$BASE?>/license">Lizenz</a>
    </div>
    <p><a href="https://www.gbv.de/">Verbundzentrale des GBV (VZG)</a></p>
  </div>
</footer>
</body>
<script src="<?=$BASE?>/js/jquery-3.3.1.min.js"></script>
<script src="<?=$BASE?>/js/bootstrap.min.js"></script>
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
