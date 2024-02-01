---
title: Schemasprachen
topConceptOf: applications
javascript:
    - //cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js
    - //cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js
    - |
        $(document).ready(function() {
            $('.sortable').DataTable({
              paging: false, search: false, info: false, searching: false 
            });
        } );
css: 
    - //cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css
---

**Schemasprachen** sind [Anwendungsformate](../application) für
[Schemas](../schema), die ihrerseits zur formalen Beschreibung von
Datenformaten dienen. Jede Schemasprache ist für Formate einer oder weniger
bestimmter [Strukturierungssprache](../structure) ausgelegt.

<application-table application="schema" title="Schemasprache"/>
