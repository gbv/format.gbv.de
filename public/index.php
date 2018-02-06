<?php declare(strict_types=1);

require_once('../vendor/autoload.php');

$f3 = Base::instance();
$f3['UI'] = '../templates/';
$f3['AUTOLOAD'] = '../src/';
$f3['CACHE'] = 'folder=../cache/';

$f3['configFile'] = '../config/picahelp.json';

$f3->route('GET /pica/@type', 'Controller\PICA->render');
$f3->route('GET /pica/@type/*', 'Controller\PICA->render');
$f3->route('GET /rdf/lov/*', 'Controller\LOV->render');
$f3->route('GET /rdf/lov', 'Controller\Lov->render');
$f3->route('GET /marc/*', 'Controller\MARC->render');
$f3->route('GET /*', 'Controller\HTML->render');

$f3->run();
