<?php declare(strict_types=1);

require_once('../vendor/autoload.php');

$f3 = Base::instance();
$f3['UI'] = '../templates/';
$f3['AUTOLOAD'] = '../src/';
$f3['CACHE'] = 'folder=../cache/';

$f3['configFile'] = '../config/picahelp.json';

$routes = [
    'pica/@type/schema' => 'PICA',
    'marc/bibliographic/schema' => 'MARC',
    'rdf/lov' => 'LOV',
];

foreach ($routes as $path => $controller) {
    $f3->route("GET /$path", "Controller\\{$controller}->render");
    $f3->route("GET /$path/*", "Controller\\{$controller}->render");
}

$f3->route('GET /*', 'Controller\HTML->render');

$f3->run();
