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
    $syntax = ($coding['id'] == $coding['model']);
?>
    <tr>
      <td><?= $TAGS->link(['id' => $coding['id'], 'syntax' => $syntax]); ?></td>
      <td><?= $TAGS->link(['id' => $coding['model']]); ?></td>
      <td><?= $TAGS->link(['id' => $coding['base']]); ?></td>
    </tr>
<?php } ?>
  </tbody>
</table>
