# GBV-Formatdatenbank

[![Build Status](https://img.shields.io/travis/gbv/format.gbv.de.svg?style=flat-square)](https://travis-ci.org/gbv/format.gbv.de)
[![Quality Score](https://img.shields.io/scrutinizer/g/gbv/format.gbv.de.svg?style=flat-square)](https://scrutinizer-ci.com/g/gbv/format.gbv.de)

Dieses Repository enthält den Quellcode und die Quelldaten der unter <https://format.gbv.de/> zugänglichen Formatdatenbank.

## Systemanforderungen

Erfordert mindestens PHP 7.4 mit Erweiterungen u.A. für XML.

    $ sudo apt-get install php-xml php-mbstring php-curl

Weitere verwendeten PHP-Module werden mit [Composer](https://getcomposer.org/) installiert:

    $ composer install

Die Avram-Spezifikation und das dazu gehörige JSON Schema werden [in einem eigenen repository](https://github.com/gbv/avram), das mittels `make init` an die richtige Stelle geklont werden kann.

## Quellcode

<https://github.com/gbv/format.gbv.de>

Zum Testen kann ein eigener Webserver auf Port 8020 gestartet werden - allerdings funktioniert dabei die Auslieferung von Schema-Dateiennicht vollständig:

    $ make web

## Installation

Create a user `formatdb` and check out the repository

    $ sudo adduser formatdb --disabled-password --home /srv/formatdb
    $ sudo -iu formatdb
    $ git clone --bare https://github.com/gbv/format.gbv.de.git .git
    $ git init; git checkout
    $ make init

Die Anwendung läuft mittels nginx und PHP-FPM. Zur Installation sind im Zweifellsfall beide zu Installieren und zu konfigurieren:

    $ sudo apt-get install nginx php-fpm
    $ sudo cp /srv/formatdb/format.gbv.de /etc/nginx/sites-enabled/format.gbv.de # ggf. anpassen
    $ sudo service nginx restart
