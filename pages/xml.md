---
title: XML
wikidata: Q2115
base: unicode
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

<list-encodings model="xml" title="Serialisierungen">
Neben der Standard-XML-Syntax kann XML ausgedrückt werden in:
</list-encodings>

<list-formats for="xml" application="query" title="Abfragesprachen">
Zur Abfrage von XML-Daten gibt es:
</list-formats>

<list-formats for="xml" application="schema" title="Schemasprachen">
Zur Spezifikation von XML-basierten Formaten eignen sich:
</list-formats>

<list-formats base="xml" application="patch" title="Änderungssprachen">
Zur Angabe von Änderungen an XML-Daten gibt es:
</list-formats>

<list-formats base="xml" title="Datenformate">
Folgende hier erfasste Datenformate basieren auf XML:
</list-formats>
