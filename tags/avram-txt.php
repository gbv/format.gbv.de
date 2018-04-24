<?php

$title       = $schema['title'] ?? '';
$description = $schema['description'] ?? '';

if ($title !== '') {
    echo "$title\n";
    echo str_repeat('=', strlen($title)) . "\n\n";
}

if ($description !== '') {
    echo "$description\n\n";
}

echo "* = (sub-)field repeatable\n\n";

foreach ($schema['fields'] ?? [] as $tag => $field) {
    echo "#$tag" . ($field['repeatable'] ?? false ? '*' : ' ');
    if ($field['label'] ?? null) {
        echo " = " . $field['label'];
    }
    echo "\n";

    foreach ($field['subfields'] ?? [] as $code => $sf) {
        echo "  $$code" . ($sf['repeatable'] ?? false ? '*' : ' ');
        if ($sf['label'] ?? '') {
            echo " " . $sf['label'];
        }
        echo "\n";
    }
    echo "\n";
}
