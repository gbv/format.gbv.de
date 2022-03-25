---
title: Avram Schema Language
short: Avram
homepage: http://format.gbv.de/schema/avram/specification
description:
  en: Schema language for MARC and related formats such as PICA and MAB
base: json
model: schema/avram
application: schema
for:
  - marc
  - mab
  - pica 
schemas:
  - url: http://format.gbv.de/schema/avram/schema.json
    type: json-schema
---

**Avram** ist eine [Schemasprache](../schema) für [MARC](../marc) und verwandte
Formate wie [PICA](../pica), [MAB](../mab) und [allegro](../allegro).

Die **[Avram Spezifikation](avram/specification)** definiert die Schemasprache
auf Basis von [JSON](../json).

## Implementierungen

* Perl-Modul [MARC::Schema](https://metacpan.org/release/MARC-Schema) zur
  Validierung von MARC-Daten
* Perl-Modul [PICA::Data](https://metacpan.org/pod/PICA::Schema) zur
  Validierung von PICA-Daten

<list-schemas format="avram"/>

