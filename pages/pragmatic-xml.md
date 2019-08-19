---
title: Pragmatic XML
homepage: https://www.xml.com/pub/a/2006/05/31/converting-between-xml-and-json.html
creator: Stefan Goessner
created: 2006
model: xml # TODO: only a subset
base: json
---

**Pragmatic XML** ist eine ursprünglich von Stefan Goessner vorgeschlagene
[JSON](json)-Kodierung einer Teilmenge von [XML](xml). Im Gegensatz zu
[MicroXML](microxml) ist Pragmatic XML nicht offiziell standardisiert und
unterstützt die Reihenfolge von XML-Elementen und "Mixed Content" (XML-Elemente
die sowohl Text als auch andere XML-Elemente als Kinder haben) nur in
beschränkter Form. Auch der Name des Wurzelelements lässt sich nicht kodieren.

Die Abbildung von XML nach JSON basiert auf folgenden Regeln:

| XML-Fragment                    | JSON-Fragment
| --------------------------------|--------------------------------------------
| `<e/>`                          | `"e": null` oder `"e": {}`
| `<e>text</e>`                   | `"e": "text"`
| `<e name="value"/>`             | `"e": { "@name": "value" }`
| `<e name="value">text</e>`      | `"e": { "@name": "value", "#text": "text" }`
| `<e><a>text</a><b>text</b></e>` |`"e": { "a": "text", "b": "text" }`
| `<e><a>text</a><a>text</a></e>` | `"e": { "a": ["text", "text"] }`
| `<e>text<a>text</a></e>`        | `"e": { "a": "text" }`

Die letzte Regeln zur Behandlung von Mixed Content weicht von Goessners
Vorschlag dahingehend ab, dass Pragmatic XML in diesem Fall Textelemente
ignoriert.

<example highlight="json">
{ 
  "a": ["some", "text"]
  "b": null,
  "c": { "@name": "value", "#text": "content" }
}
</example>

Die ebenfalls übliche Variante **Simple XML** unterscheidet nicht zwischen
Element- und Attributnamen und verwendet unterschiedliche Feldnamen für
Textelemente (z.B. `content` statt `#text`). Die Kodierung von XML-Dokumenten
in JSON ist dadurch jedoch nicht mehr verlustfrei umkehrbar.
