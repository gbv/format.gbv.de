<?php
php_sapi_name() === 'cli' or die('not allowed!');

require_once './vendor/autoload.php';

$formats = new \mytcms\Pages('pages/');
$metadata = [];
foreach ($formats->select() as $page) {
    unset($page['body']);
    $metadata[$page['page']] = $page;
}

echo json_encode($metadata, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
