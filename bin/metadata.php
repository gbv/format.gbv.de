<?php declare(strict_types=1);

$BASE = realpath(__DIR__).'/..';
require_once("$BASE/vendor/autoload.php");

use mytcms\Pages;
use Symfony\Component\Yaml\Yaml;
use Opis\JsonSchema\Validator;
use Opis\JsonSchema\Errors\ErrorFormatter;

$schema = Yaml::parseFile("$BASE/pages/data/schema.yaml");
$validator = new Validator();
$validator->resolver()->registerRaw(json_encode($schema),'http://format.gbv.de/data/schema.json');


# $context = Yaml::parseFile("$BASE/pages/data/context.yaml");

$lang = 'de';# TODO: do we need this?

# Read and validate all files
$valid = true;
$pages = (new Pages("$BASE/pages"))->select();
foreach( $pages as $item ) {
    $item = Pages::asLinkedData($item);
    $item = json_decode(json_encode($item));

    # TODO: include description and full URI (?)
    # $item['uri'] = "http://format.gbv.de/" . $item['id'];
    # var description = item.description || { }
    # description[item.language || lang] = data.body.trim()

    $result = $validator->validate((object)$item, 'http://format.gbv.de/data/schema.json');

    if ($result->isValid()) {
        # print valid files as ndjson
        echo json_encode($item, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        echo "\n";
    } else {
        $valid = false;
        $formatter = new ErrorFormatter();
        $errors = $formatter->format($result->error(), false);
        foreach($errors as $path => $msg) {
            $file = $item->id;
            error_log("$file $path $msg");
        }
    }
}

$linkFields = ['model', 'for', 'over', 'base', 'profiles'];
foreach( $pages as $id => $item ) {
    foreach ( $linkFields as $field ) {
        $links = $item[$field];
        if ($links) {
            $links = is_array($links) ? $links : [$links];
            foreach ($links as $link) {
                if (!key_exists($link, $pages)) {
                    error_log("$id $field links to missing $link!");
                    $valid = false;
                }
            }
        }
    }
}

# TODO: check internal links in Markdown

exit( $valid ? 0 : 1 );

?>
