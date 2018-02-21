---
title: Datenformate
---

**Datenformate** lassen sich grob in Strukturierungssprachen,
Anwendungsformate, Kodierungen und Schemasprachen unterteilen. 

**[Anwendungsformate](application)** legen die
Struktur von Daten für konkrete Arten von Inhalte fest. Beispielsweise sind
bibliographische Datenformate Anwendungsformate für bibliographische Inhalte.

**[Kodierung](code)** drücken Datenformate und -Modelle in
**[Strukturierungssprachen](structure)** aus. Beispielsweise ist
[JSON-LD](rdf/json-ld) eine Kodierung von [RDF](rdf) in [JSON](json). Zur
Vereinfachung werden Formate oft mit ihrer üblichsten Kodierung gleichgesetzt,
beispielsweise das JSON-Format mit der JSON-Syntax.

Jedes Format basiert auf einem **[Modell](model)** von Inhalten, die mit diesem
Format ausgedrückt werden sollen.  Die Beziehung zwischen Modell und Format
wird idealerweise durch einen **Standard** festgelegt. Zur exakten Beschreibung
von Standards dienen in Schemasprachen kodierte [**Schemas**](schema).
Beispielsweise können in JSON kodierte Formate mit [JSON
Schema](schema/json-schema) beschrieben werden. In der Regel lassen sich
Standards aber nicht vollständig mit Schemas formalisieren.

