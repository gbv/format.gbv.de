<p>Alle in <a href="http://lov.okfn.org/">Linked Open Vocabularies</a> eingetragene
<a href="../rdf">RDF</a>-Ontologien und -Vokabulare können hier in Kurzansicht abgerufen werden.</p>

<div class="list-group">
<?php foreach ($vocabularies as $voc) { ?>
    <a href="lov/<?=$voc['prefix']?>" class="list-group-item list-group-item-action">
    <div class="row">
      <div class="col-1"><code><?=$voc['prefix']?></code></div>
      <div class="col"><?=$voc['title']?></div>
    </div>
    </a>
<?php } ?>
</div>

