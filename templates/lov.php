<h2><?=$fulltitle?></h2>
<?php if ($description) { ?>
<p><?=$description?></p>
<?php } ?>
<?php if (isset($publishers)) { ?>
<p>Publisher: <?=implode(',', $publishers)?></p>
<?php } ?>
<?php if ($uri) { ?>
<p><a href="<?=$uri?>"><?=$uri?></a></p>
<?php } ?>
<?php if ($uri) { ?>
<p>URL: <a href="<?=$url?>"><?=$url?></a></p>
<?php } ?>

<hr>
<p><small>this page: CC-BY <a href="http://lov.okfn.org/dataset/lov/vocabs/<?=$prefix?>">LOV</a></small></p>
