---
title: Kodierungen
shorttitle: Codes
---

**Kodierungen** sind Vorschriften zur Abbildung eines Datenformates oder -Modells in einem anderen Datenformat.

Kodierungen deren Zielformat auf einer Reihenfolge basiert (beispielsweise eine Folge von Zeichen) werden auch **Serialisierung** genannt. 

## Beispiele

Kodierung              | (Ausgangs-)Modell | (Ziel-)Format
-----------------------|-------------------|---------------
[PICA XML](pica/xml)   | [PICA](pica)      | [XML](xml)
XML Syntax             | [XML](xml)        | Unicode
Normalized PICA        | [PICA](pica)      | Bytes
JSON Syntax            | [JSON](json)      | Unicode
[JSON-LD](rdf/json-ld) | [RDF](rdf)        | [JSON](json)
[Turtle](rdf/turtle)   | [RDF](rdf)        | Unicode
UTF-8                  | Unicode           | Bytes

<!--

## Eigenschaften von Kodierungen

Letzendlich basieren alle Kodierungen über eine oder mehrere Ebenen auf Bytes
(und damit wiederum auf Bits), denn dies ist die einzige Form in der digitale
Daten physikalisch vorliegen.

Kodierungen können in beide Richtungen angewandt werden. Im Englischen wird
zwischen *encoding* (Kodierung, vom Modell zum Format) und *decoding*
(Dekodierung, vom Format zum Modell) unterschieden.

Kodierung sollten für jedes mögliche Dokument des Ausangs-Modells mindestens
ein Dokument im Ziel-Format bereitstellen. Anderfalls ist die Kodierung
*unvollständig*.

Während es bei den meisten Kodierung mehrere alternative Möglichkeiten der
Abbildung gibt (beispielsweise die mögliche Verwendung oder Auslassung
zusätzliche Leerzeichen), sollte die Dekodierung immer *eindeutig* sein.

Im Mathematischen Sinne (also auch so wie Computer die Daten verarbeiten) ist
die Abbildung einer Kodierung eher umgekehrt definiert: als
Dekodierungs-Funktion vom Format zum kodierten Modell.  Die Funktion ist dabei
meist nur partiell, es gibt also Dokumente die sich nicht dekodieren lassen
weil sie der Kodierungsvorschrift nach fehlerhaft sind.

Falls eine Kodierung/Dekodierung in beide Richtungen eindeutig ist, wird sie
auch als *Normalisierung* bezeichnet. Eine Folge normalisierender Kodierungen
bis zur Ebene von Bytes ist notwendig um bei Bedarf gleiche Dokumente anhand
ihrer Prüfsummen identifizieren zu können. In der Praxis ist dies bislang
jedoch nur für die wenigsten Formate möglich.

-->
