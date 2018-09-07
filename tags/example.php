<?php


$code = $content ?? '';
$code = trim(preg_replace('/^    /m', '', $code));
if ($code !== '') {
    echo "<h3>Beispiel</h3>\n";
    echo "<pre><code>$code</code></pre>\n";
}
