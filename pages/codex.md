---
title: Codex Metadata Model
short: Codex
homepage: https://wiki.folio.org/pages/viewpage.action?pageId=1415393
application: model
---

**Codex** ist ein abstraktes Datenmodell zur Integration von Metadaten
im Rahmen des Bibliotheksystems [FOLIO](https://www.folio.org/). 
Das Modell basiert grob auf [BIBFRAME](bibframe) und Dublin Core. Die
Dokumentation enthält einige Mappings mit RDA und [MARC](marc).

![Entitätstypen des Codex Datenmodells](https://wiki.folio.org/download/attachments/1415393/Codex%20Metadata%20Model%202017-07-07.png?version=1&modificationDate=1503009830000&api=v2)

Im Detail definiert das Datenmodell fünf Entitätstypen, die jeweils durch eine Menge von Datenfeldern und ein [JSON Schema](schema/json-schema) beschrieben sind:

* [package](codex/package)
* [instance](codex/instance)
* [item](codex/item)
* [coverage](codex/coverage)
* [location](codex/location)

