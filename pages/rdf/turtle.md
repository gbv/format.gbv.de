---
title: Turtle
wikidata: Q114409
model: rdf
base: unicode
mimetype: text/turtle
---

**Turtle** ist eine Serialisierung von [RDF](../rdf).

<example>
@prefix skos: &lt;http://www.w3.org/2004/02/skos/core#> .
@prefix : &lt;http://example.org/terminology/> .

:P a skos:Concept ;
  skos:prefLabel "Frieden"@de, "peace"@en ;
  skos:altLabel "Friede"@de ;
  skos:notation "P" ;
  skos:scopeNote
    "Abwesenheit von Gewalt, Angst und anderen Störungen"@de ,
    "lack of violent conflict or violence"@en ;
  skos:narrower [
    skos:prefLabel "Weltfrieden"@de , "world peace"@en ] .
</example>
