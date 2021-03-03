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
      <td><?php
        $bases = is_array($coding['base']) ? $coding['base'] : [ $coding['base'] ];
        echo implode(', ', array_map(function ($id) use ($TAGS) {
            return $TAGS->link(['id' => $id]);
        }, $bases));
            ?></td>
    </tr>
<?php } ?>
  </tbody>
</table>
