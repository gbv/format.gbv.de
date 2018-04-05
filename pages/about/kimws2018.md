---
title: Ein strukturiertes Verzeichnis von Datenformaten
creator: Jakob Voß
created: '2018-04-11'
---

*Lightning Talk für den [KIM Workshop 2018](https://wiki.dnb.de/display/DINIAGKIM/KIM+Workshop+2018) über die Formatdatenbank [format.gbv.de](http://format.gbv.de/)*

*Slides-Ansicht unter [`kimws2018.html`](kimws2018.html)*

---

# format.gbv.de

* Verzeichnis von Datenformaten und Anwendungsprofilen
* Schwerpunkt bibliographische Formate und Normdaten (**Metadaten**)
* Primär deutsche Kurzerklärungen
 
# Inhalt 1

* Modelle: [BIBFRAME](../bibframe), [CIDOC-CRM](../cidoc-crm)...
* Formate: [MARC](../marc), [PICA](../pica), [TEI](../tei)...
* Profile: [MARC21 Authority](../marc/authority), [GND-PICA](../pica/gnd)...

# Inhalt 2

* Kodierungen
    * [JSON](../json) →  [HJSON](../hjson), [CSON](../cson)...
    * [RDF](../rdf) →  [RDF/XML](../rdf/xml), [JSON-LD](../rdf/json-ld)...
    * ...
* Schemas
    * [XML](../xml) →  [XSD](../schema/xsd), [RELAX NG](../schema/relax-ng)...
    * [MARC](../marc), [PICA](../pica), [MAB](../mab) →  [Avram](../schema/avram)
    * ...

# Aufbau

* Formatname
* Kurzbeschreibung (ein Absatz)
* Homepage
* Wikidata-ID
* Beziehungen zu anderen Formaten

# Beziehungen zwischen Formaten

* [MARC](../marc) 
* →  [MARCXML](../marc/xml) 
* →  [Avram](../schema/avram)
* →  [MARC21 Authority](../marc/authority) 
* →  `083 $2` *DDC Edition number (non-repeatbale)*

# Ausblick

* Formatbeschreibungen in JSON-LD/RDF
* Abgleich mit anderen Verzeichnissen\
  (LOV, Wikidata, BARTOC, PRONOM...)
* Mitarbeit erwünscht!\
  <https://github.com/gbv/format.gbv.de>

