---
title: Hintergrund
---

<!--
Auf dieser Seiten sollen verschiedene Datenformate dokumentiert werden.
-->

Die Formatdatenbank ist ein Angebot der Stabstelle Forschung und Entwicklung
der [Verbundzentrale des GBV](//www.gbv.de) unter Leitung von Jakob Voß.
Weitere Angaben zur Anbieterkennzeichnung entnehmen sie bitte dem **[Impressum
der VZG-Webseite](//www.gbv.de/impressum).**

## Motivation

Diese Seite entstand Anfang 2018 um eine maschinenlesbare Version der
gemeinsamen [PICA-Katalogisierungsrichtlinien](pica) von GBV und SWB zu
schaffen. Die Übersicht verschiedener Datenformate ist inspiriert von der
Formatdatenbank aus [Was sind und was sollen Bibliothekarische
Datenformate](http://www.allegro-c.de/formate/formate.htm) von Bernhard
Eversberg. Die theoretischen Grundlagen und Inhalte der Metadatenbeschreibung
basieren auf der Dissertation [Describing Data
Patterns](http://aboutdata.org/).

In der Praxis werden Modell, Standard, Schema, Format und Kodierung häufig
nicht sauber getrennt. Dies gilt insbesondere für die feldbasierten
Bibliotheksformate [MARC](marc), [PICA](pica), [MAB](mab) und
[allegro](allegro). Beim *MARC Format für Bibliografische
Daten* lassen sich beispielsweise folgende Ebenen unterscheiden:

* Ein **Modell** bibliographischer Inhalte die erfasst werden sollen (Titel, Autoren, Publikationen...) 
* Der [MARC-Standard für bibliografische Daten](marc/bibliographic) als **Anwendungsformat**
* Der formalisierbare Teil dieses MARC-Standards in Form eines **Schemas**
* MARC als allgemeines **[Strukturierungsformat](structure)** aus Feldern und Unterfeldern
* Eine MARC-**Kodierung** wie zum Beispiel [MARC-XML](marc/xml)

Die Formatdatenbank soll dabei Helfen, Licht in den Dschungel von Datenformaten
zu bringen.

## Inhalt und Beteiligte

Quellcode ist [auf GitHub](https://github.com/gbv/format.gbv.de).  Anregungen,
Korrekturen und Verbesserungsvorschläge [sind dort herzlich
willkommen](https://github.com/gbv/format.gbv.de/issues). Das Datenmodell
zur Beschreibung von Formaten [befindet sich noch in Entwicklung](data).

Die Inhalte sind ohne weitere Bedingungen oder Gewährleistungen nachnutzbar
(siehe [Lizenz](license)).

Beteiligt an den Inhalten dieser Seite sind oder waren unter Anderem:

* Jakob Voß (Technische Leitung, Programmierung und Dokumentation)
* Karsten Achterrath (Programmierung)
* Péter Király und Carsten Klee (Avram-Schemas)
* Uschi Klute (Recherche zu MARC-Varianten)
* VZG und BSZ (K10plus Online-Hilfe)
* Linked Open Vocabularies (Daten zu RDF-Formaten)

## Verwandte Projekte

* Soweit möglich sind alle Einträge mit [Wikidata](https://www.wikidata.org/) verknüpft. 
* Das [Just Solve the File Format Problem](http://fileformats.archiveteam.org)-Wiki und
  die [PRONOM file format registry](https://www.nationalarchives.gov.uk/PRONOM/) sammeln
  Informationen zu Dateiformaten.
* [Linked Open Vocabularies] sammelt [RDF](rdf)-Ontologien. Das Verzeichnis 
  [ist hier eingebunden](rdf/lov).
* Im [Basel Register of Thesauri, Ontologies & Classifications (BARTOC)](https://bartoc.org/)
  sind auch Datenmodelle enthalten, beispielsweise [BIBFRAME](bibframe).
* Das [Seeing Standards](http://jennriley.com/metadatamap/) Poster von Jenn Riley enthält
  105 Metadaten-Standards, die letzendlich alle in der Formatdatenbank verzeichnet werden sollen
