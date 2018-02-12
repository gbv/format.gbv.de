<?php

$codings = \GBV\Codings::fromDir('../templates')->codings($select ?? []);

if (count($codings)) { ?>
<ul>
<?php foreach ($codings as $c) { ?>
  <li>
    <a href="<?=$c[0]['local']?>"><?=$c[0]['title']?></a>
  </li>
<?php } ?>
</ul>
<?php }
