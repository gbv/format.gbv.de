<table class="table table-bordered sortable">
  <thead>
    <tr>
      <th>Schemasprache</th>
      <th>Strukturierungssprache</th>
    </tr>
  </thead>
  <tbody>
<?php foreach ($PAGES->select(['for'=>null]) as $id => $schema) { ?>
  <tr>
    <td><?= $TAGS->link(['id' => $id]) ?></td>
    <td><?= implode(', ', array_map(
        function ($format) use ($PAGES, $TAGS) {
            return $TAGS->link(['id'=>$format,'short'=>true]);
        },
        is_array($schema['for']) ? $schema['for'] : [ $schema['for'] ]
    )); ?></td>
  </tr>
<?php } ?>
  </tbody>
</table>

