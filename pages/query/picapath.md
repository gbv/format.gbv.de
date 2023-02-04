---
title: PICA Path
application: query
for: pica
base: chars
created: 2014
creator: Jakob Voß
---

Mit **PICA Path** Ausdrücken lassen sich einzelne Felder, Unterfelder und Feldinhalte von [PICA](../pica)-Daten referenzieren. Das Format ist von [MARCSpec](marcspec) inspiriert und wird im Rahmen der Werkzeuge [picadata](https://metacpan.org/dist/PICA-Data/view/script/picadata) und Catmandu entwickelt.

<example title="Beispiele">
003@
012X$abc
2...
123A/0./1-3
</example>

## Syntax

Zur vollständigen Unterstützung von PICA Path muss mindestens folgende formale Syntax erkannt werden:

~~~
path              ::=  ( tag | xtag ) occurrence? subfields?
tag               ::=  [012.] [0-9.] [0-9.] [A-Z@.]
xtag              ::=  "2" [0-9.] [0-9.] [A-Z@.] "x" number
occurrence        ::=  "/" occurrenceValue
occurrenceValue   ::=  number "-" number | occurrencePattern | "*"
occurrencePattern ::=  [0-9] [0-9]? [0-9]?
subfields         ::=  [$.]? ( [A-Za-z0-9]+ | "*" )
number            ::=  [0-9]+
~~~

Als Standard-Erweiterungen sind die Angabe von Positionen in Unterfeldwerten (`position`) und eine alternative Syntax zur Angabe von Occurrences möglich (umgesetzt in den Werkzeugen `picadata` und `Catmandu`):

~~~
path              ::=  ( tag | xtag ) occurrence? ( subfields position? )?
position          ::=  "/" ( number | range ) 
range             ::=  number "-" number? | "-" number
occurrence        ::=  "/" occurrenceValue | "[" occurrenceValue "]"
occureencePattern ::=  [0-9.] [0-9.]? [0-9.]?
~~~

Positionsangaben beziehen sich nicht auf Bytes sondern auf Unicode-Codepunkte. Bei Positionsangaben über mehrere Unterfelder werden die Unterfeldwerte in Reihenfolge ihres Vorkommens im Feld zu einer Zeichenkette zusammengefügt.

Falls keine Occurrence angegeben ist, wird als Standardwert `0` angenommen (keine Occcurrence) bzw. `*` (beliebige Occurrence) wenn der Ausdruck mit `2` oder mit `.` beginnt.

Ein Ausdruck mit X-Occurrence (`xtag`) passt auf Felder der Ebene 2, bei denen das Unterfeld `x` dem angegebenen Wert entspricht.

Zur Besseren Lesbarkeit sollten PICA Path Ausdrücke folgendermaßen normalisiert werden:

* Unterfelder sollten immer mit dem Unterfeld-Indikators `$` bzw. wenn dieses Zeichen leicht anders interpretiert werden würde mit `.` eingeleitet werden (also z.B. `003@$0` oder `003@.0` statt `003@0`)

* Occurrences sollten immer mit zwei Stellen angegeben werden (also z.B. `045B/02` statt `045B/2`). Für Felder der Ebene 2 können auch 3 Stellen verwendet werden.

* Die Null-Occurrence sollte weggelassen werden (also z.B. `003@` statt `003@/00`)

