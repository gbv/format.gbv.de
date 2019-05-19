<?php


$code = $content ?? '';
$code = trim(preg_replace('/^    /m', '', $code));
if ($code !== '') {
    echo "<h3 class='example'>Beispiel</h3>\n";
    echo "<pre><code>$code</code></pre>\n";
}
