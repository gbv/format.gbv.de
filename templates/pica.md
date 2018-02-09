---
title: PICA-Format
shorttitle: PICA
---

Das PICA-Format ist das Datenbankformat der Katalogsysteme CBS und LBS.  Die
interne Form **PICA+** hat dabei eindeutige Entsprechungen im
Katalogisierungsformat **Pica3**. Weitere Informationen stehem um Verbundwiki
unter [PICA-Format](https://verbundwiki.gbv.de/display/VZG/PICA-Format),
[PICA+](https://verbundwiki.gbv.de/pages/viewpage.action?pageId=40009828) und
[PICA-XML](https://verbundwiki.gbv.de/display/VZG/PICA+XML+Version+1.0).  Die
Bedeutung einzelner Felder und Unterfelder im PICA-Format hängt von konkreten
Katalogisierungsrichtlinien ab.

## Katalogisierungsrichtlinien

Folgende PICA-Formate können anhand ihrer Katalogisierungsrichtlinien hier über eine API abgerufen werden:

* [RDA von GBV und SWB](pica/rda)

## Serialisierungen

* "Plain" PICA+ (Datensätze und Felder mit Bytecode `0A` und Unterfelder mit `$` getrennt, `$` in Werten wird verdoppelt)
* Normalisiertes PICA+ (Datensätze mit Bytecode `0A`, Felder mit `1E` und Unterfelder mit `1F` getrennt)
* Binäres PICA+ (Datensätze mit Bytecode `1D`, Felder mit `1E` und Unterfelder mit `1F` getrennt)
* [PICA XML](pica/xml)
* [PICA JSON](pica/json)
* PPXML (XML-Variante der Deutschen Nationalbibliothek)

