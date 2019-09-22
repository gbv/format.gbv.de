---
title: K10plus Format
profiles: pica 
application:
  - bibliographic
  - authority
javascript:
  - js/demo.js
homepage: https://wiki.k10plus.de/display/K10PLUS/K10plus+Format-Dokumentation
---

**K10plus** ist der gemeinsame Katalog der Bibliotheksservice-Zentrum
Baden-Württemberg (BSZ) und die Verbundzentrale des GBV (VZG). Das
Katalogformat für diese Datenbank wird zur Zeit erarbeitet.

Die Spezifikation des K10plus-Format kann in Zukunft an dieser Stelle als 
[Avram-Schema](../schema/avram) per Webservice abgerufen werden.

<div class="alert alert-warning" role="alert">
  Die entgültige Spezifikation befindet sich noch im Aufbau, Änderungen vorbehalten!
</div>


| Standard                  | Basis-URL                                    | Anwendung
|---------------------------|----------------------------------------------|------------------------------------------------------------------------------------------------------------------------------------
| RDA Bibliografische Daten | [k10plus/schema](k10plus/schema) | bibliografische Daten (siehe K10plus [Online-Hilfe](http://swbtools.bsz-bw.de/cgi-bin/help.pl?cmd=help&verbund=GBV&regelwerk=RDA))
| RDA Normdaten             | [k10plus/authority/schema](k10plus/authority/schema) | Normdaten (siehe K10plus [Online-Hilfe](http://swbtools.bsz-bw.de/cgi-bin/help.pl?cmd=help&verbund=GBV&regelwerk=RDA))

### Beispiel-Abfragen für Schema-API

| Standard                  |  Beispiel
|---------------------------|---------------------------------------------
| RDA Bibliografische Daten | [021A](k10plus/021A) PICA+ Feld
| RDA Bibliografische Daten | [021A$a](k10plus/021A$a) PICA+ Unterfeld
| RDA Bibliografische Daten | [4000](k10plus/4000) Pica3 Feld
| RDA Normdaten             | [003U](k10plus/authority/003U) PICA+ Feld

<div id="demo" style="display: none;">
  <h4>Antwort</h4>
  <p id="demo-url"><b>Url</b> <a></a></p>
  <pre id="demo-output"><code></code></pre>
</div>

