<?php declare(strict_types=1);

namespace GBV;

use Symfony\Component\Yaml\Yaml;

/**
 * Split YAML header from a document and parse it.
 */
class YamlHeader
{
    public static function parseFile(string $file)
    {
        $content = file_get_contents($file);

        $pattern = '/[\s\r\n]---[\s\r\n]/s';
        $parts = preg_split($pattern, PHP_EOL . ltrim($content));

        if (count($parts) < 3) {
            return [[], $content];
        }

        return [
            Yaml::parse(trim($parts[1])),
            implode(PHP_EOL . "---" . PHP_EOL, array_slice($parts, 2))
        ];
    }
}
