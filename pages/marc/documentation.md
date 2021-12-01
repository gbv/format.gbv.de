---
title: MARC Documentation Format
model: marc
base: chars
homepage: https://www.loc.gov/marc/specifications/specrecstruc.html
---

Das **MARC Documentation Format** wird in der Dokumentation von [MARC 21-Formaten](../marc) für Beispiele von MARC-Datensätzen und -Feldern verwendet. Wie bei [MARCMaker](maker) und [MARC Line](line) steht jedes Feld in einer Zeile und Unterfelder werden mit `$` eingeleitet. Die Raute (`#`) steht für das Leerzeichen als Indikator, so dass zur Anzeige auch eine nicht-proportionale Schriftart verwendet werden kann.

<example>
000   01471cjm a2200349 a 4500
001   5674874
035 ##$a(OCoLC)123456
245 10$aTitle :$bsubtitle.
856 4#$uhtp://example.org
</example>
