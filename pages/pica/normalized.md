---
title: Normalisiertes PICA
model: pica
base: bytes
---

**Normalisiertes PICA** ist eine Kodierung von [PICA+](../pica). Jeder Datensatz steht in einer Zeile (Datensätze werden durch Bytecode `0A` getrennt), Felder werden durch Bytecode `1E` beendet und Unterfelder durch Bytecode `1F` eingeleitet.

Das Format unterscheidet sich von [binärem PICA+](binary) lediglich in der Trennung aufeinander folgender Datensätze.

Normalisiertes PICA ist zu unterscheiden vom [PICA-Importformat](import), das manchmal ebenfalls als "normalisiert" bezeichnet wird.
