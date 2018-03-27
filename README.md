# GBV-Formatdatenbank

[![Build Status](https://img.shields.io/travis/gbv/format.gbv.de.svg?style=flat-square)](https://travis-ci.org/gbv/format.gbv.de)
[![Quality Score](https://img.shields.io/scrutinizer/g/gbv/format.gbv.de.svg?style=flat-square)](https://scrutinizer-ci.com/g/gbv/format.gbv.de)

Dieses Repository enthält den Quellcode und die Quelldaten der unter
<https://format.gbv.de/> zugänglichen Formatdatenbank.

## Systemanforderungen

Erfordert mindestens PHP 7 mit Erweiterungen für MySQL-PDO und XML.

Die Konfigurationsdatei (siehe Beispiel `config/picahelp.example.json`) muss
nach `config/picahelp.json` kopiert und angepasst werden.

Weitere verwendeten PHP-Module müssen mit Composer installiert werden:

    $ composer install

## Quellcode

<https://github.com/gbv/format.gbv.de>

## Nutzung

### REST-API für PICA+ Felder des GBV und SWB (K10Plus)

Stellt ein JSON-API zur Verfügung um auf die Definition der PICA+ Felder nach RDA des gemeinsamen Kataloges des GBV und SWB zuzugreifen.

#### API Aufbau

Der Aufruf erfolgt über die URL: [`http://format.gbv.de/pica/rda/`](http://format.gbv.de/pica/rda/).

Aktuelle erfolgt die Rückgabe nur im JSON-Format. Der MIME-Typ ist `application/json`.

##### Abruf aller definierten PICA+ Felder

Wenn eine Liste aller Felder geladen werden soll, reicht es, wenn die API ohne Pfad-Angabe aufgerufen wird.

##### Beispiel

* **URL**: [`http://format.gbv.de/pica/rda/`](http://format.gbv.de/pica/rda/)

##### Ausgabe

```json
{
    "001@": {
        "tag": "001@",
        "pica3": "0000",
        "label": "ILNs der Bibliotheken mit Exemplarsatz"
    },
    "001A": {
        "tag": "001A",
        "pica3": "0200",
        "label": "Kennung und Datum der Ersterfassung"
    },
    "001B": {
        "tag": "001B",
        "pica3": "0210",
        "label": "Kennung und Datum der letzten \u00c4nderung"
    }
}
```

#### Abruf eines bestimmten PICA+ Feldes

Wenn die Definition zu einem bestimmten Feld abgerufen werden soll, so muss die URL um das gewünschte Feld als Pfadangabe erweitert werden: `http://format.gbv.de/pica/rda/{FELD}`

##### Beispiel

* **Feld** : *021A* - Haupttitel, Titelzusatz, Verantwortlichkeitsangabe.
* **URL**: [`http://format.gbv.de/pica/rda/021A`](http://format.gbv.de/pica/rda/021A)

Der Aufruf erzeugt einen Rückgabe mit den genauen Spezifikationen des Feldes *021A* und seiner Unterfelder.

##### Ausgabe

```json
[
    {
        "tag": "021A",
        "pica3": "4000",
        "label": "Haupttitel, Titelzusatz, Verantwortlichkeitsangabe",
        "url": "http:\/\/swbtools.bsz-bw.de\/cgi-bin\/help.pl?cmd=kat\u0026val=4000\u0026regelwerk=RDA\u0026verbund=GBV",
        "repeatable": false,
        "modified": "2017-12-18 10:41:47"
    }
]
```

#### Abruf eines bestimmten Unterfeldes

Wenn die Definition eines bestimmten Unterfeldes zu einem PICA+ Feld geladen werden soll, so wird das Unterfeld durch ein `*$*` getrennt an das Feld angehangen: `http://format.gbv.de/pica/rda/{feld}${unterfeld}`

##### Beispiel

* **Feld** : *021A* - Haupttitel, Titelzusatz, Verantwortlichkeitsangabe
* **Unterfeld** : *a* - Haupttitel
* **URL**: [`http://format.gbv.de/pica/rda/021A$a`](http://format.gbv.de/pica/rda/021A$a)

Der Aufruf erzeugt einen Rückgabe mit den genauen Spezifikationen des Unterfeldes *a* des Feldes *021A*.

##### Ausgabe

```json
{
    "tag": "021A",
    "code": "$a",
    "pica3": null,
    "label": "Haupttitel",
    "repeatable": false,
    "modified": "2017-12-08 12:48:59",
    "position": 3
}
```

#### Fehlerrückmeldungen

Sollte eine Anfrage zu keinem Ergebnis führen oder kann nicht bearbeitet werden, wird eine entsprechende Fehlermeldung erzeugt. Es werden Fehlercodes nach [HTTP-Standard]( https://de.wikipedia.org/wiki/HTTP-Statuscode) verwendet.

```json
{
	"error" : {
		"code" : 404,
		"message" : "Not Found"
	}
}
```

Sollte ein Feld oder Unterfeld nicht in RDA nicht zugelassen sein, dann erfolgt eine Fehlerausgabe so, als wäre das Feld nicht gefunden worden.

##### Fehlercodes

- 404 – Not Found : Das gesuchte Feld oder Unterfeld wurde nicht gefunden.*
- 405 – Method Not Allowed : Die Anfrage erfolgte nicht per **GET-Method**
- 503 - Service Unavailable : Es liegt eine technische Störung vor.


