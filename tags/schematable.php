<table class="table table-bordered sortable">
  <thead>
    <tr>
      <th>Schemasprache</th>
      <th>Format</th>
    </tr>
  </thead>
  <tbody>
<?php foreach ($PAGES->select([], 'schema/') as $schema) { ?>
  <tr>
    <td>
    <?= $TAGS->pagelink(['meta'=>$schema]) ?>
    </td>
    <td><?php

    $for = $schema['for'] ?? [];
    $for = is_array($for) ? $for : [ $for ];

    echo implode(', ', array_map(
        function ($format) use ($PAGES, $TAGS) {
            $meta = $PAGES->get($format);
            return $TAGS->pagelink(['meta'=>$meta]);
        },
        $for
    ));
?>
</td>
  </tr>
<?php } ?>
  </tbody>
</table>

