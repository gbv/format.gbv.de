---
title: IIIF Presentation Model
homepage: http://iiif.io/api/presentation/2.1/
application: documents
model: iiif-presentation
---

Das Datenmodell der **IIIF Presentation API** bildet strukturelle Informationen
von Bild-orientierten Dokumenten ab. Dazu zählen beisielsweise die Anordnung
von Seiten und die Art ihrer Darstellung. Die übliche Kodierung des Modells ist
[RDF](rdf) per [JSON-LD](rdf/json-ld).

Neben einigen eigenen RDF-Properties greift die RDF-Kodierung das IIIF
Presentation Model unter anderem auf Konzepte von EXIF, Dublin Core und dem
[Open Annotation Data Model](rdf/voc/oa) zurück.

Ein vergleichbares Format für Text-orientierte Dokumente ist METS.

![CC-BY IIIF Consortium](img/iiif-presentation.png)
