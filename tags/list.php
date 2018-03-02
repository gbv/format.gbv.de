<?php
if (count($items)) {
    echo $content;
    echo '<ul>';
    foreach ($items as $id => $item) {
        echo '<li>';
        echo $TAGS->link(['id' => $id]);
        echo '</li>';
    }
    echo '</ul>';
}
