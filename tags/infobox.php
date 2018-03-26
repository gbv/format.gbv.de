<?php

$showURL = function ($url) {
    return "<a href='$url'>$url</a>";
};
$showLink = function ($base) use ($TAGS) {
    return $TAGS->link(['id'=>$base]);
};

$fields = [
    'created'   => ['erstellt'],
    'modified'  => ['aktualisiert'],
    'creator'   => ['Autor'],
    'publisher' => ['Herausgeber'],
    'uri'       => ['URI', $showURL],
    'homepage'  => ['Homepage', $showURL],
    'wikidata'  => ['Wiki(data|pedia)', function ($qid) {
        // TODO: use JavaScript to add label and link to Wikipedia
        return "<a href='https://tools.wmflabs.org/hub/$qid'>$qid</a>";
    }],
    'bartoc'    => ['BARTOC', function ($id) {
        return "<a href='https://bartoc.org/en/node/$id'>http://bartoc.org/en/node/$id</a>";
    }],
    'lov'       => ['LOV', $showURL],
    'base'      => ['Format', $showLink],
    'profiles'  => ['Profil von', $showLink]
];

$infobox = [];
foreach ($fields as $name => $field) {
    $label = $field[0];
    $value = ${$name};
    if ($value) {
        if (!is_array($value)) {
            $value = [$value];
        }
        if (isset($field[1])) {
            $value = array_map($field[1], $value);
        }
        $infobox[$label] = implode('<br>', $value);
    }
}

if ($application) {
    $apps = [];
    foreach (is_array($application) ? $application : [$application] as $app) {
        $apps[] = $TAGS->link(['id'=>"application/$app"]);
    }
    $infobox['Anwendung'] = implode('<br>', $apps);
} elseif ($for) {
    $infobox['Anwendung'] = "<a href='$BASE/schema'>Schemasprache</a>";
}

if (count($schemas ?? [])) {
    $items = [];
    foreach ($schemas as $schema) {
        $id = 'schema/'.$schema['type'];
        $url = $schema['url'];
        $html =
            "<a href='$url'>$url</a>"
            . ' ('. $TAGS->link(['id'=>$id,'short'=>true]) . ')';
        if (isset($schema['version'])) {
            $html .= ' version '.$schema['version'];
        }
        $items[] = $html;
    }
    if (count($items)) {
        $html = implode('<br>', $items);
        $title = count($schemas) > 1 ? 'Schemas' : 'Schema';
        if ($for) {
            $title = 'Metas'.substr($title, 1);
        }
        $infobox[$title] = $html;
    }
}

if (count($infobox)) { ?>
  <table class="table table-sm">
<?php foreach ($infobox as $key => $value) {
    echo "<tr><td>$key</td><td>$value</td></tr>\n";
} ?>
  </table>
<?php }
