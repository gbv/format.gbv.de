<?php
if ($wikidata || $homepage || $bartoc) {
    $links = [];
    if ($homepage) {
        $links[] = "<a href='$homepage'>auf der Homepage</a>";
    }
    if ($wikidata) {
        $links[] = "<a href='https://tools.wmflabs.org/hub/$wikidata'>in Wikipedia/Wikidata</a>";
    }
    if ($bartoc) {
        $links[] = "<a href='https://bartoc.org/en/node/$bartoc'>bei BARTOC</a>";
    }
?>
    <div class="alert alert-info" role="alert">
      ➜ Weitere Informationen zu
        <?= "$title " . implode(' und ', $links) ?>
    </div>
<?php }
