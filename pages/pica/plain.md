---
title: PICA Plain
model: pica
base: bytes
---

**PICA Plain** ist eine leicht lesbare Kodierung von [PICA+](../pica). Datensätze und Felder werden durch Zeilenumbrüche (Bytecode `0A`) getrennt und Unterfelder mit `$` eingeleitet.

Enthält ein Unterfeld das Zeichen `$` so wird dieses verdoppelt (`$$`).

<example>
003@ $012345X
021A $aEin Buch$hzum Lesen
</example>

Die Erweiterung "Annotated PICA" erlaubt zu jedem Feld eine Feld-Markierung anzugeben. Die Markierung besteht aus einem Zeichen das nicht alphanumerisch sein darf (also alles außer `A-Z`, `a-z`, `0-9`) und wird durch ein Leerzeichen vom restlichen Feld getrennt. Ein Anwendungsfall ist die Angabe von Änderungen an PICA-Datensätzen:

<example>
  003@ $012345X
- 021A $aEin Buch$hzum Lesen
+ 021A $aEin gutens Buch$hzum Lesen und Genießen
</example>

## APIs

Über die unAPI-Schnittstelle der VZG kann PICA JSON mit dem Parameter `format=pp` abgerufen werden.
