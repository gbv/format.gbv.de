---
title: Tab-separated values
short: TSV
profiles: csv
wikidata: Q3513566
homepage: https://www.iana.org/assignments/media-types/text/tab-separated-values
base: chars
---

Bei dieser Variante von [CSV](csv) werden einzelne Datensätze durch
Zeilenumbrüche und Felder durch Tabulatoren (`\t`) getrennt. Tabulatoren und
Zeilenumbrüche selbst können daher in den Daten nicht vorkommen.

Die genaue Form von TSV hängt davon ab, welche Zeichenkodierung verwendet wird,
welche Zeichen(folgen) als Zeilenumbrüche gelten und ob die die erste Zeile
Feldnamen enthält.

<example>
title	author	year
The Hitchhiker's Guide to the Galaxy	Douglas Adams	1978
Das Schloß	Franz Kafka	1926
Ein Buch zum Lesen
</example>
