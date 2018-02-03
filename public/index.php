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
    global $db, $configFile;

    if (!$db) {
        \Registry::set('DB', new DB($configFile));
    }

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

    // TODO: not all controllers require the database
    $controller->handle($path, \Registry::get('DB'));
};

// TODO: move to controller class
$lovController = function ($f3, $params) {
    $path = $params['*'];

    if (!preg_match('/^[a-z]+$/', $path)) {
        $f3->error(404);
    } 

    $url = 'http://lov.okfn.org/dataset/lov/api/v2/vocabulary/info?vocab='.$path;
    $data = @file_get_contents($url);
    $data = json_decode($data, TRUE);

    if (!$data || !isset($data['prefix'])) {
        $f3->error(404);
    }

    $f3->set('breadcrumb', [ 
        '../../' => 'Formate',
        '../../rdf' => 'RDF',
        '../lov' => 'LOV',
    ]);
    $f3->set('VIEW', 'lov.php');

    $title = $data['titles'][0]['value'] ?? $data['prefix'];
    $prefix = $data['prefix'];

    $f3->mset([
        'prefix'    => $prefix,
        'title'     => $prefix,
        'fulltitle' => $title == $prefix ? $title : "$title ($prefix)",
        'homepage'  => $data['homepage'] ?? null,
        'uri'       => $data['uri'] ?? null,
        'description' => $data['descriptions'][0]['value'] ?? null,
    ]);

    // TODO: add incoming and outgoing links
    // TODO: add equivalence to Wikidata and BARTOC

    echo \View::instance()->render('page.php');
};

$htmlController = function ($f3, $params) {
    $path = (string)$params['*'];

    if ($path == '') {
        $path = 'index';
    }

    $path = str_replace('/', '-', $path);
    if (preg_match('!([a-z0-9]+)!', $path)) {
        error_log($path);
        if (file_exists("../templates/$path.md")) {
            $document = YamlHeader::parseFile("../templates/$path.md");
            $f3->mset($document[0]);
            $f3->set('MARKDOWN', $document[1]);

            if ($path != 'index') {
                $breadcrumb = [ '/' => 'Formate'];
                $parts = explode('-', $path);
                $depth = count($parts);
                for ($i=0; $i<$depth-1; $i++) {
                    $breadcrumb[ str_repeat('../', $depth-$i).$parts[$i] ] = strtoupper($parts[$i]);
                }
                $f3->set('breadcrumb', $breadcrumb);
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
    $f3->route('GET /rdf/lov/*', $lovController);
    $f3->route('GET /*', $htmlController);
    $f3->run();
} catch (\Exception $e) {
    error_log("$e");
    $response = new JsonResponse([], $e->getCode());
    $response->send();
}
