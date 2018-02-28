<?php
php_sapi_name() === 'cli' or die('not allowed!');

require_once './vendor/autoload.php';

use Opis\JsonSchema\{Schema, Validator};
use mytcms\Util;

$schemafile = 'pages/aboutdata/schema.yaml';

$internal = ['markdown', 'arguments', 'page', 'javascript', 'css', 'broader'];

$schema = new Schema(Util::loadJsonYaml($schemafile));
$validator = new Validator();

$formats = new \mytcms\Pages('pages/');
$metadata = [];
$links = [];
$result;
foreach ($formats->select() as $page) {
    $id = $page['page'];

    foreach ($internal as $key) {
        unset($page[$key]);
    }

    if (!count($page)) {
        error_log("skipping $id");
        continue;
    }

    # validate
    $data = json_decode(json_encode($page));
    $result = $validator->schemaValidation($data, $schema);

    if (!$result->isValid()) {
        $error = $result->getFirstError();
        if ($error->subErrors()) {
            $error = $error->subErrors()[0];
        }
        $msg = $error->error() . ': ' . implode(', ', $error->dataPointer());
        error_log($id . " $msg");
        $error = true;
    }

    # collect links
    foreach (['for','model','base','profiles'] as $key) {
        if (isset($page[$key])) {
            foreach (is_array($page[$key]) ? $page[$key] : [$page[$key]] as $link) {
                $links[$id][] = $link;
            }
        }
    }

    $metadata[$id] = $page;
}

foreach ($links as $id => $list) {
    foreach ($list as $link) {
        if (!isset($metadata[$link])) {
            error_log("$link linked in $id does not exist");
            $error = true;
        }
    }
}

if ($error) {
    exit(1);
}

if ($result && $result->isValid()) {
    echo json_encode($metadata, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}
