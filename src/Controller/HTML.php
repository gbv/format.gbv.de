<?php declare(strict_types=1);

namespace Controller;

use GBV\JsonResponse;

use mytcms\Tags;
use mytcms\Pages;

use Symfony\Component\Yaml\Yaml;

/**
 * Show HTML based on Markdown files.
 */
class HTML
{
    public $root = '../pages/';

    public function __construct()
    {
        $this->pages = new Pages('../pages');
        $this->tags = new Tags('../tags', ['PAGES' => $this->pages]);
    }

    public function render($f3, $params)
    {
        $f3['ONERROR'] = function ($f3) {
            $this->error($f3);
        };

        $path = $params['*'];

        // send YAML files as JSON
        if (preg_match('!^(([a-z0-9-]+)/?)+\.json$!', $path)) {
            $id = substr($path, 0, -5);
            $file = $this->root . $id . '.yaml';
            if (file_exists($file)) {
                $data = Yaml::parse(file_get_contents($file));
            } else {
                $data = $this->pages->get($id);
                if ($data) {
                    foreach (['markdown', 'arguments', 'page', 'javascript', 'css', 'broader'] as $key) {
                        unset($data[$key]);
                    }
                }
            }
            if ($data) {
                $res = new JsonResponse($data);
                $res->send();
                return;
            }
        }

        $this->page($f3, $path);

        if ($f3['MARKDOWN']) {
            $html = \Parsedown::instance()->text($f3['MARKDOWN']);

            // process custom tags
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
            $html = str_replace('<table>', '<table class="table table-bordered">', $html);
            $html = preg_replace(
                '!<thead>\s*<tr>\s*(<th></th>\s*)*</tr>\s*</thead>!s',
                '',
                $html
            );

            $f3['BODY'] = $html;
        }

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
            'VIEW'  => 'error.php'
        ]);

        echo \View::instance()->render('index.php');
    }

    public function links()
    {
        $links = $this->pages->get('links');
        return $links ? $links['markdown'] : '';
    }

    public function page($f3, string $path)
    {
        if ($path == '') {
            $path = 'index';
        }

        $page = $this->pages->get($path);
        if ($page) {
            $f3->mset($page);
            $f3['MARKDOWN'] = $page['markdown'] . "\n\n" . $this->links();
            $f3['PAGES'] = $this->pages;
        }

        if (!$f3['MARKDOWN']) {
            $f3->error(404);
        }
    }
}
