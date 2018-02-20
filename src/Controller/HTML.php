<?php declare(strict_types=1);

namespace Controller;

use GBV\YamlHeaderFile;
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

    protected $links;

    public function render($f3, $params)
    {
        $f3['ONERROR'] = function ($f3) {
            $this->error($f3);
        };

        $path = $params['*'];

        // send YAML files as JSON
        if (preg_match('!^(([a-z0-9-]+)/?)+\.json$!', $path)) {
            $file = $this->root . substr($path, 0, -4).'yaml';
            if (file_exists($file)) {
                $data = Yaml::parse(file_get_contents($file));
                $res = new JsonResponse($data);
                $res->send();
                return;
            }
        }

        $formats = new Pages('../pages');
        $tags = new Tags('../tags', ['formats' => $formats]);

        $this->page($f3, $path);

        if ($f3['MARKDOWN']) {
            $html = \Parsedown::instance()->text($f3['MARKDOWN']);

            // process custom tags
            $html = $tags->expand($html);

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
            'title'      => $f3['ERROR']['code'] . ': ' . $f3['ERROR']['status'],
            'breadcrumb' => [ '/' => 'Formate' ],
            'VIEW'       => 'error.php'
        ]);

        echo \View::instance()->render('index.php');
    }

    public function links()
    {
        if (!isset($this->links)) {
            $file = $this->root . "links.md";
            $this->links = @file_get_contents($file) ?? '';
        }
        return $this->links;
    }

    public function page($f3, string $path)
    {
        if ($path == '') {
            $path = 'index';
        }

        if (preg_match('!(([a-z0-9]+)/?)+!', $path)) {
            $file = $this->root .  "$path.md";
            if (file_exists($file)) {
                $doc = new YamlHeaderFile($file);
                $f3->mset($doc->header);
                $f3['MARKDOWN'] = $doc->body . "\n\n" . $this->links();

                if ($path != 'index') {
                    $breadcrumb = [ '/' => 'Formate'];
                    $parts = explode('/', $path);
                    $depth = count($parts);
                    for ($i=0; $i<$depth-1; $i++) {
                        $breadcrumb[ str_repeat('../', $depth-$i).$parts[$i] ] = strtoupper($parts[$i]);
                    }
                    $f3['breadcrumb'] = $breadcrumb;
                }
            }
        }

        if (!$f3['MARKDOWN']) {
            $f3->error(404);
        }
    }
}
