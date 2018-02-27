<?php

$select = [];
foreach ($arguments as $name) {
    if ($name != 'exclude') {
        $select[$name] = ${$name};
    }
}
$items = $PAGES->select($select);

if ($exclude) {
    unset($items[$exclude]);
}

usort($items, function ($a, $b) {
    $a = strtolower($a['title'] ?? '');
    $b = strtolower($b['title'] ?? '');
    return $a <=> $b;
});

include 'list.php';
