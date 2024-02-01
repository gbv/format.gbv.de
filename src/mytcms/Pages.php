<?php declare(strict_types=1);

namespace mytcms;

use Symfony\Component\Yaml\Yaml;

/**
 * Provides pages given as Markdown files with YAML header.
 */
class Pages
{
    const NAME_PATTERN = '[a-z0-9-]+(/[a-z0-9-]+)*';

    protected $base;
    protected $pages = [];

    public function __construct(string $base)
    {
        $this->base = substr($base, -1) == '/' ? $base : "$base/";
    }

    protected function loadPage(string $page)
    {
        $header = [];

        $file = $this->base . $page . '.md';
        if (!file_exists($file)) {
            return;
        }
        $body = file_get_contents($file);

        $pattern = '/[\s\r\n]---[\s\r\n]/s';
        $parts = preg_split($pattern, PHP_EOL . ltrim($body));

        if (count($parts) >= 3) {
            $header = Yaml::parse(trim($parts[1]));
            $body = implode(PHP_EOL . "---" . PHP_EOL, array_slice($parts, 2));
        }

        $header['id'] = $page;
        $parts = explode('/', $page);
        array_pop($parts);
        if (count($parts)) {
            $header['broader'] = implode('/', $parts);
        }
        $header['markdown'] = $body;

        return $header;
    }

    public function select(array $criteria = [], string $pattern = '')
    {
        $pages = [];
        $filepattern = '!^' . self::NAME_PATTERN . '\.md$!';
        $iterator = new \RecursiveDirectoryIterator($this->base);
        foreach (new \RecursiveIteratorIterator($iterator) as $file) {
            $file = substr("$file", strlen($this->base));
            if (preg_match($filepattern, $file)) {
                if (!$pattern || preg_match($pattern, $file)) {
                    $page = $this->get(substr($file, 0, -3));
                    if (self::match($page, $criteria)) {
                        $pages[$page['id']] = $page;
                    }
                }
            }
        }
        return $pages;
    }

    public function get(string $page)
    {
        if (!isset($this->pages[$page])) {
            $loaded = $this->loadPage($page);
            // apply inference
            if (isset($loaded["subsetof"])) {
                $whole = $this->get($loaded["subsetof"]);
                foreach (["base","for"] as $p) {
                    if (isset($whole[$p])) {
                        $loaded[$p] = $whole[$p];
                    }
                }
            }
            $this->pages[$page] = $loaded;
        }
        return $this->pages[$page] ?? null;
    }

    public static function match(array $meta, array $criteria = [])
    {
        foreach ($criteria as $field => $check) {
            if (!isset($meta[$field])) {
                return false;
            }
            $value = $meta[$field];
            if (is_array($value) && in_array($check, $value)) {
                continue;
            } elseif ($check === null || $check === '*' || $value === $check) {
                continue;
            }
            return false;
        }
        return true;
    }

    public static function asLinkedData(array $page)
    {

        # remove layout fields
        foreach (['markdown', 'javascript', 'css', 'broader', 'language'] as $key) {
            unset($page[$key]);
        }

        # TODO: expand with type, backlinks etc.

        $page['@context'] = "http://format.gbv.de/data/context.json";
        $page['$schema']  = "http://format.gbv.de/data/schema.json";

        return $page;
    }
}
