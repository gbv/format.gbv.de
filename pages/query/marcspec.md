---
title: MARCspec
over: marc
application: query
homepage: http://marcspec.github.io/MARCspec/marc-spec.html
created: 2014
creator: Carsten Klee
---

Mit MARCspec-Ausdrücken können einzelne Felder, Unterfelder u.Ä. Bestandteiles eines [MARC](../marc)-Datensatzes referenziert werden.

<example title="Beispiele">
LDR/0-4
100 
254$a
254$a-c
880^1
020$c{$a}
020$c{$q=\paperback}
</example>

