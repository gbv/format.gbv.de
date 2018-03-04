<?php
$page = $PAGES->get($id);
if ($page) {
    echo "<a href='$BASE/{$page['id']}'>"
        . $page['title']
        . ($syntax ? ' Syntax' : '')
        . ($page['short'] ? ' (' . $page['short'] . ')' : '')
        .'</a>';
} else {
    echo $id;
}
