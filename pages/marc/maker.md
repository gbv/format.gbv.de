---
title: MARCMaker
model: marc
base: bytes
homepage: http://www.loc.gov/marc/makrbrkr.html
---

Beim Zeilenbasierten MARCMaker-Format werden Unterfelder werden [MARC](../marc)-Felder durch `=` und Unterfelder durch `$` eingeleitet.. Der Leader kann durch `=000` oder `=LDR` gekennzeichnet sein. Der Backslash (`\`) steht für das Leerzeichen als Indikator.

<example>
=000   01471cjm a2200349 a 4500
=001   5674874
=035 \\$a(OCoLC)123456
=245 10$aTitle :$bsubtitle.
=856 4\$uhtp://example.org
</example>
