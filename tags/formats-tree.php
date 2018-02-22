<?php

$criteria = [];
foreach ($arguments as $name) {
    $criteria[$name] = ${$name};
}

$items = $PAGES->select($criteria);

usort($items, function ($a, $b) use ($PAGES) {
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
    foreach ($items as $item) {
        $parent = $item['broader'] ?? '';
        if ($parent !== $prevParent) {
            if ($prevParent) {
                echo '</ul>';
            }
            if ($parent) {
                echo '<li>' . $TAGS->pagelink(['meta' => $PAGES->get($parent)]);
                echo '<ul>';
            }
            $prevParent = $parent;
        }
        echo '<li>' . $TAGS->pagelink(['meta' => $item]) . '</li>';
    }
    if ($prevParent !== null) {
        echo '</ul>';
    }
    echo "</ul>";
}
