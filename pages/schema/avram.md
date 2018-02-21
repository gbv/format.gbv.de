---
title: Avram Schema Language
short: Avram
base: json
model: schema/avram
for:
  - marc
  - mab
  - pica 
---

**Avram** ist eine [Schemasprache](../schema) für [MARC](../marc) und verwandte
Formate wie [PICA](../pica), [MAB](../mab) und [allegro](../allegro).

Die **[Avram Spezifikation](avram/specification)** definiert die Schemasprache
auf Basis von [JSON](../json) und stellt ein [JSON Schema](json-schema) zur
Validierung von Avram-Schemas bereit:

* <https://format.gbv.de/schema/avram/schema.json>

## Implementierungen

* Perl-Modul [MARC::Schema](https://metacpan.org/release/MARC-Schema) zur
  Validierung von MARC-Daten
* Perl-Modul [PICA::Data](https://metacpan.org/pod/PICA::Schema)zur
  Validierung von PICA-Daten

