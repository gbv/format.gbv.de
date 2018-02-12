<?php declare(strict_types=1);

namespace GBV;

use GBV\YamlHeaderDocument;

/**
 * Set of encodings/decodings.
 */
class Codings
{
    public $codes = [];

    public static $files = []; // TODO: use Cache

    public static $names = [
        'model' => 1,
        'format' => 2
    ];

    private function __construct()
    {
    }

    public function codings(array $select = [])
    {
        $codings = [];
        if (!count($select)) {
            $codings = $this->codes;
        } else {
            foreach ($this->codes as $coding) {
                $keep = true;
                foreach ($select as $name => $value) {
                    $id = static::$names[$name] ?? '';
                    if ($select[$name] !== $coding[$id]['local']) {
                        $keep = false;
                    }
                }
                if ($keep) {
                    $codings[] = $coding;
                }
            }
        }
        return $codings;
    }

    public static function metadata($localName, $base)
    {
        if (!isset(static::$files[$localName])) {
            $file = "$base/$localName.md";
            $meta = [ 'title' => $localName ];
            if (file_exists($file)) {
                $doc = YamlHeaderDocument::parseFile($file);
                $meta = $doc->header();
                $meta['local'] = $localName;
            }
            static::$files[$localName] = $meta;
        }
        return static::$files[$localName];
    }

    public static function fromDir(string $base)
    {
        /**
         * In der Datei `codes.csv` sind Kodierung mit ihrem Ausgangsmodell und Zielformat
         * erfasst. Alle drei Angaben (`code`, `model`, und `format`) sind Verweise auf
         * einzelne Seiten dieser Webseite. Wenn `code` und `model` gleich sind, handelt
         * es sich bei der Kodierung um die Standard-Syntax des Modells für die keine
         * eigene Seite existiert.
         **/

        $file = "$base/code/codes.csv";

        $lines = file($file);
        array_shift($lines); // header

        $codings = new Codings();

        foreach ($lines as $line) {
            $line = preg_split('/\s*,\s*/', rtrim($line));
            $coding = [
                static::metadata($line[0], $base),
                static::metadata($line[1], $base),
                static::metadata($line[2], $base)
            ];
            if ($coding[0]['local']
                && $coding[0]['title'] == $coding[1]['title']) {
                $coding[0]['title'] .= ' Syntax';
            }
            $codings->codes[$line[0]] = $coding;
        }

        return $codings;
    }
}
