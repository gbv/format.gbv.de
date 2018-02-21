<?php

$criteria = [];
foreach ($arguments as $name) {
    $criteria[$name] = ${$name};
}

$items = $PAGES->select($criteria);
ksort($items);
foreach ($items as $page => $item) {
#    $parts = explode(
}

usort($items, function ($a, $b) use ($PAGES) {
    $x = $a['title'] ?? '';
    $y = $b['title'] ?? '';
    if (isset($a['broader'])) {
        $x .= "\n" . ($PAGES->get($a['broader'])['title'] ?? '');
    }
    if (isset($b['broader'])) {
        $y .= "\n" . ($PAGES->get($b['broader'])['title'] ?? '');
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
