<?php declare(strict_types=1);

namespace Controller;

use GBV\YamlHeaderDocument;

/**
 * Show HTML based on Markdown files.
 *
 * Markdown files must exist in the templates (`UI`) directory.
 */
class HTML
{

    public function render($f3, $params)
    {
        $f3['ONERROR'] = function ($f3) {
            $this->error($f3);
        };

        $this->page($f3, $params);

        if ($f3['MARKDOWN']) {
            $f3['BODY'] = preg_replace_callback(
                '!<phtml>(.*?)</phtml>!sm',
                function ($match) {
                    $php = '?>' . $match[1] . '<?php ';
                    ob_start();
                    eval($php);    // EVIL EVAL!
                    return ob_get_clean();
                },
                \Parsedown::instance()->text($f3['MARKDOWN'])
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

    public function page($f3, $params)
    {
        $path = (string)$params['*'];

        if ($path == '') {
            $path = 'index';
        }

        $templates = $f3['UI'];
        if (preg_match('!(([a-z0-9]+)/?)+!', $path)) {
            if (file_exists("$templates$path.md")) {
                $doc = YamlHeaderDocument::parseFile("$templates$path.md");
                $f3->mset($doc->header());
                $f3['MARKDOWN'] = $doc->body();

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
