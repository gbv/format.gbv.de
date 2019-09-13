<?php

$title = $title ?? 'Beispiel';
$code = $content ?? '';
$code = trim(preg_replace('/^    /m', '', $code));
if ($code !== '') {
    echo "<h3 class='example'>$title</h3>\n";
    $highlight = $highlight ? " class='language-$highlight'" : "";
    echo "<pre><code$highlight>$code</code></pre>\n";
}
