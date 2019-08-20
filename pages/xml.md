---
title: XML
wikidata: Q2115
base: unicode
model: xml
application: structure
---

Die **Extensible Markup Language (XML)** ist ein hierarchisches Datenformat.
Die Auszeichnungsprache ist Grundlage zahlreicher weiterer Formate.  Als
einfachere Alternative dient oft [JSON](json).

<example highlight="xml">
&lt;book id="http://example.org/id/1234" language="de">
  &lt;title>Das Schloss&lt;/title>
  &lt;publisher>
    &lt;name>Wolff&lt;/name>, &lt;place>München&lt;/place>
  &lt;/publisher>
  &lt;authors>
    &lt;author family="Kafka" given="Franz" />
  &lt;/authors>
  &lt;issued year="1926">&lt;/issued>
&lt;/book>
</example>

Folgende Datenformate basieren auf XML:

<list-formats base="xml"/>

Zur Spezifikation von XML-basierten Formaten eignen sich:

<list-formats for="xml"/>

Neben der Standard-XML-Syntax kann XML ausgedrückt werden in:

<list-encodings model="xml" title=""/>
