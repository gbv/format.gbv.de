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
        $body = file_get_contents($this->base . $page . '.md');

        $pattern = '/[\s\r\n]---[\s\r\n]/s';
        $parts = preg_split($pattern, PHP_EOL . ltrim($body));

        if (count($parts) >= 3) {
            $header = Yaml::parse(trim($parts[1]));
            $body = implode(PHP_EOL . "---" . PHP_EOL, array_slice($parts, 2));
        }

        $header['page'] = $page;
        $header['markdown'] = $body;

        return $header;
    }

    public function select(array $criteria = [], string $prefix = '')
    {
        $pattern = '!^' . self::NAME_PATTERN . '\.md$!';
        $iterator = new \RecursiveDirectoryIterator($this->base);
        foreach (new \RecursiveIteratorIterator($iterator) as $file) {
            $file = substr("$file", strlen($this->base));
            if (preg_match($pattern, $file)) {
                if ($prefix === '' || strpos($file, $prefix) === 0) {
                    $page = $this->get(substr($file, 0, -3));
                    if (self::match($page, $criteria)) {
                        yield $page;
                    }
                }
            }
        }
    }

    public function get(string $page)
    {
        if (!isset($this->pages[$page])) {
            $this->pages[$page] = $this->loadPage($page);
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
            } elseif ($check === null || $value === $check) {
                continue;
            }
            return false;
        }
        return true;
    }
}
