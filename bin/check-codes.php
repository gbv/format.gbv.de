<?php

php_sapi_name() === 'cli' or die('not allowed!');

/**
In der Datei `codes.csv` sind Kodierung mit ihrem Ausgangsmodell und Zielformat
erfasst. Alle drei Angaben (`code`, `model`, und `format`) sind Verweise auf
einzelne Seiten dieser Webseite. Wenn `code` und `model` gleich sind, handelt
es sich bei der Kodierung um die Standard-Syntax des Modells für die keine
eigene Seite existiert.
***/

$base = 'templates';
$codesFile = "$base/code/codes.csv";

$codes = file($codesFile);
array_shift($codes);

$formats = [];

foreach ($codes as $line) {
    foreach (preg_split('/\s*,\s*/', rtrim($line)) as $name) {
        if (!isset($formats[$name])) {
            $formats[$name] = 0;
            if (file_exists("$base/$name.md")) {
                $formats[$name] = "$base/$name.md";
            } elseif (file_exists("$base/$name.php")) {
                $formats[$name] = "$base/$name.php";
            }
        }
    }
}

foreach ($formats as $name => $file) {
    if ($file) {
        echo "$file\n";
    } else {
        error_log("$base/$name.{md,php}");
    }
}
