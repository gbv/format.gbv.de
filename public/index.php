<?php declare(strict_types=1);

require_once('../vendor/autoload.php');
$configFile = '../config/picahelp.json';

use GBV\ControllerInterface;
use GBV\DB;
use GBV\JsonResponse;
use GBV\YamlHeader;
use GBV\NotFoundException;

// F3 and database
$f3 = Base::instance();
$f3->set('UI', '../templates/');
$db = new DB($configFile);
\Registry::set('DB', $db);

// replace error handler
$f3->set('ONERROR', function ($f3) {
    while (ob_get_level()) {
        ob_end_clean();
    }
    $code = $f3->get('ERROR.code');
    //error_log(print_r($f3->get('ERROR.trace'), true));
    throw new \Exception((string)$f3->get('ERROR.message'), $code);
});

// base controller
$picaController = function ($f3, $params) {
    $type = (string) $params['type'];
    $path = (string) $params['*'];

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

$htmlController = function ($f3, $params) {
    $path = (string)$params['*'];

    if ($path == '') {
        $path = 'index';
    }

    if (preg_match('!([a-z0-9/]+)!', $path)) {
        if (file_exists("../templates/$path.md")) {
            $document = YamlHeader::parseFile("../templates/$path.md");
            $f3->mset($document[0]);
            $f3->set('MARKDOWN', $document[1]);

            if ($path != 'index') {
                $f3->set('navigation', [
                    '' => 'Formate'
                ]);
            }
        }
    }

    if (!$f3->get('MARKDOWN')) {
        $f3->error(404);
    }

    echo \View::instance()->render('page.php');
};

try {
    $f3->route('GET /pica/@type', $picaController);
    $f3->route('GET /pica/@type/*', $picaController);
    $f3->route('GET /*', $htmlController);
    $f3->run();
} catch (\Exception $e) {
    error_log("$e");
    $response = new JsonResponse([], $e->getCode());
    $response->send();
}
