<?php
$page = $PAGES->get($id);
if ($page) {
    $title = $page['title'] . ($syntax ? ' Syntax' : '');
    if ($page['short']) {
        if ($short) {
            $title = $page['short'];
        } else {
            $title .= ' (' . $page['short'] . ')';
        }
    }
    echo "<a href='$BASE/{$page['id']}'>$title</a>";
} else {
    echo $id;
}
