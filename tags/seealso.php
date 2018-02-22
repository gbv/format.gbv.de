<?php
if ($wikidata || $homepage) { ?>
    <div class="alert alert-info" role="alert">
    ➜ Weitere Informationen zu <?=$title?>
    <?php if ($homepage) { ?>
      <a href="<?=$homepage?>">auf der Homepage</a>
    <?php } ?>
    <?=($wikidata && $homepage) ? ' und ' : ''?>
    <?php if ($wikidata) { ?>
      <a href="https://tools.wmflabs.org/hub/<?=$wikidata?>">in Wikipedia/Wikidata</a>
    <?php } ?>
    </div>
<?php }

include 'infobox.php';
