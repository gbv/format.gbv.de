<?php
if (count($items)) {
    echo $content;
    echo '<ul>';
    foreach ($items as $item) {
        echo '<li>';
        echo $TAGS->call('pagelink', ['meta' => $item]);
        echo '</li>';
    }
    echo '</ul>';
}
