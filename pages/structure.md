---
title: Strukturierungssprachen
short: Strukturen
wikidata: Q24451526
---

**Allgemeine Datenstrukturierungssprachen** ermöglichen es Daten in kleinere
Einheiten zu unterteilen und miteinander in Beziehung zu setzen. Jede
Strukturierungssprache basiert auf allgemeinen Ordnungsprinzipien:

| Ordnungsprinzip | Strukturierungssprachen | Beispiele für Anwendungsformate
|
| Felder | [INI](ini), [MARC](marc)¹, [PICA](pica)¹ | [MARC 21 für bibliographische Daten](marc/bibliographic), [BibTeX](bibtex)¹
| Hierarchie/Dokument | [JSON](json), [XML](xml), [SGML](sgml), [YAML](yaml)², [TOML](toml), [SDLang](sdlang)... | [TEI](tei)
| Tabelle | [CSV](csv), [SQL](sql)³, [Wikibase Tabular Data](wikibase-tabular-data)... | [Excel](excel)
| Graph/Netzwerk | [RDF](rdf), [YAML](yaml)², [SQL](sql)³ | [Ontologien](rdf/voc)
| Zeichenkette | [Zeichenkette](chars), [Unicode](unicode), [Bytes](bytes) | [ISBD](isbd)

¹Bei feldbasierten Formaten wird oft nicht zwischen ihrer allgemeinen Struktur und konkreten Anwendungen wie Normdaten und bibliographischen Daten unterschieden.

²YAML ermöglicht prinzipiell Graph-Strukturen, in der Praxis werden jedoch meist
nur Hierarchien verwendet.

³SQL basiert auf Tabellen, wird aber unter Verwendung von Primär- und Fremdschlüsseln oft für Netzwerkstrukturen eingesetzt.

Weitere Datenstrukturierungssprachen sind durch grundlegende **Datentypen** von
Programmiersprachen und Data Binding Languages (ASN.1, Thrift, Avro, [Protocol
Buffers](protobuf)...) gegeben.

Folgende Datenstrukturierungssprachen sind in der Formatdatenbank erfasst:

<list-formats application="structure"/>
