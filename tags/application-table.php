<table class="table table-bordered sortable">
  <thead>
    <tr>
      <th><?= $title ?></th>
      <th>Strukturierungssprache</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($PAGES->select(['application'=>$application]) as $id => $item) {
      $for = $item['for'] ?? []; ?>
    <tr>
      <td><?= $TAGS->link(['id' => $id]) ?></td>
      <td><?=
        implode(', ', array_map(
            function ($format) use ($PAGES, $TAGS) {
                return $TAGS->link(['id'=>$format,'short'=>true]);
            },
            is_array($for) ? $for : [$for]
        )); ?></td>
    </tr>
  <?php } ?>
  </tbody>
</table>
