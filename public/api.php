<?php declare(strict_types=1);
require_once('../vendor/autoload.php');
$configFile = '../config/picahelp.json';

use GBV\Db;
use GBV\RDA\Field;
use GBV\Response;

// F3 and database
$f3 = Base::instance();
$f3->set('ONERROR', function($f3) {
    $code = $f3->get('ERROR.code');
    throw new \Exception('', $code);
});

$db = new DB($configFile);
\Registry::set('DB', $db);

// default controller
$rda = function ($f3) {
    $path = (string) $f3->get('PARAMS.*');
    $field = new Field($path, \Registry::get('DB'));
    $response = new Response($field);
    $response->send();

};

try {
    $f3->route('GET /rda/*', $rda);
    $f3->route('GET /rda', $rda);
    $f3->run();
} catch (\Exception $e) {
    $response = new Response([], $e->getCode());
    $response->send();
}
