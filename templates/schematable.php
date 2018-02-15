<?php

$formats = new \GBV\Formats('../templates');

?>
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
    <?= \View::instance()->render('pagelink.php','',['meta'=>$schema]) ?>
    </td>
    <td><?php
    
    $for = $schema['for'] ?? [];
    $for = is_array($for) ? $for : [ $for ];

    echo implode(', ', array_map(
        function($format) use ($formats) {
            $meta = $formats->pageMeta($format);
            return \View::instance()->render('pagelink.php','',['meta'=>$meta]); 
        }, $for));
?>
</td>
  </tr>
<?php } ?>
  </tbody>
</table>

