---
title: PPXML
model: pica
base: xml
schemas:
- url: http://files.dnb.de/standards/formate/ppxml-1.0.xsd
  type: xsd
---

**PPXML** ist eine an der Deutschen Nationalbibliothek verwendete Kodierung von [PICA+](../pica) in [XML](../xml). Eine Besonderheit von PPXML gegenüber den anderen PICA-Serialisierungen ist die explizite Trennung von bibliographischer (`<global>`), lokaler (`<local>`) und Exemplarebene (`<copy>`).

Alternativ kann [PICA XML](xml) verwendet werden.

<example highlight="xml">
  &lt;record xmlns="http://www.oclcpica.org/xmlns/ppxml-1.0">
    &lt;global opacflag="" status="">
      &lt;tag id="003@" occ="">
        &lt;subf id="0">12345X&lt;/ppxml:subf>
      &lt;/tag>
      &lt;tag id="021A" occ="">
        &lt;subf id="a">Ein Buch&lt;/ppxml:subf>
        &lt;subf id="h">zum Lesen&lt;/ppxml:subf>
      &lt;/tag>
    &lt;/global>
  &lt;/record>
</example>
