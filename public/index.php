<?php declare(strict_types=1);

require_once('../vendor/autoload.php');

$f3 = Base::instance();
$f3['UI'] = '../tags/';
$f3['AUTOLOAD'] = '../src/';
$f3['CACHE'] = 'folder=../cache/';

$f3->route('GET /rdf/voc/*', 'Controller\LOV->render');
$f3->route('GET /*', 'Controller\HTML->render');

$f3->run();
