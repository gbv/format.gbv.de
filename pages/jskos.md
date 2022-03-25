---
title: JSKOS data format for Knowledge Organization Systems
short: JSKOS
base: rdf/json-ld
model: jskos
homepage: https://gbv.github.io/jskos/
application: authority
profiles:
- skos
- rdf/json-ld
---

Mit dem **JSKOS data format for Knowledge Organization Systems (JSKOS)** lassen
sich Wissensorganisationssysteme und ihren Bestandteile in [JSON](json)
kodieren.  Das Format basiert auf [SKOS](rdf/voc/skos) und
[JSON-LD](rdf/json-ld).

<example highlight="json">
{
  "uri": "http://example.org/terminology/P",
  "type": ["http://www.w3.org/2004/02/skos/core#Concept"],
  "scopeNote": {
    "en": ["lack of violent conflict or violence"],
    "de": ["Abwesenheit von Gewalt, Angst und anderen Störungen"]
  },
  "prefLabel": { "en": "peace", "de": "Frieden" },
  "altLabel": { "de": ["Friede"] },
  "notation": ["P"],
  "narrower": [ { "prefLabel": { "en": "world peace" } } ]
}
</example>
