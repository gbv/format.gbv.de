---
title: RDA-Richtlinien
short: RDA
javascript:
  - //code.jquery.com/jquery-3.2.1.min.js
  - js/demo.js
---

Die RDA-Umsetzung von GBV und SWB kann in Zukunft an dieser Stelle per Webservice abgerufen werden.

<div class="alert alert-warning" role="alert">
  Die entgültige Spezifikation befindet sich noch im Aufbau, Änderungen vorbehalten!
</div>

*Antwortformat wird noch an die [Avram Schema Language](../schema/avram) angepasst!*


| Standard                  | Basis-URL                                    | Anwendung
|---------------------------|----------------------------------------------|------------------------------------------------------------------------------------------------------------------------------------
| RDA Bibliografische Daten | [rda/schema](rda/schema) | bibliografische Daten (siehe K10plus [Online-Hilfe](http://swbtools.bsz-bw.de/cgi-bin/help.pl?cmd=help&verbund=GBV&regelwerk=RDA))
| RDA Normdaten             | [rda/authority/schema](rda/authority/schema) | Normdaten (siehe K10plus [Online-Hilfe](http://swbtools.bsz-bw.de/cgi-bin/help.pl?cmd=help&verbund=GBV&regelwerk=RDA))

### Beispiel-Abfragen für Schema-API

| Standard                  |  Beispiel
|---------------------------|---------------------------------------------
| RDA Bibliografische Daten | [021A](rda/021A) PICA+ Feld
| RDA Bibliografische Daten | [021A$a](rda/021A$a) PICA+ Unterfeld
| RDA Bibliografische Daten | [4000](rda/4000) Pica3 Feld
| RDA Normdaten             | [003U](rda/authority/003U) PICA+ Feld

<div id="demo" style="display: none;">
  <h4>Antwort</h4>
  <p id="demo-url"><b>Url</b> <a></a></p>
  <pre id="demo-output"><code></code></pre>
</div>

