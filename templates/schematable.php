<?php

$codings = \GBV\Codings::fromDir('../templates');
$schemas = $codings->schemas();

?>
<table class="table table-bordered sortable">
  <thead>
    <tr>
      <th>Schemasprache</th>
      <th>Format</th>
    </tr>
  </thead>
  <tbody>
<?php foreach ($schemas as $schema) {
    $formats = $schema['for'] ?? [];
    $formats = is_array($formats) ? $formats : [ $formats ];
?>
  <tr>
    <td>
      <a href="schema/<?=$schema['local']?>">
        <?=$schema['title']?>
        <?=isset($schema['short']) ? ' ('.$schema['short'].')' : ''?>
      </a>
    </td>
    <td><?=implode(', ', array_map(
        function($format) use ($codings) {
            $format = $codings->metadata($format, '../templates');
            $title = $format['short'] ?? $format['title'];
            return "<a href='".$format['local']."'>$title</a>";
        }, $formats))?></td>
  </tr>
<?php } ?>
  </tbody>
</table>

