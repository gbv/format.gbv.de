---
title: PICA Patch
for: pica
base: bytes
application: patch 
---

Mit dem **PICA Patchformat** (auch **PICA Änderungsformat**) können Änderungen an PICA+ Datensätzen ausgedrückt werden. Das Format basiert auf *Annotated PICA* (siehe [PICA Plain](plain)) mit den Markierungszeichen `+` zum Hinzufügen und `-` zum Entfernen von Feldern. Zur Änderung von Unterfeldern wird ein Feld entfernt und anschließend mit geändertem Inhalt hinzugefügt. Zusätzlichen können unmarkierte Felder in einem Änderungsdatensatz enthalten sein um sicherzustellen, dass der Ursprungsdatensatz in diesem Feldern mit den Angaben im Änderungsdatensatz übereinstimmt. Felder die nicht im Änderungsdatensatz enthalten sind, werden beibehalten. Zur Anwendung einer Änderung müssen die PICA-Felder sortiert sein.

## Beispiel (in PICA Plain)

<example title="Ursprungsdatensatz">
003@ $012345X
021A $aEin Buch$hzum Lesen
</example>

<example title="Änderungsdatensatz">
&nbsp; 003@ $012345X
- 021A $aEin Buch$hzum Lesen
+ 021A $aEin gutes Buch$hzum Lesen und Genießen
</example>

<example title="Ergebnis">
003@ $012345X
021A $aEin gutes Buch$hzum Lesen und Genießen
</example>

## Serialisierungen

PICA Patch Format kann in [PICA Plain](plain) und in [PICA JSON](json) ausgedrückt werden.
