<?php

$fields = [
    'created'   => 'erstellt',
    'modified'  => 'aktualisiert',
    'creator'   => 'Autor',
    'publisher' => 'Herausgeber',
#    'base'      => ['Format', '<a href="%s'],
#    'homepage' => 'Homepage',
#    'wikidata' => 'Wikidata/pedia',
];

$infobox = [];
foreach ($fields as $name => $value) {
    if (${$name}) {
        if (is_array($value)) {
            $infobox[$value[0]] = ${$name}; # TODO
        } else {
            $infobox[$value] = ${$name};
        }
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
        $items[] =
            "<a href='$url'>$url</a>"
            . ' ('. $TAGS->link(['id'=>$id,'short'=>true]) . ')';
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
    <!--thead>
      <tr><th colspan="2"><?=$title?></th></tr>
    </thead-->
    <tbody>
<?php foreach ($infobox as $key => $value) {
    echo "<tr><td>$key</td><td>$value</td></tr>\n";
} ?>
    </tbody>
  </table>
<?php }
