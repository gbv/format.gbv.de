---
title: PPXML
model: pica
base: xml
schemas:
- url: http://files.dnb.de/standards/formate/ppxml-1.0.xsd
  type: xsd
---

**PPXML** ist eine an der Deutschen Nationalbibliothek verwendete Kodierung von [PICA+](../pica) in [XML](../xml). Alternativ kann [PICA XML](xml) verwendet werden.

## Beispiel

~~~xml
<record xmlns="http://www.oclcpica.org/xmlns/ppxml-1.0">
  <global opacflag="" status="">
    <tag id="003@" occ="">
    <subf id="0">12345X</ppxml:subf>
  </tag>
  <tag id="021A" occ="">
    <subf id="a">Ein Buch</ppxml:subf>
    <subf id="h">zum Lesen</ppxml:subf>
  </tag>
</tag>
~~~
