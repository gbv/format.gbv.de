---
title: PICA-Importformat
model: pica
base: bytes
---

Das **PICA-Importformat** ist eine Kodierung von [PICA+](../pica) im *normalized file format*, die vor allem zum Import in die CBS-Datenbank verwendet wird. Das Format sollte allerdings nicht mit [normalisiertem PICA](normalized) verwechselt werden.

Einzelne Felder stehen im Importformat wie bei [PICA Plain](plain) in eigenen Zeilen (Zeilenumbruch Bytecode `0A`), allerdings werden sie zusätzlich mit Bytecode `1E` eingeleitet und der Unterfeld-Indikator ist Bytecode `1F`. Vor jedem Datensatz steht Bytecode `1E` gefolgt von einem Zeilenumbruch und zwischen Datensätzen können Kommentare (alles von `#` bis Zeilenende) und Leere Zeilen stehen.
