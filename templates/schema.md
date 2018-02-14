---
title: Schemas und Schemasprachen
short: Schemas
javascript:
    - //code.jquery.com/jquery-1.12.4.js
    - //cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js
    - //cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js
    - |
        $(document).ready(function() {
            $('.sortable').DataTable({ paging: false, search: false, info: false });
        } );
css: 
    - //cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css

---

Ein **Schema** ist eine formale Beschreibung der Struktur von Daten. Mit einem
Schema kann automatisch überprüft werden, ob ein eine Datei oder ein Datensatz
der beschriebenen Struktur entspricht. Dieser Vorgang wird auch als
*Validierung* bezeichnet.

Die meisten Datenformate sind durch Schemas beschrieben oder lassen sich durch
Schemas anpassen. Diese Schemas sind üblicherweise in einer Schemasprache
formuliert.

Im Unterschied zu Anwendungsregeln lassen sich mit Schemas nur strukturelle
Eigenschaften von Daten festlegen.

<php>
echo \View::instance()->render('schematable.php');
</php>

