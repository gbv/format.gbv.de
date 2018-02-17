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
    foreach ($formats->codings() as $coding) {
        $model = $formats->pageMeta($coding['model']);
        $base  = $formats->pageMeta($coding['base']);

        $syntax = ($coding['page'] == $model['page']);

        echo "<tr>";
        echo "<td>" . $TAGS->call('pagelink', ['meta' => $coding, 'syntax' => $syntax]) . "</td>";
        echo "<td>" . $TAGS->call('pagelink', ['meta' => $model]) . "</td>";
        echo "<td>" . $TAGS->call('pagelink', ['meta' => $base]) . "</td>";
        echo "</tr>";
    }
    ?>
  </tbody>
</table>
