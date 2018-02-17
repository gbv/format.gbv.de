<?php
php_sapi_name() === 'cli' or die('not allowed!');

require_once './vendor/autoload.php';

$formats = new \GBV\Formats('pages/');
$metadata = [];
foreach ($formats->listPages() as $page) {
    $metadata[$page] = $formats->page($page)->header;
}

echo json_encode($metadata, JSON_PRETTY_PRINT);
