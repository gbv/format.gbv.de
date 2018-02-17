<?php declare(strict_types=1);

class Tags
{
    protected $files;
    protected $globals;

    public function __construct(string $path, array $globals = [])
    {
        $this->files = [];
        foreach (new DirectoryIterator($path) as $file) {
            $name = $file->getFilename();
            if (preg_match('/^([a-z][a-z0-9]+)\.php$/', $name, $match)) {
                $this->files[$match[1]] = $file->getPathname();
            }
        }

        $globals['TAGS'] = $this;
        $this->globals = $globals;
    }

    public function names(): array
    {
        return array_keys($this->files);
    }

    public function call(string $name, array $args = [])
    {
        $_file = $this->files[$name] ?? null;
        if ($_file) {
            foreach ($args as $name => $value) {
                if (preg_match('/^[a-z][a-z0-9_]*$/i', $name)) {
                    ${$name} = $value;
                }
            }
            foreach ($this->globals as $name => $value) {
                ${$name} = $value;
            }
            ob_start();
            include $_file;
            return ob_get_clean();
        }
    }
}
