---
title: MARC
wikidata: Q722609
homepage: https://www.loc.gov/marc/
application: structure
modified: 1999
javascript:
  - js/demo.js
---

**Machine-Readable Cataloging (MARC)** ist das wichtigste Format für den
Austausch von Daten zwischen Bibliotheken. Die aktuell übliche Form ist
**MARC21**. Ältere Varianten wie USMARC, UKMARC und CANMARK sind nur noch
historisch von Interesse. Für verschiedene Anwendungen gibt es unterschiedliche
auf MARC basierende Formate. Das Datenmodell von MARC besteht aus:

* einem *Leader* aus 24 Bytes mit festgelegter Bedeutung je Position (siehe beispielsweise [MARC 21 Leader](https://www.loc.gov/marc/bibliographic/bdleader.html))
* einer Liste von *Control fields* mit Feldnummer und Feldinhalt
* einer Liste von *Data fields* mit Feldnummer, Indikatoren und einer Liste von Unterfeldern als Feldinhalt, wobei jedes Unterfeld Unterfeldcode und -Inhalt besteht.

Die in der Regel [nach ISO 2709 kodierte](marc/iso) Variante UNIMARC kann von
seiner Struktur mit MARC gleichgesetzt werden, verfügt allerdings über eigene
Anwendungsformate.

<list-encodings model="marc"/>

## MARC-Formate

<list-formats profiles="marc"/>

Darüber hinaus gibt es viele weitere Erweiterungen und Abweichungen die erst
noch erfasst werden müssen.

## MARC-Schema

Die [Avram Schema Language](schema/avram) ist eine Sprache zur Beschreibung
von MARC-basierten Formaten.
