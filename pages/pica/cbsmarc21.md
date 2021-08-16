---
title: CBS MARC 21 PICA+ format
profiles: pica
model: marc/cbsmarc21
application:
  - bibliographic
  - authority
homepage: https://help.oclc.org/Metadata_Services/CBS_MARC_21_database
---

OCLC definiert für Installationen der CBS-Datenbank ein Katalogisierungsformat auf Grundlage von [MARC](marc). Intern werden Datensätze jedoch in [PICA](pica) gespeichert. Das interne Datenformat zur Speicherung von [CBS MARC 21](marc/cbsmarc21) ist daher das Format **CBS MARC 21 PICA+**.

Beispiel: Die ISBN steht bei [Titeldaten in MARC 21](marc/bibliographic) und in CBS MARC 21 in MARC-Feld `020`. In CBS MARC 21 PICA+ wird dieses Feld als `015K` abgespeichert während die ISBN sowohl im [K10plus-Format](pica/k10plus) als auch im [ZDB-Format](pica/zdb) in PICA-Feld `004A` steht.
