---
title: JSON
wikidata: Q2063
homepage: https://json.org/
created: 2001
creator: Douglas Crockford
base: unicode
model: json
application: structure
mimetype: application/json
---

**JavaScript Object Notation (JSON)** ist ein hierarchisches Datenformat, das
vor allem in Webanwendungen verwendet wird. Eine übliche Alternative ist
[XML](xml).

<example>
    {
      "value": 42,
      "name": [ "forty-two", "forty two", "42" ],
      "question": null,
      "source": {
        "author": "Douglas Adams",
        "work": "The Hitchhiker's Guide to the Galaxy"
      }
    }
</example>

Zur Spezifikation von JSON-basierten Formaten eignen sich:

<list-formats for="json"/>

Neben der JSON-Syntax kann JSON in verschiedenen Kodierungen ausgedrückt
werden:

<list-formats model="json" exclude="json"/>

Außerdem ist [YAML](yaml) eine Verallgemeinerung von JSON und damit direkt für
JSON-Dokumente einsetzbar. Die binären Strukturierungssprachen [CBOR](cbor),
[BSON](bson) und [MessagePack](msgpack) decken ebenfalls einen Großteil des
JSON-Modells ab.  In der Regel treten JSON-Daten als [I-JSON](i-json) und/oder
ndjson auf.

Folgende Datenformate basieren auf JSON:

<list-formats base="json"/>
