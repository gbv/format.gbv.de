---
title: CSL-JSON
homepage: https://github.com/citation-style-language/schema#csl-json-schema
description:
  en: Metadata of bibliographic items to be processed with citation style language
base: json
application: bibliographic
mimetype: application/vnd.citationstyles.csl+json
schemas:
  - url: https://resource.citationstyles.org/schema/v1.0/input/json/csl-data.json
    type: json-schema
---

Die **Citation Style Language (CSL)** beinhaltet ein Datenmodell für
bibliographische Informationen, um daraus Literaturangaben und -Listen zu
erstellen. Das Datenmodell wird in der Regel als [JSON](json)-Format verwendet
(auch etwas ungenauer als "**Citeproc JSON** bezeichnet).

<example highlight="json">
    {
      "id": "http://example.org/id/1234",
      "type": "book",
      "title": "Das Schloss",
      "publisher": "Wolff",
      "publisher-place": "München",
      "language": "de",
      "author": [
        { "family": "Kafka", "given": "Franz" }
      ],
      "issued": { "date-parts": [ [ "1926" ] ] }
    }
</example>
