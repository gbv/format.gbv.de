---
title: Datenmodell
schemas:
  - url: http://format.gbv.de/data/schema.json
    type: json-schema
---

Derzeit werden alle Einträge und Seiten der [Formatdatenbank](../about) als
[Markdown](../markdown)-Dateien mit [YAML](../yaml)-Header verwaltet. Ein Link
auf die Datei eines Eintrags befindet sich jeweils unten Rechts ("Quelltext").
Die Daten werden auf der Webseite angereichert in [JSON-LD](../rdf/json-ld)
bereitgestellt ("Daten").  Das [Datenmodell](../model) der Einträge und die
Ontologie seiner Abbildung in [RDF](../rdf) befindet sich noch in Entwicklung.
Die Struktur ist unter Anderem mit Hilfe eines
[JSON-Schemas](../data/schema.json) beschrieben.

## Datenmodell

*Das Datenmodell der Formatdatenbank befindet sich noch in Entwicklung. Hier eine vorläufige Übersicht:*

### Entitäten

<!-- application -->

Datenformate sind einer oder mehreren **Anwendungen** zugeordnet. Diese Zuordnung ist in einigen Fällen formal, in anderen eher pragmatisch. Anwendungen bilden daher eine grobe **Klassifikation von Datenformaten** in:

- [Bibliographische Datenformate](../application/bibliographic)
- [Normdatenformate](../application/authority)
- [Dokumentformate](../application/documents)
- [Datentypen](../application/datatype)
- [Schema-Sprache](../schema/language)
- [Abfragesprachen](../application/query)
- [Änderungsformate](../application/patch)
- [Strukturierungssprachen](../structure)

<!-- model -->

Darüber hinaus lassen sich **konkrete Datenformate** und **abstrakte [Datenmodelle](../model)** mit verschiedenen möglichen **[Kodierungen](../code)** unterscheiden. Die Kodierungen eines Modells sind zwar eigene Datenformate, lassen sich aber als unterschiedliche Serialisierungen des gleichen Datenmodells auf einer höheren Abstraktionsebene auch als ein Datenformat auffassen.

<!-- base, for, schemas -->

Konkrete Datenformate und Kodierungen/Serialisierungen unterscheiden sich von abstrakten Modellen auch dadurch, dass sie immer auf einer allgemeinen [Strukturierungssprache](../structure) basieren. Dabei können **Schemas** verwendet werden, um die Formate oder Teilaspekte von ihnen formal zu definieren. Jedes Schemas ist im Format einer *Schema-Sprache* für die jeweilige *Strukturierungssprache* definiert.

<!-- for, profiles -->

Weitere Beziehungen zwischen Datenformaten gibt es bei *Abfragesprachen* und *Änderungsformaten*, die sich ebenfalls auf genau eine *Strukturierungssprache* beziehen.

<!-- uses ? -->

Darüber hinaus können Datenformate als **Anwendungsprofile** andere Formate einschränken und/oder erweitern oder Bestandteil anderer Formate bilden. Insbesondere **Datentypen** werden oft als Teil in komplexere Formate integriert.

<!--

*Die Beziehung zwischen diesen Entitäten lässt sich vorläufig so beschreiben:*

* Jedes digitale Dokument ist in einem Datenformat ausgedrückt
  \(z.B. ein einfacher Text in [UTF-8](../utf-8))

* Jedes Datenformat kodiert ein Datenmodell (z.B. kodiert [UTF-8](../utf-8)
  das Datenmodell von [Unicode](../unicode)

* Viele Datenmodelle kodieren ebenfalls andere Datenmodelle
  \(z.B. kodiert das Unicode-Modell abstrakte Schriftzeichen).

* Viele Datenformate sind durch Standards beschrieben. Im Idealfall gehören
  dazu Schemas

* Alle Schemas sind selbst wiederum digitale Dokumente
-->

<!--

~~~
{ ?schema data:for ?base ; data:describes ?format } 
=> { ?format data:base ?base }
~~~

-->
