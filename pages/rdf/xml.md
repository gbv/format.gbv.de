---
title: RDF/XML
wikidata: Q48940
model: rdf
base: xml
mimetype: application/rdf+xml
---

**RDF/XML** ist eine Serialisierung von [RDF](../rdf) auf Basis von [XML](../xml).

<example highlight="xml">
<?xml version="1.0" encoding="utf-8" ?>
&lt;rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
         xmlns:skos="http://www.w3.org/2004/02/skos/core#">
  &lt;skos:Concept rdf:about="http://example.org/terminology/P">
    &lt;skos:prefLabel xml:lang="de">Frieden&lt;/skos:prefLabel>
    &lt;skos:notation>P&lt;/skos:notation>
    &lt;skos:narrower>
      &lt;rdf:Description>
        &lt;skos:prefLabel xml:lang="en">world peace&lt;/skos:prefLabel>
      &lt;/rdf:Description>
    &lt;/skos:narrower>
  &lt;/skos:Concept>
&lt;/rdf:RDF>
</example>
