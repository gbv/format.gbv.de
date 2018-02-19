<?php declare(strict_types=1);

namespace Controller;

use GBV\YamlHeaderFile;
use Tags;

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

        $formats = new \GBV\Formats('../pages');
        $tags = new Tags('../tags', ['formats' => $formats]);

        $this->page($f3, $params);

        if ($f3['MARKDOWN']) {
            $html = \Parsedown::instance()->text($f3['MARKDOWN']);

            // process custom tags
            $tagnames = implode('|', $tags->names());
            $f3['BODY'] = preg_replace_callback(
                "!<(?'tag'$tagnames)(?'attr'[^>]*?)(/>|>(?'content'.*?)</(?P=tag)>)!s",
                function ($match) use ($tags) {
                    $xml = '<' . $match['tag'] . $match['attr'] . '/>';
                    $xml = new \SimpleXMLElement($xml);
                    $elem = json_decode(json_encode($xml), true);
                    $vars = $elem['@attributes'];
                    $vars['content'] = $match['content'] ?? '';
                    return $tags->call($match['tag'], $vars);
                },
                $html
            );

            // clean up tables
            $f3['BODY'] = str_replace('<table>', '<table class="table table-bordered">', $f3['BODY']);
            $f3['BODY'] = preg_replace(
                '!<thead>\s*<tr>\s*(<th></th>\s*)*</tr>\s*</thead>!s',
                '',
                $f3['BODY']
            );
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

    public function page($f3, $params)
    {
        $path = (string)$params['*'];

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
