---
title: BibJSON
base: json
application: bibliographic
homepage: http://okfnlabs.org/bibjson/
# created: 2011 (or earlier?)
---

**BibJSON** ist ein [JSON](json)-basiertes [bibliographisches Datenformat](application/bibliographic) das von der Open Knowledge Foundation für die Katalogsoftware [BibServer](https://bibserver.okfn.org/) entwickelt wurde. Das Format ist an [BibTeX](bibtex) angelehnt. Eine gebräuchlichere Alternative ist [CSL-JSON](csl-json).

<example>
    {
      "type": "book",
      "id": "Kafka1926",
      "title": "Das Schloss",
      "author": [ { "name": "Kafka, Franz" } ],
      "year": "1926",
      "publisher": "Wolff",
      "address": "München",
      "language": "ger"
    }
</example>
