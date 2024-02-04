---
title: Labeled Property Graph
application: model
---

Das **(Labeled) Property Graph Modell** definiert Property-Graphen bestend aus:

- Einer Menge von **Knoten**
  - Jeder Knoten kann eine oder mehrere **Labels** haben
  - Jeder Knoten kann **Properties** haben

- Einer Menge von **Kanten**, die jeweils zwei Knoten verbinden
  - Jede Kante kann eine oder mehrere **Labels** haben
  - Jede Kante kann **Properties** haben

Properties sind Mengen von Key-Value-Paaren wobei einem Key eine nicht-leere Menge von Werten zugeordnet ist. 

Werte können je nach konkreter Anwendung des Modells Zeichenketten oder andere getypte Werte sein (z.B. Zahlen).

Das Modell ist Grundlage von Graphdatenbanken und verwandten Sprachen wie SQL/PSQL, Cypher, GDL und PG.

