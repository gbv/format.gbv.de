---
title: Normalisiertes PICA
model: pica
base: bytes
---

**Normalisiertes PICA** ist eine Kodierung von [PICA+](../pica). Datensätze
werden durch Zeilenumbrüche (Bytecode `0A`), Felder durch Bytecode `1E` und
Unterfelder durch Bytecode `1F` getrennt.

Das Format unterscheidet sich von [binärem PICA+](binary) in der Trennung
aufeinander folgender Datensätze: Jeder Datensatz steht in einer Zeile.
