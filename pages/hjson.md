---
title: Human JSON
short: Hjson
homepage: https://hjson.org/
wikidata: Q28757970 
model: json
base: unicode
---

**Hjson** ist eine Erweiterung der Syntax von [JSON](json) um JSON-Daten
leichter bearbeiten zu können. So sind in Hjson beispielsweise Kommentare
möglich und Sonderzeichen können an verschiedenen Stellen weggelassen werden.

Vergleichbare JSON-Erweiterungen sind [JSON5](json5) und [HOCON](hocon).

<example>
    {
      value: 42
      name: [
        forty-two
        forty two
        "42"
      ]
      question: null
      source: {
        author: Douglas Adams
        work: The Hitchhiker's Guide to the Galaxy
      }
    }
</example>

Unter <https://hjson.org/try.html> existiert ein Online-Konverter zwischen HJSON und JSON.
