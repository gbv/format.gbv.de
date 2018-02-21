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
    $model = $PAGES->get($coding['model']);
    $base  = $PAGES->get($coding['base']);

    $syntax = ($coding['page'] == $model['page']);

    echo "<tr>";
    echo "<td>" . $TAGS->pagelink(['meta' => $coding, 'syntax' => $syntax]) . "</td>";
    echo "<td>" . $TAGS->pagelink(['meta' => $model]) . "</td>";
    echo "<td>" . $TAGS->pagelink(['meta' => $base]) . "</td>";
    echo "</tr>";
}
    ?>
  </tbody>
</table>
