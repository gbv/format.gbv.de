<?php declare(strict_types=1);

namespace mytcms;

use Symfony\Component\Yaml\Yaml;

class Util
{

    public static function loadJsonYaml(string $file, bool $assoc = false)
    {
        $data = file_get_contents($file);
        if (preg_match('/\.yaml$/', $file)) {
            $option = $assoc ? 0 : Yaml::PARSE_OBJECT_FOR_MAP;
            return Yaml::parse($data, $option);
        } else {
            return json_decode($data, $assoc);
        }
    }
}
