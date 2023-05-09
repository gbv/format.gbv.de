---
title: EntityXML
application: authority
homepage: https://entities.pages.gwdg.de/entityxml/
base: xml
created: 2023
schemas:
- url: https://gitlab.gwdg.de/entities/entityxml/-/raw/master/schema/entityXML.rng
  type: relax-ng
---

**EntityXML** ist ein [XML](xml)-Format zur Speicherung und den Austausch von Normdaten mit der Gemeinsamen Normdatei (GND). Das Format wurde im Rahmen des NFDI Konsortium *Text+* entwickelt, um Daten an die GND zu liefern.

EntityXML basiert auf der [GND Ontologie](rdf/voc/gndo) und weiteren etablierten RDF-Ontologien. Zusätzlich können eigene XML-Elemente verwendet werden. Zur Validierung dient ein [RelaxNG](schema/relax-ng)-Schema mit zusätzlichen [Schematron](schema/schematron)-Regeln. 

Rund um das Format werden Werkzeuge für den XML-Editor *Oxygen* [zur Verfügung gestellt](https://gitlab.gwdg.de/entities/entityxml), darunter auch ein XSLT-Skripte zur Konvertierung nach [JSON](json) und [MARC Authorities](marc/authority).
