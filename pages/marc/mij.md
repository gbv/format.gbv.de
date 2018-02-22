---
title: MARC in JSON
short: mij
model: marc
base: json
created: 2010
creator: Ross Singer
---

**MARC in JSON** ist eine Kodierung [MARC](../marc) in JSON.

## Beispiel

~~~json
{
  "leader": "01471cjm a2200349 a 4500",
  "fields": [
    { "001": "5674874" },
    { "035": 
	  {
        "ind1": " ",
        "ind2": " ",
        "subfields": [
          { "9": "(DLC)   93707283" }
        ]
      } }
  ]
}
~~~


