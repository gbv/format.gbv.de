<?php

$schemas = [];

foreach ($PAGES->select(['schemas'=>null]) as $id => $page) {
    foreach ($page['schemas'] as $schema) {
        if ($schema['type'] == $format) {
            $schema['format'] = $id;
            $schemas[] = $schema;
        }
    }
}

if (count($schemas)) { ?>
<h3><?=$title ?? 'Schemas'?></h3>
<ul>
<?php
foreach ($schemas as $schema) {
    echo '<li>';
    echo $TAGS->link(['id' => $schema['format']]);
    if (isset($schema['version'])) {
        echo " ".$schema['version'];
    }
    echo '<br>';
    echo "<a href='{$schema['url']}'>{$schema['url']}</a>";
    echo '</li>';
}
?>
</ul>
<?php }
