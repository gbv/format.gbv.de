<?php

if ($application) {
    $application = array_map(
        function ($id) {
            return $id == 'structure' || $id == 'model'
                ? $id : "application/$id";
        },
        is_array($application) ? $application : [$application]
    );
} elseif ($for) {
    $application = 'schema/language';
}

$styles = [
    'url' => function ($url) {
        return "<a href='$url'>$url</a>";
    },
    'link' => function ($base) use ($TAGS) {
        return $TAGS->link(['id'=>$base]);
    },
    'qid' => function ($qid) {
        // TODO: use JavaScript to add label and link to Wikipedia
        return "<a href='https://tools.wmflabs.org/hub/$qid'>$qid</a>";
    },
    'bartoc' => function ($id) {
        return "<a href='https://bartoc.org/en/node/$id'>http://bartoc.org/en/node/$id</a>";
    },
    'schema' => function ($schema) use ($TAGS) {
        $id = 'schema/'.$schema['type'];
        $url = $schema['url'];
        $html =
            "<a href='$url'>$url</a>"
            . ' ('. $TAGS->link(['id'=>$id,'short'=>true]) . ')';
        if ($schema['type'] == 'avram') {
            $html .= ": <a href='?schema=$url&format=txt'>show as text</a>";
        }
        if (isset($schema['version'])) {
            $html .= ' version '.$schema['version'];
        }
        return $html;
    },
];

use Symfony\Component\Yaml\Yaml;

$fields = Yaml::parse(file_get_contents(__DIR__.'/infobox.yaml'));

if ($schemas && $for) {
    $fields['schemas']['label'] = 'Metaschema';
    $fields['schemas']['plural'] = 'Metaschemas';
}

$infobox = [];
foreach ($fields as $name => $field) {
    $value = ${$name};
    if (!$value) {
        continue;
    }

    if (!is_array($value)) {
        $value = [$value];
    }

    if (isset($field['style'])) {
        $value = array_map($styles[$field['style']], $value);
    }

    $label = $field[count($value) > 1 ? 'plural' : 'label'] ?? $field['label'];

    if ($field['tooltip'] ?? $field['icon'] ?? false) {
        $label = $TAGS->icon($field) . $label;
    }
    $infobox[$label] = implode('<br>', $value);
}


if (count($infobox)) { ?>
  <table class="table table-sm">
    <?php foreach ($infobox as $key => $value) {
        echo "<tr><td>$key</td><td>$value</td></tr>\n";
    } ?>
  </table>
<?php }
