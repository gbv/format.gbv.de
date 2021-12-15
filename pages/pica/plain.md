---
title: PICA Plain
model:
- pica
- pica/patch
base: bytes
---

**PICA Plain** ist eine leicht lesbare Kodierung von [PICA+](../pica). Datensätze und Felder werden durch Zeilenumbrüche (Bytecode `0A`) getrennt und Unterfelder mit `$` eingeleitet.  Enthält ein Unterfeld das Zeichen `$` so wird dieses verdoppelt (`$$`).

<example>
003@ $012345X
021A $aEin Buch$hzum Lesen
</example>

Optional können einzelne Felder durch ein nicht-alphanumerisches ASCII-Zeichen (also alle Zeichen außer `A-Z`, `a-z`, `0-9`) markiert werden. Die Markierung muss am Anfang der Zeile stehen und wird durch ein Leerzeichen vom restlichen Feld getrennt. Ohne Markierung kann standardmäßig das Leerzeichen als Markierungszeichen angenommen werden.  Diese als **Annotated PICA** bezeichnete Erweiterung wird allerdings nicht von allen Programmen unterstützt. Anwendungen von Annotated PICA sind die Markierung von Fehlern und unbekannten Feldern bei der Validierung (Markierungszeichen `!` und `?`) und das [PICA Änderungsformat](patch) (Markierungszeichen `+` und `-`).

<example>
&nbsp; 003@ $012345X
- 021A $aEin Buch$hzum Lesen
+ 021A $aEin gutes Buch$hzum Lesen und Genießen
</example>

## APIs

Über die unAPI-Schnittstelle der VZG kann PICA JSON mit dem Parameter `format=pp` abgerufen werden.
