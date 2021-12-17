<table class="table table-bordered sortable">
  <thead>
    <tr>
      <th>Kodierung</th>
      <th>Modell</th>
      <th>Format</th>
    </tr>
  </thead>
  <tbody>
<?php
$codings = $PAGES->select(['model' => null, 'base' => null]);
foreach ($codings as $coding) {
    $model = is_array($coding['model']) ? $coding['model'] : [ $coding['model'] ];
    $base  = is_array($coding['base'])  ? $coding['base'] :  [ $coding['base'] ];
    $syntax = in_array($coding['id'], $model);
    ?>
    <tr>
      <td><?= $TAGS->link(['id' => $coding['id'], 'syntax' => $syntax]); ?></td>
      <td><?php
        echo implode(', ', array_map(function ($id) use ($TAGS) {
            return $TAGS->link(['id' => $id]);
        }, $model));
            ?></td>
      <td><?php
        echo implode(', ', array_map(function ($id) use ($TAGS) {
            return $TAGS->link(['id' => $id, 'short' => true]);
        }, $base));
            ?></td>
    </tr>
<?php } ?>
  </tbody>
</table>
