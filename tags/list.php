<?php
if (count($items)) {
    echo @$content;
    echo '<ul>';
    foreach ($items as $id => $item) {
        echo '<li>';
        echo $TAGS->link(['id' => $id]);
        if (@$mention) {
            $linked = $PAGES->get($id)[$mention];
            echo " (";
            echo $TAGS->link(['id' => $linked, 'short'=>true]);
            echo ")";
        }
        echo '</li>';
    }
    echo '</ul>';
}
