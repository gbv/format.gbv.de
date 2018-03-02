<?php

$criteria = [];
foreach ($arguments as $name) {
    $criteria[$name] = ${$name};
}

$items = $PAGES->select($criteria);

uasort($items, function ($a, $b) use ($PAGES) {
    $x = $a['title'] ?? '';
    $y = $b['title'] ?? '';
    if (isset($a['broader'])) {
        $x = ($PAGES->get($a['broader'])['title'] ?? '') . "\n$x";
    }
    if (isset($b['broader'])) {
        $y = ($PAGES->get($b['broader'])['title'] ?? '') . "\n$y";
    }
    return strtolower($x) <=> strtolower($y);
});

$prevParent = null;
if (count($items)) {
    echo '<ul>';
    foreach ($items as $id => $item) {
        $parent = $item['broader'] ?? '';
        if ($parent !== $prevParent) {
            if ($prevParent) {
                echo '</ul>';
            }
            if ($parent) {
                echo '<li>' . $TAGS->link(['id' => $parent]);
                echo '<ul>';
            }
            $prevParent = $parent;
        }
        echo '<li>' . $TAGS->link(['id' => $id]) . '</li>';
    }
    if ($prevParent !== null) {
        echo '</ul>';
    }
    echo "</ul>";
}
