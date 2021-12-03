---
title: PICA Path
over: pica
application: query
---

Die PICA Path-Syntax wird im Rahmen der Werkzeuge [picadata](https://metacpan.org/dist/PICA-Data/view/script/picadata), Catmandu und [pica-rs](https://github.com/deutsche-nationalbibliothek/pica-rs) entwickelt um auf Felder und Unterfelder in PICA-Datensätzen zu verweisen.

## Syntax

Die aktuelle PICA Path Syntax lässt sich folgendermaßen formal beschreiben:

~~~
path             ::=  ( tag | xtag ) occurrence? subfields? position?
tag              ::=  [012.] [0-9.] [0-9.] [A-Z@.]
xtag             ::=  "2" [0-9.] [0-9.] [A-Z@.] "x" number
occurrence       ::=  "/" occurenceValue 
occurenceValue   ::=  number "-" number | occurrencePattern | "*"
occurencePattern ::=  [0-9.] [0-9.]? [0-9.]?
subfields        ::=  [$.]? ( [A-Za-z0-9]+ | "*" )
position         ::=  "/" ( number | range ) 
range            ::=  number "-" number? | "-" number
number           ::=  [0-9]+
~~~

Falls keine `occurrence` angegeben ist, wird als Standardwert `0` angenommen (keine Occcurrence) bzw. `*` (beliebige Occurrence) wenn der Ausdruck mit `2` oder mit `.` beginnt.

picadata und Catmandu erlauben zusätzlich eine alternative Syntax zur Angabe von Occurrences (`occurrence`)

pica-rs erweitert die Syntax um zusätzlich Möglichkeiten zur Referenzierung von Feldnummern (`tag`) und unterstützt keine Positionsangaben (`position`).

