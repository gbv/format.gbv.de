---
title: Datenformate
---

Alle **Datenformate** lassen sich grob in Strukturierungssprachen,
Schemasprachen und Anwendungsformate unterteilen. 

**Allgemeine Datenstrukturierungssprachen** ermöglichen es Daten in kleinere
Einheiten zu unterteilen und miteinander in Beziehung zu setzen. Jede
Strukturierungssprache basiert auf einem allgemeinen Ordnungsprinzip (Felder,
Tabelle, Graph, Folge, Hierarchie):

<!-- see =Q24451526 -->

| |
|
| [JSON](json), [XML](xml), [SGML](sgml)    | Hierarchisch oder Dokumentenorientiert |
| [RDF](rdf), [YAML](yaml)                  | Graph- oder Netzwerkbasiert |
| [CSV](csv), TSV, SQL                      | Tabellenbasiert |
| [INI](ini) | Feldbasiert |
| [Unicode](unicode), [Bytes](bytes)        | Zeichenkettenbasiert |

Alle Datenformate lassen sich durch **[Kodierung](code)** in einer oder
mehreren Strukturierungssprachen ausdrücken. Beispielsweise ist
[JSON-LD](rdf/json-ld) eine Kodierung von [RDF](rdf) in [JSON](json). Zur
Vereinfachung werden Formate oft mit ihrer üblichsten Kodierung gleichgesetzt,
beispielsweise das JSON-Format mit der JSON-Syntax.

Jedes Format basiert auf einem **Modell** von Inhalten, die mit diesem Format
ausgedrückt werden sollen. **Anwendungsformate** legen die Struktur von Daten
für konkrete Arten von Inhalte fest. Beispielsweise sind bibliographische
Datenformate Anwendungsformate für bibliographische Inhalte.

Die Beziehung zwischen Modell und Format wird idealerweise durch einen
**Standard** festgelegt. Zur exakten Beschreibung von Standards dienen in
Schemasprachen kodierte [**Schemas**](schema). Beispielsweise können in JSON
kodierte Formate mit [JSON Schema](schema/json-schema) beschrieben werden. In
der Regel lassen sich Standards aber nur zum Teil so exakt formalisieren.

In der Praxis werden Modell, Standard, Schema, Format und Kodierung häufig
nicht sauber getrennt. Dies gilt insbesondere für die feldbasierten
Bibliotheksformate [MARC](marc), [PICA](pica), [MAB](mab) und
[allegro](allegro). Beim *MARC Format für Bibliografische
Daten* lassen sich beispielsweise folgende Ebenen unterscheiden:

* Ein Modell bibliographischer Inhalte die erfasst werden sollen (Titel, Autoren, Publikationen...) 
* Der MARC-Standard für bibliographische Inhalte (<http://www.loc.gov/marc/bibliographic/>)
* Der formalisierbare Teil dieses MARC-Standards
* Das MARC-Format als allgemeines Strukturierungsformat aus Feldern und Unterfeldern
* Eine MARC-Kodierungen wie zum Beispiel MARC-XML

<div class="alert alert-warning" role="alert">
Die Seite befindet sich noch im Aufbau!
</div>

