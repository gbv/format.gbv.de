---
title: JSON Path
application: query
for: json
homepage: https://goessner.net/articles/JsonPath
created: 2007
creator: Stephan Gössner
inspiredby: xpath
---

Die Abfragesprache JSON Path wurde von Stephan Gössner in Anlehnung an [XPath](xpath) für [JSON](../json)-Daten entwickelt. Eine Standardisierung als RFC ist derzeit (2021) in Arbeit.

Online kann JSON Path unter Anderem unter <https://jsonpath.com/> und <http://www.jsonquerytool.com/> ausprobiert werden.

Die SQL-Erweiterung [SQL/JSON Path](sqljsonpath) ist stark von JSON Path inspiriert. Weitere alternative Abfragesprachen für JSON sind [jq](jq), [JMESPath](jmespath), [JSONiq](jsoniq) und [JSONata](jsonata).

<example>
$.book[0].title
$.book[*].author
$..book[(@.length-1)]
</example>
