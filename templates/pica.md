---
title: PICA-Format
shorttitle: PICA
javascript:
  - //code.jquery.com/jquery-3.2.1.min.js
  - js/demo.js
---

Das PICA-Format ist das Datenbankformat der Katalogsysteme CBS und LBS.  Die
interne Form **PICA+** hat dabei eindeutige Entsprechungen im
Katalogisierungsformat **Pica3**. Weitere Informationen stehem um Verbundwiki
unter [PICA-Format](https://verbundwiki.gbv.de/display/VZG/PICA-Format),
[PICA+](https://verbundwiki.gbv.de/pages/viewpage.action?pageId=40009828) und
[PICA-XML](https://verbundwiki.gbv.de/display/VZG/PICA+XML+Version+1.0).  Die
Bedeutung einzelner Felder und Unterfelder im PICA-Format hängt von konkreten
Katalogisierungsrichtlinien ab.

## Schema-API

<div class="alert alert-warning" role="alert">
  Die entgültige Spezifikation befindet sich noch im Aufbau, Änderungen vorbehalten!
</div>

<table class="table">
  <thead>
  <tr>
    <th>Schema</th>
    <th>Basis-URL</th>
    <th>Hintergrund</th>
    <th>Download</th>
  </tr>
  </thead>
  <tbody>
  <tr>
    <td>RDA Bibliografische Daten</td>
    <td><a href="pica/rda/">rda/</a></td>
    <td>RDA-Umsetzung von GBV und SWB für bibliografische Daten
      (siehe K10plus
      <a href="http://swbtools.bsz-bw.de/cgi-bin/help.pl?cmd=help&amp;verbund=GBV&amp;regelwerk=RDA">Online-Hilfe</a>)
    </td>
    <td><a href="pica/rda/schema">rda/schema</a></td>
  </tr>
  <tr>
    <td>RDA Normdaten</td>
    <td><a href="pica/rda/authority/">rda/authority/</a></td>
    <td>RDA-Umsetzung von GBV und SWB für Normdaten
      (siehe K10plus
      <a href="http://swbtools.bsz-bw.de/cgi-bin/help.pl?cmd=help&amp;verbund=GBV&amp;regelwerk=RDA">Online-Hilfe</a>)
    </td>
    <td><a href="pica/rda/authority/schema">rda/authority/schema</a></td>
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
    <td><a href="pica/rda/021A" class="demo">021A</a> PICA+</td>
  </tr><tr>
    <td>RDA Bibliografische Daten</td>
    <td><a href="pica/rda/021A$a" class="demo">021A$a</a> PICA+ Unterfeld</td>
  </tr><tr>
    <td>RDA Bibliografische Daten</td>
    <td><a href="pica/rda/4000" class="demo">4000</a> Pica3</td>
  </tr><tr>
    <td>RDA Normdaten</td>
    <td><a href="pica/rda/authority/003U" class="demo">003U</a> PICA+</td>
  </tr>
  </tbody>
</table>
<div id="demo" style="display: none;">
  <h4>Antwort</h4>
  <pre class="" id="demo-output"><code></code></pre>
</div>

