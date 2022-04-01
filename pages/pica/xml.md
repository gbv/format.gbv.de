---
title: PICA XML
description:
  en: XML serialization of PICA+
homepage: https://verbundwiki.gbv.de/display/VZG/PICA+XML+Version+1.0
model: pica
base: xml
schemas:
- url: /data/pica-xml-v1-1.xsd
  type: xsd
  version: '1.1'
- url: /data/pica.dtd
  type: dtd
  version: '1.1'
- url: /data/pica-xml-v1-0.xsd
  type: xsd
  version: '1.0'
---

**PICA XML** ist eine an der VZG entwickelte Kodierung von [PICA+](../pica) in [XML](../xml). 

PICA XML Version 1.1 erweitert Version 1.1 um die Möglichkeit dreistelliger
Occurrences und um optionale Attribute `label`, `url` und `pica3` zur
Dokumentation von Feldern und Unterfeldern mit Angaben aus einem
[Avram-Schema](../schema/avram). Der XML-Namensraum
`info:srw/schema/5/picaXML-v1.0` bleibt gleich.

<example highlight="xml">
    &lt;record xmlns="info:srw/schema/5/picaXML-v1.0">
      &lt;datafield tag="003@">
        &lt;subfield code="0">12345X&lt;/subfield>
      &lt;/datafield>
      &lt;datafield tag="021A">
        &lt;subfield code="a">Ein Buch&lt;/subfield>
        &lt;subfield code="h">zum Lesen&lt;/subfield>
      &lt;/datafield>
    &lt;/record>
</example>
