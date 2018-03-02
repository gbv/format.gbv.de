<table class="table table-bordered sortable">
  <thead>
    <tr>
      <th>Schemasprache</th>
      <th>Format</th>
    </tr>
  </thead>
  <tbody>
<?php foreach ($PAGES->select([], 'schema/') as $id => $schema) { ?>
  <tr>
    <td>
    <?= $TAGS->link(['id' => $id]) ?>
    </td>
    <td><?php

    $for = $schema['for'] ?? [];
    $for = is_array($for) ? $for : [ $for ];

    echo implode(', ', array_map(
        function ($format) use ($PAGES, $TAGS) {
            return $TAGS->link(['id'=>$format]);
        },
        $for
    ));
?>
</td>
  </tr>
<?php } ?>
  </tbody>
</table>

