<?php declare(strict_types=1);

namespace GBV;

use Symfony\Component\Yaml\Yaml;

class YamlHeaderFile
{
    public $file;
    public $header;
    public $body;

    /**
     * Read file, split YAML header from body, and parse header.
     */
    public function __construct($file)
    {
        $this->file   = $file;
        $this->header = [];

        $body = file_get_contents($file);

        $pattern = '/[\s\r\n]---[\s\r\n]/s';
        $parts = preg_split($pattern, PHP_EOL . ltrim($body));

        if (count($parts) >= 3) {
            $this->header = Yaml::parse(trim($parts[1]));
            $body = implode(PHP_EOL . "---" . PHP_EOL, array_slice($parts, 2));
        }

        $this->body = $body;
    }

    public function __get($key)
    {
        return $this->header[$key] ?? null;
    }
}
