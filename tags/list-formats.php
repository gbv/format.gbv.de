<?php

$select = [];
foreach ($arguments as $name) {
    $select[$name] = ${$name};
}
$items = $PAGES->select($select);
usort($items, function ($a, $b) {
    $a = strtolower($a['title'] ?? '');
    $b = strtolower($b['title'] ?? '');
    return $a <=> $b;
});

include 'list.php';
