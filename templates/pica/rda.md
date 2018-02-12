---
title: RDA-Richtlinien
shorttitle: RDA
javascript:
  - //code.jquery.com/jquery-3.2.1.min.js
  - /js/demo.js
---

Die RDA-Umsetzung von GBV und SWB kann in Zukunft an dieser Stelle per Webservice abgerufen werden.

<div class="alert alert-warning" role="alert">
  Die entgültige Spezifikation befindet sich noch im Aufbau, Änderungen vorbehalten!
</div>

## Schema-API

*Antwortformat wird noch an die [Avram Schema Language](../schema/avram) angepasst!*

<table class="table">
  <thead>
  <tr>
    <th>Schema</th>
    <th>Basis-URL</th>
    <th>Hintergrund</th>
  </tr>
  </thead>
  <tbody>
  <tr>
    <td>RDA Bibliografische Daten</td>
    <td><a href="rda/schema">rda/schema</a></td>
    <td>bibliografische Daten
      (siehe K10plus
      <a href="http://swbtools.bsz-bw.de/cgi-bin/help.pl?cmd=help&amp;verbund=GBV&amp;regelwerk=RDA">Online-Hilfe</a>)
    </td>
  </tr>
  <tr>
    <td>RDA Normdaten</td>
    <td><a href="rda/authority/schema">rda/authority/schema</a></td>
    <td>Normdaten
      (siehe K10plus
      <a href="http://swbtools.bsz-bw.de/cgi-bin/help.pl?cmd=help&amp;verbund=GBV&amp;regelwerk=RDA">Online-Hilfe</a>)
    </td>
  </tr>
  </tbody>
</table>

<h3>Beispiel-Abfragen</h3>
<table class="table">
  <thead>
  <tr>
    <th>Schema</th>
    <th>(Unter)feld</th>
  </tr>
  </thead>
  <tbody>
  <tr>
    <td>RDA Bibliografische Daten</td>
    <td><a href="rda/schema/021A" class="demo">021A</a> PICA+</td>
  </tr><tr>
    <td>RDA Bibliografische Daten</td>
    <td><a href="rda/schema/021A$a" class="demo">021A$a</a> PICA+ Unterfeld</td>
  </tr><tr>
    <td>RDA Bibliografische Daten</td>
    <td><a href="rda/schema/4000" class="demo">4000</a> Pica3</td>
  </tr><tr>
    <td>RDA Normdaten</td>
    <td><a href="rda/authority/schema/003U" class="demo">003U</a> PICA+</td>
  </tr>
  </tbody>
</table>
<div id="demo" style="display: none;">
  <h4>Antwort</h4>
  <p id="demo-url"><b>Url</b> <a></a></p>
  <pre id="demo-output"><code></code></pre>
</div>

