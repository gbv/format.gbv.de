---
title: JSON
wikidata: Q2063
url: https://json.org/
---

**JavaScript Object Notation (JSON)** ist ein hierarchisches Datenformat, das
vor allem in Webanwendungen verwendet wird.

<phtml>
<?php

$codings = \GBV\Codings::fromDir('../templates')->codings([ 2 => 'json' ]);
if (count($codings)) {
    echo "<h3>JSON-basierte Formate</h3>";
    echo "<ul>";
    foreach ($codings as $c) {
        echo '<li>';
        echo '<a href="'
            .htmlspecialchars($c[0]['local'])
            .'">'
            .htmlspecialchars($c[0]['title'])
            .'</a>';
        echo '</li>';
    }
    echo "</ul>";
} 
?>
</phtml>
