---
title: RDF
wikidata: Q54872
---

Das **Resource Description Framework (RDF)** ist ein Graph-basiertes
Datenformat.  Die Grundeinheit von RDF-Daten sind Tripel bestend aus Subjekt,
Prädikat und Objekt.  Das RDF-Format bildet die Grundlage des so genannten
Semantic Web und von Linked (Open) Data. RDF-Daten können in verschiedenen
*Serialisierungen* vorkommen, die sich verlustfrei ineinander umwandeln lassen.

## RDF-Formate

RDF-Formate basieren auf RDF-Ontologien oder werden mit Ontologien
gleichgesetzt. Eine Besonderheit von RDF ist dass sich Daten verschiedener
Ontologien kombinieren lassen.

Die meisten relevanten Ontologien sind bei [Linked Open Vocabularies (LOV)](rdf/lov)
verzeichnet und können unter `/rdf/lov/{prefix}` mit ihrem jeweiligen Prefix abgerufen werden.

<!-- 
- Ontologien bauen aufeinander auf
- Formate hängen auch von Anwendungsprofilen ab
    - application profiles, data shapes, SHACL, ShEx...
    - implizite profile
-->

[Linked Open Vocabularies (LOV)]: http://lov.okfn.org/

## RDF-Serialisierungen

Die wichtigsten RDF-Serialisierungen sind:

<codelist model="rdf" />
