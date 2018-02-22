<?php

$fields = [
    'created'   => 'erstellt',
    'modified'  => 'aktualisiert',
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

if (count($infobox)) { ?>
  <table class="table table-sm">
    <thead>
      <tr><th colspan="2"><?=$title?></th></tr>
    </thead>
    <tbody>
<?php foreach ($infobox as $key => $value) {
    echo "<tr><td>$key</td><td>$value</td></tr>\n";
} ?>
    </tbody>
  </table>
<?php }
