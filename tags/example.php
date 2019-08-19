<?php


$code = $content ?? '';
$code = trim(preg_replace('/^    /m', '', $code));
if ($code !== '') {
    echo "<h3 class='example'>Beispiel</h3>\n";
    $highlight = $highlight ? " class='language-$highlight'" : "";
    echo "<pre><code$highlight>$code</code></pre>\n";
}
