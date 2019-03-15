---
title: MARCMaker
model: marc
base: bytes
homepage: http://www.loc.gov/marc/makrbrkr.html
---

Bei der Kodierung von [MARC](../marc) im MARCMaker-Format werden Unterfelder
durch `$` getrennt und Felder durch `=` eingeleitet. Der Leader kann durch
`=000` oder `=LDR` gekennzeichnet sein.

## Beispiel

~~~json
=000   01471cjm a2200349 a 4500
=001   5674874
=035 \\$9(DLC)   93707283
=245 10$aTitle :$bsubtitle.
~~~
