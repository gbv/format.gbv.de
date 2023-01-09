---
title: CSVW JSON
homepage: https://www.w3.org/TR/csv2json/
base: json
application: structure
---

Die W3C-Recommendation *Generating JSON from Tabular Data on the Web* definiert eine JSON-Serialisierung tabellarischer Daten zur Publikation im WWW. Es gibt zwei Varianten ([Minimal](https://www.w3.org/TR/csv2json/#minimal-mode) und [Standard](https://www.w3.org/TR/csv2json/#standard-mode])).

Im **Minimal mode** wird eine Tabelle als JSON-Array mit einem JSON-Objekt pro Tabellenzeile kodiert. Zeillen können verschiedene Datentypen haben, darunter auch Arrays. Zur Berücksichtigung von Reihenfolge und Datentypen der einzelnen Spalten muss **Standard mode** oder eine anderes Format wie [JSON Table](json-table) verwendet werden.

~~~json
[{
  "title": "The Hitchhiker's Guide to the Galaxy",
  "author": "Douglas Adams",
  "year": 1978
},{
  "title": "Living My Life",
  "author": "Emma Goldman",
  "year": 1931
},{
  "title": "Ein Buch zum Lesen"
}]
~~~

Weitere Information gibt es auf der Seite https://csvw.org/.
