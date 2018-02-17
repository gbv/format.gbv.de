---
title: PICA JSON
model: pica
base: json
---

**PICA JSON** ermöglicht die Kodierung von [PICA+ Daten](../pica) in
[JSON](../json).

Jedes PICA-Feld wir dabei als JSON-Array kodiert. Das erste Array-Element ist
die vierstellige PICA+ Feldnummer, das zweite Element die Occurrence (falls
vorhanden) oder `null`. Es folgen abwechselnd Unterfeld-Code und
Unterfeld-Inhalt. Ein PICA-Datensatz ist in PICA JSON ein JSON-Array aller
Felder. 

## Beispiel

~~~json
[
  [ "003@", null, "0", "12345X" ],
  [ "021A", null, "a", "Ein Buch", "h", "zum Lesen" ]
]
~~~

## APIs

Über die unAPI-Schnittstelle der VZG kann PICA JSON mit dem Parameter
`format=picajson` abgerufen werden.
