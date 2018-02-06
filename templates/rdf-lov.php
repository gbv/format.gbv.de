
<p>Alle in <a href="http://lov.okfn.org/">Linked Open Vocabularies</a> eingetragene
<a href="../rdf">RDF</a>-Ontologien und -Vokabulare können hier in Kurzansicht abgerufen werden.</p>

<ul>
<?php foreach ($vocables as $vocable) { ?>
    <li><a href="lov/<?=$vocable['prefix']?>"><?=$vocable['title']?></a></li>
<?php } ?>
</ul>
