---
title: Culture Graph Interchange Format
short: CGIF
homepage: https://nfdi4culture.de/go/E3712
application: bibliographic
base: rdf
profiles: rdf/voc/schema
---

Das **Culture Graph Interchange Format (CGIF)** wurde im Rahmen des NFDI-Konsortiums [NFDI4Culture](https://nfdi4culture.de/) zur Aggregation von Forschungsdaten aus dem Kulturbereich entwickelt. Das Format basiert im Wesentlichen auf [schema.org](rdf/voc/schema), kann also auch als Anwendungsprofil der schema.org Ontologie verstanden werden.

Das Datenmodell besteht im Wesentlichen aus Sammlungen (`schema:DataCatalog`) und darin enthaltenen bibliographischen Beschreibungen (`schema:DataFeedItem`) bestehend aus IRI, Titel, kontrollierter Verschlagwortung und ggf. zeitlicher Einordnung.

Eine bevorzugte RDF-Serialisierung existiert nicht, in den Beispielen wird [JSON-LD](rdf/json-ld) verwendet.
