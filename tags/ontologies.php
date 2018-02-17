<?php

$url = 'http://lov.okfn.org/dataset/lov/api/v2/vocabulary/list';
$data = file_get_contents($url);
$data = json_decode($data, true);

$vocabularies = [];
foreach ($data as $voc) {
    $prefix = $voc['prefix'];
    $vocabularies[$prefix] = [
        'prefix' => $prefix,
        'title' => $voc['titles'][0]['value']
    ];
}
ksort($vocabularies);

echo '<div class="list-group">';

foreach ($vocabularies as $voc) { ?>
    <a href="lov/<?=$voc['prefix']?>" class="list-group-item list-group-item-action">
    <div class="row">
      <div class="col-1"><code><?=$voc['prefix']?></code></div>
      <div class="col"><?=$voc['title']?></div>
    </div>
    </a>
<?php } ?>
</div>

