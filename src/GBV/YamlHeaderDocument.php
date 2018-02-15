<?php declare(strict_types=1);

namespace GBV;

use Symfony\Component\Yaml\Yaml;

class YamlHeaderDocument
{
    protected $header;
    protected $body;
    protected $file;

    private function __construct($file, $yaml, $body)
    {
        $this->file   = $file;
        $this->header = Yaml::parse($yaml);
        $this->body   = $body;
    }

    /**
     * Parse file, split YAML header and parse it.
     */
    public static function parseFile(string $file)
    {
        $content = file_get_contents($file);

        $pattern = '/[\s\r\n]---[\s\r\n]/s';
        $parts = preg_split($pattern, PHP_EOL . ltrim($content));

        if (count($parts) < 3) {
            return [[], $content];
        }

        return new YamlHeaderDocument(
            $file,
            trim($parts[1]),
            implode(PHP_EOL . "---" . PHP_EOL, array_slice($parts, 2))
        );
    }

    public function header(string $key = null)
    {
        if ($key) {
            return $this->header[$key] ?? null;
        }

        return $this->header;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function file(): string
    {
        return $this->file;
    }

    public function __get($key)
    {
        return $this->header[$key];
    }
}
