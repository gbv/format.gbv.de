---
title: Datenmodell
schemas:
  - url: data/schema.json
    type: json-schema
---

Derzeit werden alle Einträge und Seiten der [Formatdatenbank](../about) als
[Markdown](../markdown)-Dateien mit [YAML](../yaml)-Header verwaltet. Ein Link
auf die Datei eines Eintrags befindet sich jeweils unten Rechts ("Quelltext").
Die Daten werden auf der Webseite angereichert in [JSON-LD](../rdf/json-ld)
bereitgestellt ("Daten").  Das [Datenmodell](../model) der Einträge und die
Ontologie seiner Abbildung in [RDF](../rdf) befindet sich noch in Entwicklung.
Die Struktur ist unter Anderem mit Hilfe eines
[JSON-Schemas](../schema/json-schema) beschrieben.

## Bestandteile

*Vorläufige Übersicht über die wesentlichen Entitäten der Formatdatenbank*

* Digitale Dokumente/Objekte
* Datenformate
  * [Strukturierungssprachen](../structure)
  * [Schema-Sprache](../schema/language)
  * [Bibliographische Datenformate](../application/bibliographic)
  * [Normdatenformate](../application/authority)
  * [Dokumentformate](../application/documents)
* [Kodierungen](../code)
* Anwendungsprofile
* Datenmodelle
  * Abstrakte Modelle
    * Implizite Modelle
    * Standards (explizite Modelle)
    * [Schemas](../schema) (formale Modelle)

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


<!--
*Vorläufige Übersicht über die Beziegungsarten zwischen den Entitäten*

* Jedes Datenformat (`Format`) kann `application`
* `for`
* `base`
* `model`
* `profiles`

~~~
{ ?schema data:for ?base ; data:describes ?format } 
=> { ?format data:base ?base }
~~~

-->
