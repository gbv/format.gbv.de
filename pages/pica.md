---
title: PICA-Format
short: PICA
application: structure
---

Das PICA-Format ist das Datenbankformat der Katalogsysteme CBS und LBS.  Die
interne Form **PICA+** hat dabei eindeutige Entsprechungen im
Katalogisierungsformat **Pica3**. Weitere Informationen stehem um Verbundwiki
unter [PICA-Format](https://verbundwiki.gbv.de/display/VZG/PICA-Format),
[PICA+](https://verbundwiki.gbv.de/pages/viewpage.action?pageId=40009828) und
[PICA-XML](https://verbundwiki.gbv.de/display/VZG/PICA+XML+Version+1.0).  Die
Bedeutung einzelner Felder und Unterfelder im PICA-Format hängt von konkreten
Katalogisierungsrichtlinien ab.

Eine ausführliche Beschreibung des PICA-Format und seiner Anwendung liefert das
Handbuch ["Einführung in die Verarbeitung von PICA-Daten"](https://pro4bib.github.io/pica/).

### Katalogisierungsrichtlinien

Die Sammlung von einzelnen PICA-Formaten und dazu gehörigen
[Avram-Schemas](schema/avram) ist noch im Aufbau.

<list-formats profiles="pica"/>

### Serialisierungen

PICA+ wird in verschiedenen [Kodierungen](code) verwendet, die sich alle
verlustfrei ineinander umwandeln lassen.

<list-encodings model="pica" title=""/>


<list-formats over="pica" title="Abfragesprachen"/>

<list-formats for="pica" application="schema" title="Schemasprachen"/>

<list-formats for="pica" application="patch" title="Änderungssprachen"/>

