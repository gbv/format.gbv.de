<?php declare(strict_types=1);

namespace mytcms;

use SimpleXMLElement;

/**
 * Provides Tags given as PHP files in a common directory.
 */
class Tags
{
    protected $files;
    protected $globals;

    public function __construct(string $directory, array $globals = [])
    {
        $this->files = [];
        foreach (new \DirectoryIterator($directory) as $file) {
            $name = $file->getFilename();
            if (preg_match('/^([a-z][a-z0-9-]+)\.php$/', $name, $match)) {
                $this->files[$match[1]] = $file->getPathname();
            }
        }

        $globals['TAGS'] = $this;
        $this->globals = $globals;
    }

    public function __call(string $name, array $arguments)
    {
        $name = preg_replace_callback( # fooBar => foo-bar
            '/([A-Z])/',
            function ($match) {
                return '-' . strtolower($match[1]);
            },
            $name
        );
        $_file = $this->files[$name] ?? null;
        $_args = is_array($arguments[0] ?? null) ? $arguments[0] : [];
        $content = $arguments[1] ?? '';
        $attr = null;
        if ($_file) {
            foreach ($_args as $name => $value) {
                if (preg_match('/^[a-z][a-z0-9_]*$/i', $name)) {
                    ${$name} = $value;
                    $arguments[] = $name;
                }
            }
            foreach ($this->globals as $name => $value) {
                ${$name} = $value;
            }
            $string_arguments = array_filter($arguments, function ($name) {
                return is_string($name) && preg_match('/^[a-z][a-z0-9_]*$/i', $name);
            });
            ob_start();
            include $_file;
            return ob_get_clean();
        }
    }

    public function expand(string $body)
    {
        $tagnames = array_keys($this->files);
        usort($tagnames, function ($a, $b) {
            return strlen($b)-strlen($a);
        });
        $tagnames = implode('|', $tagnames);
        $tags = $this;
        return preg_replace_callback(
            "!<(?'tag'$tagnames)(?'attr'[^>]*?)(/>|>(?'content'.*?)</(?P=tag)>)!s",
            function ($match) use ($tags) {
                $xml = '<' . $match['tag'] . $match['attr'] . '/>';
                $xml = new SimpleXMLElement($xml);
                $elem = json_decode(json_encode($xml), true);
                $vars = @$elem['@attributes'];
                return $tags->{$match['tag']}($vars, $match['content'] ?? '');
            },
            $body
        );
    }
}
