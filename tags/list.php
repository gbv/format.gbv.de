<?php
if (count($items)) {
    echo $content;
    echo '<ul>';
    foreach ($items as $item) {
        echo '<li>';
        echo $TAGS->pagelink(['meta' => $item]);
        echo '</li>';
    }
    echo '</ul>';
}
