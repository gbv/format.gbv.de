---
title: Human-Optimized Config Object Notation
short: HOCON
wikidata: Q20310849
base: unicode
model: json
---

**HOCON** ist im Wesentlichen eine Erweiterung der Syntax von [JSON](json).
Die Möglichkeiten von HOCON gleichen teilweise der alternativen JSON-Syntax
[Hjson](json), gehen allerdings darüber hinaus. 

<example>
    value = 42
    name = [
      forty-two
      forty two
      ""${value}
    ]
    question: null
    source {
      author: Douglas Adams
      work: The Hitchhiker's Guide to the Galaxy
    }
</example>

Unter <https://hocon-playground.herokuapp.com/> existiert ein Online-Konverter von HOCON nach JSON.

