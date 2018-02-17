<?php declare(strict_types=1);

namespace GBV;

class Formats
{
    const NAME_PATTERN = '[a-z0-9-]+(/[a-z0-9-]+)*';

    protected $base;
    protected $pages = [];

    public function __construct(string $base)
    {
        $this->base = substr($base, -1) == '/' ? $base : "$base/";
    }

    public function listPages(string $prefix = '')
    {
        $pattern = '!^' . self::NAME_PATTERN . '\.md$!';
        $iterator = new \RecursiveDirectoryIterator($this->base);
        foreach (new \RecursiveIteratorIterator($iterator) as $file) {
            $file = substr("$file", strlen($this->base));
            if (preg_match($pattern, $file)) {
                if ($prefix === '' || strpos($file, $prefix) === 0) {
                    yield substr($file, 0, -3);
                }
            }
        }
    }

    public function findPages(array $criteria = [])
    {
        foreach ($this->listPages() as $page) {
            if ($this->pageMatch($page, $criteria)) {
                yield $this->pageMeta($page);
            }
        }
    }

    public function pageMatch(string $page, array $criteria = [])
    {
        $meta = $this->pageMeta($page);
        foreach ($criteria as $field => $value) {
            $field = $meta[$field] ?? null;
            if (is_array($field) ? in_array($value, $field) : $field === $value) {
                continue;
            }
            return false;
        }
        return true;
    }

    protected function loadPage(string $page)
    {
        if (preg_match('!^' . self::NAME_PATTERN .'$!', $page)) {
            $file = $this->base.$page . '.md';
            if (file_exists($file)) {
                return new YamlHeaderFile($file);
            }
        }
    }

    public function page(string $page)
    {
        if (!isset($this->pages[$page])) {
            $this->pages[$page] = $this->loadPage($page);
        }
        return $this->pages[$page] ?? null;
    }

    public function pageMeta(string $page)
    {
        $data = $this->page($page);
        if ($data) {
            $data = $data->header;
        }
        $data['page'] = $page;
        return $data;
    }

    public function codings(array $select = [])
    {
        $codings = [];
        foreach ($this->listPages() as $page) {
            $meta = $this->pageMeta($page);
            $meta['page'] = $page;
            if (isset($meta['model']) && isset($meta['base'])) {
                $skip = in_array($page, $select);
                foreach ($select as $name => $value) {
                    if ($value && (!isset($meta[$name]) || !in_array(
                        $value,
                        is_array($meta[$name]) ? $meta[$name] : [$meta[$name]]
                    ))) {
                        $skip = true;
                        continue;
                    }
                }
                if (!$skip) {
                    $codings[] = $meta;
                }
            }
        }
        return $codings;
    }
}
