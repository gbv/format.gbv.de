<?php

$codings = \GBV\Codings::fromDir('../templates')->codings($select ?? []);

if (count($codings)) { ?>
<ul>
<?php foreach ($codings as $c) { 
    $title = $c[0]['title'];
    if (isset($c[0]['short'])) {
        $title = "$title (" . $c[0]['short'] . ')';
    }
?>
  <li>
    <a href="<?=$c[0]['local']?>"><?=$title?></a>
  </li>
<?php } ?>
</ul>
<?php }
