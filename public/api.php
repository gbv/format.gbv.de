<?php declare(strict_types=1);
require_once('../vendor/autoload.php');
$configFile = '../config/picahelp.json';

use GBV\ControllerInterface;
use GBV\Db;
use GBV\JsonResponse;
use GBV\NotFoundException;

// F3 and database
$f3 = Base::instance();
$db = new DB($configFile);
\Registry::set('DB', $db);

// replace error handler
$f3->set('ONERROR', function($f3) {
    $code = $f3->get('ERROR.code');
    throw new \Exception($f3->get('ERROR.message'), $code);
});

// base controller
$baseController = function ($f3) {
    $type = (string) $f3->get('PARAMS.text');
    $path = (string) $f3->get('PARAMS.*');

    if (!preg_match('%^[a-z]+$%', $type)) {
        throw new NotFoundException();
    }

    $controllerName = '\\GBV\\' . strtoupper($type) . '\\Controller';
    if (!class_exists($controllerName) || !is_subclass_of($controllerName, ControllerInterface::class)) {
        throw new RuntimeException('Can not find controller for ' . $type);
    }

    $controller = new $controllerName;
    $controller->handle($path, \Registry::get('DB'));
};

try {
    $f3->route('GET /@text', $baseController);
    $f3->route('GET /@text/*', $baseController);
    $f3->run();
} catch (\Exception $e) {
    error_log("$e");
    echo '<pre>' . $e;
    exit;
    $response = new JsonResponse([], $e->getCode());
    $response->send();
}
