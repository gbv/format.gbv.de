<?php

php_sapi_name() === 'cli' or die('not allowed!');

/**
 * Ermittelt für welche Kodierungen Seiten fehlen.
 */

require_once './vendor/autoload.php';

$base = 'templates';
$codings = \GBV\Codings::fromDir($base)->codings();

$formats = [];
$fail = 0;

foreach ($codings as $code => $about) {
    foreach ($about as $coding) {
        $name = $coding['local'] ?? $coding['title'];
        if (!isset($formats[$name])) {
            $formats[$name] = 1;
            if ($coding['local']) {
                echo "got\t$base/$name.md\n";
            } else {
                error_log("missing\t$base/$name.md");
                $fail = 1;
            }
        }
    }
}

exit($fail);
