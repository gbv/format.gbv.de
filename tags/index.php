<!doctype html>
<html lang="<?=$language ?? 'de'?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="<?=$BASE?>/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?=$BASE?>/css/bootstrap4-vzg.css">
  <link rel="stylesheet" href="<?=$BASE?>/css/prism.css">
  <style>.hljs { padding: 0; }</style>
<?php
foreach (($css ?? []) as $href) {
    echo "  <link rel='stylesheet' href='$href'>\n";
}
?>
  <title><?=$short ?? $title?></title>
</head>
<header>
  <nav class="navbar navbar-dark navbar-expand-lg">
  <div class="container">
    <button class="navbar-toggler" type="button"
            data-toggle="collapse" data-target="#mainMenu"
            aria-controls="mainMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
      <a href="//format.gbv.de/" alt="VZG format" class="navbar-brand expand-lg d-none d-lg-block">
        <img src="<?=$BASE?>/img/vzg-format-logo.jpg"/>
      </a>
    <div class="collapse navbar-collapse" id="mainMenu">
        <?php include 'menu.php'; ?>
    </div>
    </div>
  </nav>
</header>
<main role="main" class="container">
<?php
$ID = $id;
if ($ID !== $current) {
    echo "<h1>".$title."</h1>";
}
if ($VIEW) {
    echo \View::instance()->render($VIEW);
} elseif ($BODY) {
    echo \View::instance()->raw($BODY);
}
include 'infobox.php';
?>
</main>
<footer class="footer">
  <div class="container-fluid text-secondary">
    <div class="float-right">
<?php if ($ID) { ?>
      <a href="<?="$BASE/$ID"?>.json">JSON</a>
      &#183;
      <a href="https://github.com/gbv/format.gbv.de/tree/master/pages/<?=$ID?>.md">Quelltext</a>
      &#183;
<?php } ?>
      <a href="<?=$BASE?>/about/license">Lizenz</a>
    </div>
    <p>
      <a href="https://www.gbv.de/">Verbundzentrale des GBV (VZG)</a>
      &#183;
      <a href="https://www.gbv.de/impressum">Impressum</a>
      &#183;
      <a href="https://www.gbv.de/datenschutz">Datenschutz</a>
    </p>
  </div>
</footer>
</body>
<script src="<?=$BASE?>/js/jquery-3.3.1.min.js"></script>
<script src="<?=$BASE?>/js/bootstrap.bundle.min.js"></script>
<script src="<?=$BASE?>/js/prism.js"></script>
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
<script>
$(function(){
  $('[data-toggle="tooltip"]').tooltip()
});
</script>
<?php if ($wikidata) { ?>
<!--script src="//unpkg.com/wikidata-sdk/dist/wikidata-sdk.min.js"></script-->
<?php } ?>
</html>
