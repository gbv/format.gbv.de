# REST-API für Pica+ Felder des GBV und SWB (K10Plus)
[![GitHub release](https://img.shields.io/github/release/gbv/PicaRestHelp.svg?style=flat-square)](https://github.com/gbv/PicaHelpRest/releases)
[![Build Status](https://img.shields.io/travis/gbv/PicaHelpRest.svg?style=flat-square)](https://travis-ci.org/gbv/PicaHelpRest)
[![Quality Score](https://img.shields.io/scrutinizer/g/gbv/PicaHelpRest.svg?style=flat-square)](https://scrutinizer-ci.com/g/gbv/PicaHelpRest)

Stellt ein REST-API zur Verfügung um auf die Definition der Pica+ Felder nach RDA des gemeinsamen Kataloges des GBV und SWB zuzugreifen.

# API Aufbau
Der Aufruf erfolgt über die URL: [`http://format.gbv.de/pica/rda/`](http://format.gbv.de/pica/rda/).

Aktuelle erfolgt die Rückgabe nur im JSON-Format. Der MIME-Typ ist `appilcation/json`.

## Abruf aller definierten PICA+ Felder
Wenn eine Liste aller Felder geladen werden soll, reicht es, wenn die API ohne Pfad-Angabe aufgerufen wird.

### Beispiel
**URL**: [`http://format.gbv.de/pica/rda/`](http://format.gbv.de/pica/rda/)

### Ausgabe
```json
[
	{
		"pica_p" : "001@",
		"pica_3" : "0000",
		"content" : "ILNs der Bibliotheken mit Exemplarsatz"
	},
	{
		"pica_p" : "001X",
		"pica_3" : "000A",
		"content" : "Title owner"
	},
	{ 
		//... 
	}
]
```
## Abruf eines bestimmten PICA+ Feldes
Wenn die Definition zu einem bestimmten Feld abgerufen werden soll, so muss die URL um das gewünschte Feld als Pfadangabe erweitert werden: `http://format.gbv.de/pica/rda/{FELD}`

### Beispiel
**Feld** : *021A* - Haupttitel, Titelzusatz, Verantwortlichkeitsangabe.
**URL**: [`http://format.gbv.de/pica/rda/021A`](http://format.gbv.de/pica/rda/021A)

Der Aufruf erzeugt einen Rückgabe mit den genauen Spezifikationen des Feldes *021A* sowie eine Liste der Unterfelder, geordnet nach ihrer Reihenfolge.

### Ausgabe
```json
{
	"pica_p" : "021A",
	"pica_3" : "4000",
	"content" : "Haupttitel, Titelzusatz, Verantwortlichkeitsangabe",
	"repeatable" : false,
	"modified" : "2017-12-18 10:41:47",
	"subfields" : [
		{
			"code_p" : "$T",
			"code_3" : "$T",
			"content" : "Feldzuordnung",
			"repeatable" : false,
			"modified" : "2017-08-09 07:20:11"
		},
		{ 
			//... 
		}
	]
}
```

## Abruf eines bestimmten Unterfeldes
Wenn die Definition eines bestimmten Unterfeldes zu einem Pica+ Feld geladen werden soll, so wird das Unterfeld durch ein `*$*` getrennt an das Feld angehangen: `http://format.gbv.de/pica/rda/{feld}${unterfeld}`

### Beispiel
**Feld** : *021A* - Haupttitel, Titelzusatz, Verantwortlichkeitsangabe
**Unterfeld** : *a* - Haupttitel
**URL**: [`http://format.gbv.de/pica/rda/021A$a`](http://format.gbv.de/pica/rda/021A$a)

Der Aufruf erzeugt einen Rückgabe mit den genauen Spezifikationen des Unterfeldes *a* des Feldes *021A*.

### Ausgabe
```json
{
	"pica_p" : "021A",
	"pica_3" : "4000",
	"code_p" : "$a",
	"code_3" : "ohne",
	"no" : 3,
	"content" : "Haupttitel",
	"repeatable":false,
	"modified":"2017-12-08 12:48:59"
}
```

## Fehlerrückmeldungen
Sollte eine Anfrage zu keinem Ergebnis führen oder kann nicht bearbeitet werden, wird eine entsprechende Fehlermeldung erzeugt. Es werden Fehlercodes nach [HTTP-Standard]( https://de.wikipedia.org/wiki/HTTP-Statuscode) verwendet.
```json
{
	"error" : {
		"code" : 404,
		"message" : "Not Found"
	}
}
```

### Fehlercodes
- 404 – Not Found : Das gesuchte Feld oder Unterfeld wurde nicht gefunden.*
- 405 – Method Not Allowed : Die Anfrage erfolgte nicht per **GET-Method**
- 503 - Service Unavailable : Es liegt eine technische Störung vor.

## Besonderheit
Sollte ein Feld oder Unterfeld nicht in RDA nicht zugelassen sein, dann erfolgt eine Fehlerausgabe so, als wäre das Feld nicht gefunden worden.

