<?php declare(strict_types=1);

namespace Controller;

use mytcms\JSON;

/**
 * Show Avram Schema.
 */
class Avram
{
    public static function sendJson($data)
    {
        $options = JSON_PRETTY_PRINT | JSON_FORCE_OBJECT;
        (new JSON($data))->sendJson($options);
    }

    public static function sendText($schema)
    {
        $txt = '';

        if (isset($schema['title'])) {
            $txt .= $schema['title'] . "\n"
                . str_repeat('=', strlen($schema['title'])) . "\n";
        }

        $description = $schema['description'] ?? '';
        if ($description !== '') {
            $txt .= "\n$description\n\n";
        }

        $txt .= "* = (sub-)field repeatable\n\n";

        foreach ($schema['fields'] ?? [] as $tag => $field) {
            $txt .= "#$tag" . ($field['repeatable'] ?? false ? '*' : ' ');
            if ($field['label'] ?? null) {
                $txt .= " = " . $field['label'];
            }
            $txt .= "\n";
            foreach ($field['subfields'] ?? [] as $code => $sf) {
                $txt .= "  $$code" . ($sf['repeatable'] ?? false ? '*' : ' ');
                if ($sf['label'] ?? '') {
                    $txt .= " " . $sf['label'];
                }
                $txt .= "\n";
            }
            $txt .= "\n";
        }

        header("Content-Type: text/plain; charset=utf-8");
        header('Access-Control-Allow-Origin *');
        echo $txt;
    }
}
