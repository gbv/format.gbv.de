---
title: PICA Plain
model: pica
base: bytes
---

**PICA Plain** ist eine leicht lesbare Kodierung von [PICA+](../pica). Datensätze und Felder werden durch Zeilenumbrüche (Bytecode `0A`) getrennt und Unterfelder mit `$` eingeleitet.

Enthält ein Unterfeld das Zeichen `$` so wird dieses verdoppelt (`$$`).

## Beispiel

~~~
003@ $012345X
021A $aEin Buch$hzum Lesen
~~~

## APIs

Über die unAPI-Schnittstelle der VZG kann PICA JSON mit dem Parameter
`format=pp` abgerufen werden.
