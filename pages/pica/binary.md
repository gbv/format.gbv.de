---
title: Binäres PICA
model: pica
base: bytes
---

**Binäres PICA** ist eine Kodierung von [PICA+](../pica). Datensätze werden
durch Bytecode `1D` (*Information Separator 3*), Felder durch Bytecode `1E`
(*Information Separator 2*) und Unterfelder durch Bytecode `1F` (*Information
Separator 1*) getrennt.

Das Format unterscheidet sich von [normalisiertem PICA+](normalized) in der
Trennung aufeinander folgender Datensätze.

Eine vergleichbare Kodierung von [MARC](../marc) ist [ISO MARC](../marc/iso).
