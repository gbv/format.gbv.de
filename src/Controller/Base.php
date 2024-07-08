<?php declare(strict_types=1);
namespace Controller;

use mytcms\Tags;
use mytcms\Pages;

use Symfony\Component\Yaml\Yaml;

/**
 * Show HTML or other formats based on Markdown files.
 */
class Base
{
    public $root;
    public $pages;
    public $menu;
    public $tags;

    protected static $mimetypes = [
        'html'  => 'text/html',
        'dtd'   => 'application/xml-dtd',
        'xsd'   => 'application/xml',
        'xml'   => 'application/xml',
        'yaml'  => 'text/yaml',
        'md'    => 'text/markdown; charset=UTF-8',
    ];

    public function __construct()
    {
        global $f3;
        $this->root = realpath(__DIR__) . '/../../pages/';
        $this->pages = new Pages($this->root);
        $this->menu = Yaml::parse(file_get_contents($this->root . 'menu.yaml'));
        $this->tags = new Tags('../tags', [
            'PAGES' => $this->pages,
            'BASE' => $f3['BASE'],
        ]);
    }

    public function render($f3, $params)
    {
        $f3['ONERROR'] = function ($f3) {
            $this->error($f3);
        };
        $f3['MENU'] = $this->menu;
        $f3['TAGS'] = $this->tags;

        $path = $params['*'];
        $query = $f3->get('GET');

        if (preg_match('!^((([a-z0-9-]+)/?)+)\.([a-z]+)$!', $path, $match)) {
            $id = $match[1];
            $extension = $match[4];

            if ($extension == 'json') {
                $data = $this->pages->get($id);
                if ($data) {
                    $data = Pages::asLinkedData($data);
                } else {
                    $file = $this->root . "$id.yaml";
                    error_log($file);
                    if (file_exists($file)) {
                        $data = Yaml::parse(file_get_contents($file));
                    }
                }

                if ($data) {
                    $options = JSON_PRETTY_PRINT;
                    if ($data['$schema'] == 'https://format.gbv.de/schema/avram/schema.json') {
                        $options |= JSON_FORCE_OBJECT;
                    }
                    $this->sendJson($data, $options);
                    return;
                }
            } else {
                // send static files
                $type = static::$mimetypes[$extension] ?? null;
                $file = $this->root . $path;
                if ($type and file_exists($file)) {
                    header("Content-Type: $type");
                    header('Access-Control-Allow-Origin: *');
                    readfile($file);
                    return;
                }
            }
        }

        $data = $this->page($f3, $path);
        if (!$data) {
            $f3->error('404');
        }

        foreach ($data as $key => $value) {
            $f3[$key] = $value;
        }

        if ($f3['MARKDOWN']) {
            $html = \Parsedown::instance()->text($f3['MARKDOWN']);

            $html = $this->tags->expand($html);

            // Add header identifiers
            $html = preg_replace_callback(
                "!<(?'tag'h[1-9])>(?'content'.*?)</(?P=tag)>!s",
                function ($match) {
                    $tag = $match['tag'];
                    $id = preg_replace('![^a-z0-9]!s', '-', strtolower($match['content']));
                    return "<$tag id='$id'>".$match['content']."</$tag>";
                },
                $html
            );

            // clean up tables
            $html = str_replace('<table>', '<table class="table table-bordered table-responsive">', $html);
            $html = preg_replace(
                '!<thead>\s*<tr>\s*(<th></th>\s*)*</tr>\s*</thead>!s',
                '',
                $html
            );

            $f3['BODY'] = $html;
        }

        $f3['PAGES'] = $this->pages;

        echo \View::instance()->render('index.php');
    }

    public function error($f3)
    {

        // flush template output
        while (ob_get_level()) {
            ob_end_clean();
        }

        $f3->mset([
            'title' => $f3['ERROR']['code'] . ': ' . $f3['ERROR']['status'],
            'VIEW'  => 'error.php',
        ]);

        echo \View::instance()->render('index.php');
    }

    public function page($f3, string $path)
    {
        $data = $this->pages->get($path == '' ? 'index' : $path) ?? [];
        $markdown = $data['markdown'] ?? '';

        if ($markdown) {
            $links = $this->pages->get('links');
            $links = $links ? $links['markdown'] : '';

            $data['MARKDOWN'] = "$markdown\n\n$links";
            unset($data['markdown']);
            return $data;
        } else {
            return;
        }
    }

    public function sendJson($data, int $options = 0)
    {
        if (!headers_sent()) {
            http_response_code(200);
            header('Content-Type: application/json; charset=UTF-8');
            header('Access-Control-Allow-Origin: *');
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | $options);
    }
}
