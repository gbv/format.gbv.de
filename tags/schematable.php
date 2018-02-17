<table class="table table-bordered sortable">
  <thead>
    <tr>
      <th>Schemasprache</th>
      <th>Format</th>
    </tr>
  </thead>
  <tbody>
<?php foreach ($formats->listPages('schema/') as $page) {
    $schema = $formats->pageMeta($page); ?>
  <tr>
    <td>
    <?= $TAGS->call('pagelink', ['meta'=>$schema]) ?>
    </td>
    <td><?php
    
    $for = $schema['for'] ?? [];
    $for = is_array($for) ? $for : [ $for ];

    echo implode(', ', array_map(
        function ($format) use ($formats, $TAGS) {
            $meta = $formats->pageMeta($format);
            return $TAGS->call('pagelink', ['meta'=>$meta]);
        },
        $for
    ));
?>
</td>
  </tr>
<?php } ?>
  </tbody>
</table>

