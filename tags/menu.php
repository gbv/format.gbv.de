<ul class="navbar-nav mr-auto">
<?php

$parts = explode('/', $id);
$current = null;
$submenu = false;

foreach ($MENU as $n => $entry) {
    if (is_array($entry) && $entry[0] === $parts[0]) {
        $submenu = true;
    }
}

foreach ($MENU as $n => $entry) {
    if (is_array($entry)) {
        $active = $entry[0] === $parts[0];
        echo '<li class="nav-item dropdown'.($active?' active':'').'">';
        echo $TAGS->link([
            'id'    => $entry[0],
            'attr'  => "class='nav-link dropdown-toggle' id='submenu-$n'".
                "data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'",
            'short' => 1,
        ]);
        echo '<div class="dropdown-menu">';
        foreach ($entry as $m => $href) {
            $class = 'dropdown-item' . ($m ? '' : ' font-weight-bold');
            echo $TAGS->link(['id'=>$href,'short'=>1,'attr'=>"class='$class'"]);
        }
        echo '</div></li>';
    } else {
        $active = $entry === (in_array($parts[0], $MENU) ? $parts[0] : 'index') && !$submenu;
        if ($active) {
            $current = $entry;
        }
        echo "<li class='navbar-item".($active?' active':'')."'>";
        echo $TAGS->link(['id'=>$entry,'short'=>1,'attr'=>'class="nav-link"']);
        echo "</li>";
    }
}

?>
</ul>
