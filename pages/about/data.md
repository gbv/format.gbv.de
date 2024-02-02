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

### Anwendungen

Datenformate sind (angegeben mit `application`) einer oder mehreren **Anwendungen** zugeordnet. Diese Zuordnung ist in einigen Fällen formal, in anderen eher pragmatisch. Anwendungen bilden daher eine grobe **Klassifikation von Datenformaten** in:

- [Bibliographische Datenformate](../application/bibliographic)
- [Normdatenformate](../application/authority)
- [Dokumentformate](../application/documents)
- [Datentypen](../application/datatype)
- [Schema-Sprache](../schema/language)
- [Abfragesprachen](../application/query)
- [Änderungsformate](../application/patch)
- [Strukturierungssprachen](../structure)
- [Datenmodelle](../model)

### Datenmodelle und Kodierungen

**[Datenmodelle](../model)** sind abstrakte Datenformate, die nicht direkt
sondern nur in Form von Kodierungen genutzt werden können.
**[Kodierungen/Serialisierungen](../code)** sind konkrete Datenformate, die

- auf einer [Strukturierungssprache](../structure) als ihr *Grundformat* basieren (angegeben mit `base`) und
- ein Datenmodell umsetzen (angegeben mit `model`).

Die Anwendungen von Kodierungen werden *nicht* explizit angegeben sondern ergeben sich aus den Anwendungen des referenzierten Datenmodells.

Bei vielen Datenformaten wird allerdings nicht zwischen Datenmodell und
Kodierung unterschieden. So bezieht sich bspw. [JSON](../json) sowohl auf
das JSON-Modell als auch auf die Standard-Syntax von JSON.

<!--
Die Kodierungen eines Modells sind zwar eigene Datenformate, lassen sich aber als unterschiedliche Serialisierungen des gleichen Datenmodells auf einer höheren Abstraktionsebene auch als ein Datenformat auffassen.
-->

<!-- base, for, schemas, element -->

<!--
Hat ein Format mehrere Grundformate (Beispiel [HTML](../html)) oder ist das Grundformat selber ein [Datenmodell](../model), so ist auch das Format abstrakt.
-->

<!--
Dabei können **Schemas** verwendet werden, um die Formate oder Teilaspekte von ihnen formal zu definieren. Jedes Schemas ist im Format einer *Schema-Sprache* für die jeweilige *Strukturierungssprache* definiert.
-->

<!--
### Beispiele

- [CSL-JSON](../csl-json) basiert auf dem Grundformat [JSON](../json).
- [Reguläre Ausdrücke](../schema/regex) basieren auf dem abstrakten Grundformat [Zeichenkette](../chars).
- ...
-->

### Weitere Beziehungen zwischen Datenformaten

*Abfragesprachen* und *Änderungsformaten* beziehen sich (mit `for`) auf genau eine *Strukturierungssprache* als ihr Zielformat.

Datenformate können, gekennzeichnet mit der Eigenschaft `subsetof`, Teilmengen anderer Formate sein. In diesem Fall werden das Grundformat (`base`) und das Zielformat (`for`) vom übergeordneten Format übernommen.

Formate können auch Bestandteil anderer Formate bilden (angegeben mit `element`). Insbesondere abstrakte **Datentypen** werden oft als Teil in komplexere Formate integriert.

**Anwendungsprofile** sind Formate die andere Formate (angegeben mit `profiles`) einschränken und/oder erweitern.

<!--note>
Schemasprachen, Abfragesprachen und Änderungsformate beziehen sich immer auf eine oder mehrere Datenformate mittels der Eigenschaft `for`.
(In RDF können auch `restricts`, `queries`, `modifies` verwendet werden).
</note-->

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
