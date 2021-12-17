---
title: JSON Merge Patch
application: patch 
for: json
base: json
created: 2014
homepage: https://datatracker.ietf.org/doc/html/rfc7386
---

**JSON Merge Patch** ist ein [Änderungsformat](application/patch) für [JSON](json)-Dokumente. Zur Umsetzung einer Änderung werden das Ursprungsdokument und der Änderungsdatensatz zusammengeführt und Elemente mit `null`-Werten im Änderungsdatensatz entfernt. Nicht alle möglichen Änderungen zwischen JSON-Dokumenten können in diesem Format ausgedrückt werden.

Ein alternatives Änderungsformat für JSON ist [JSON Patch](json-patch).
