---
title: Tom's Obvious, Minimal Language 
short: TOML
wikidata: Q28449455
homepage: https://github.com/toml-lang/toml
base: unicode
application: structure
---

**TOML** ist eine [Datenstrukturierungssprache](structure) deren Syntax an
[INI](ini)-Dateien angelehnt ist. Das Datenmodell von TOML ist im Wesentlichen
eine Erweiterung des Modells von [JSON](json) ohne `null`-Werte um Datentypen
für Zeit und Datum.

<example highlight="toml">
    value = 42
    name = [ "forty-two", "forty two", "42" ]

    [source]
    author = "Douglas Adams"
    work = "The Hitchhiker's Guide to the Galaxy"
</example>

Unter <https://toml-to-json.matiaskorhonen.fi/> existiert ein Konverter
zwischen TOML und JSON.
