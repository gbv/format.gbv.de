<?php

$select = [];
foreach ($arguments as $name) {
    if (!in_array($name, ['exclude', 'title'])) {
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

if ($title) {
    $content = "<h3>$title</h3>";
}
include 'list.php';
