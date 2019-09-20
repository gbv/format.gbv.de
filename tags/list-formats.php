<?php

$select = [];
foreach ($arguments as $name) {
    if (!in_array($name, ['exclude', 'title', 'mention'])) {
        $select[$name] = ${$name};
    }
}
$items = $PAGES->select($select);

if ($exclude) {
    unset($items[$exclude]);
}

uasort($items, function ($a, $b) {
    $a = strtolower($a['title'] ?? '');
    $b = strtolower($b['title'] ?? '');
    return $a <=> $b;
});

if ($content) {
    $content = "<p>$content</p>";
}
if ($title) {
    $content = "<h3>$title</h3>$content";
}
include 'list.php';
