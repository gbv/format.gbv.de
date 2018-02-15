<?php

$formats = new \GBV\Formats('../templates');
$codings = $formats->codings([ 'model' => $model, 'base' => $base ]);

if (count($codings)) {
    echo $content;
    echo '<ul>';
    foreach ($codings as $c) {
        echo '<li>';
        echo \View::instance()->render('pagelink.php','',['meta' => $c]);
        echo '</li>';
    }
    echo '</ul>';
}
