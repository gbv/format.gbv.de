---
title: MARCXML
description: XML serialization of MARC21
homepage: https://www.loc.gov/standards/marcxml/
created: 2002
model: marc
base: xml
schemas:
  - url: https://www.loc.gov/standards/marcxml/schema/MARC21slim.xsd
    type: xsd
---

**MARC XML** ist eine [XML](../xml)-Kodierung von [MARC](../marc).

<example highlight="xml">
    &lt;record xmlns="http://www.loc.gov/MARC21/slim">
      &lt;leader>01471cjm a2200349 a 4500&lt;/leader>
      &lt;controlfield tag="001">5674874&lt;/controlfield>
      &lt;datafield tag="035" ind1=" " ind2=" ">
        &lt;subfield code="9">(DLC)   93707283&lt;/subfield>
      &lt;/datafield>
      &lt;datafield tag="245" ind1="1" ind2="0">
        &lt;subfield code="a">Title:&lt;/subfield>
        &lt;subfield code="b">subtitle.&lt;/subfield>
      &lt;/datafield>
    &lt;/record>
</example>
