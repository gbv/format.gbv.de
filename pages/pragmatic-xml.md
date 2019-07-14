---
title: Pragmatic XML
homepage: https://www.xml.com/pub/a/2006/05/31/converting-between-xml-and-json.html
creator: Stefan Goessner
created: 2006
model: xml # TODO: only a subset
base: json
---

**Pragmatic XML** ist eine von Stefan Goessner vorgeschlagene
[JSON](json)-Kodierung einer Teilmenge von [XML](xml). Im Gegensatz zu
[MicroXML](microxml) ist Pragmatic XML nicht offiiziell standardisiert und
unterstützt die Reihenfolge von XML-Elementen und "mixed content" nur in
beschränkter Form.

<example>
{ 
  "a": ["some", "text"]
  "b": null,
  "c": { "@name": "value", "#text": "content" }
  "d": "some <x>textual</x> content"
}
</example>
