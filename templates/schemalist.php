<?php
$formats = new \GBV\Formats('../templates/');

$schemas = [];
foreach ($formats->listPages('schema/') as $page) {
    $meta = $formats->pageMeta($page);
    if (isset($for)) {
        if (!isset($meta['for'])) {
            continue;
        }
        if (!in_array(
            $for,
            is_array($meta['for']) ? $meta['for'] : [ $meta['for'] ])
        ) {
            continue;
        }
    }
    $schemas[] = $meta;
}

if (count($schemas)) {
    echo $content;
    echo '<ul>';
    foreach ($schemas as $schema) {
       echo '<li>';
       echo \View::instance()->render('pagelink.php', '', ['meta' => $schema]);
       echo '</li>';
    }
    echo '</ul>';
}
