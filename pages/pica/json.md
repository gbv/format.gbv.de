---
title: PICA JSON
model:
- pica
- pica/patch
base: json
---

**PICA JSON** ermöglicht die Kodierung von [PICA+ Daten](../pica) in
[JSON](../json).

Jedes PICA-Feld wir dabei als JSON-Array kodiert. Das erste Array-Element ist
die vierstellige PICA+ Feldnummer, das zweite Element die Occurrence (falls
vorhanden) oder `null`. Es folgen abwechselnd Unterfeld-Code und
Unterfeld-Inhalt. Ein PICA-Datensatz ist in PICA JSON ein JSON-Array aller
Felder. 

<example highlight="json">
[
  [ "003@", null, "0", "12345X" ],
  [ "021A", null, "a", "Ein Buch", "h", "zum Lesen" ]
]
</example>

Die gleiche Struktur kann als [MARC JSON](../marc/json) zur Kodierung von
[MARC](../marc) verwendet werden.

Optional kann als letztes Array-Element eine Feld-Markierung in Form eines
nicht-alphanumerischen Zeichen angefügt werden, um unter Anderem [PICA
Patch](patch) Format in JSON abzubilden:

<example highlight="json">
[
  [ "003@", null, "0", "12345X", " " ],
  [ "021A", null, "a", "Ein Buch", "h", "zum Lesen", "-" ],
  [ "021A", null, "a", "Ein gutes Buch", "h", "zum Lesen und Genießen", "+" ]
]
</example>

## APIs

Über die unAPI-Schnittstelle der VZG kann PICA JSON mit dem Parameter
`format=picajson` abgerufen werden.
