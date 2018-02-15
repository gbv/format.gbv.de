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
        function pageLink($meta, $syntax=false) {
            $view = \View::instance();
            return $view->render('pagelink.php', '', 
                ['meta'=>$meta, 'syntax'=>$syntax]);
        }

        $formats = new \GBV\Formats('../templates');
        foreach ($formats->codings() as $coding) {
            $model = $formats->pageMeta($coding['model']);
            $base  = $formats->pageMeta($coding['base']);

            $syntax = ($coding['page'] == $model['page']);

            echo "<tr>";
            echo "<td>" . pageLink($coding, $syntax) . "</td>";
            echo "<td>" . pageLink($model) . "</td>";
            echo "<td>" . pageLink($base) . "</td>";
            echo "</tr>";
        }
    ?>
  </tbody>
</table>
