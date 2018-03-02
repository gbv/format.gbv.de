<?php
$page = $PAGES->get($id);
if ($page) {
?><a href="<?=$BASE?>/<?=$page['id']?>">
    <?= $page['title'] ?>
    <?= $syntax ? ' Syntax' : '' ?>
    <?= $page['short'] ? ' (' . $page['short'] . ')' : '' ?>
</a><?php
} else {
    echo $id;
}
