<table class="table sortable">
  <thead>
    <tr>
      <th>Format</th>
      <th>Schema</th>
      <th>Schemasprache</th>
    </tr>
  </thead>
  </tbody>
<?php

foreach ($PAGES->select(['schemas'=>null]) as $id => $page) {
    $first = 0;
    foreach ($page['schemas'] as $schema) {
        echo "<tr>";
        if (!$first++) {
            echo "<td>".$TAGS->link(['id'=>$id])."</td>";
        } else {
            echo "<td></td>";
        }
        $url = $schema['url'];
        echo "<td><a href='$url'>$url</a></td>";
        $type = 'schema/'.$schema['type'];
        echo "<td>".$TAGS->link(['id'=>$type])."</td>";
        echo "</tr>";
    }
}
?>
</tbody>
</table>
