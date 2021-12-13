---
title: Änderungsformate
topConceptOf: application
---

**Änderungsformate** dienen der Beschreibung von Änderungen an Daten. Die Formate beinhalten im Wesentlichen Anweisungen zum Hinzufügen, Entfernen und/oder Ersetzen von Elementen eines Datensatzes. Wie bei [Abfragesprachen](query) und [Schemasprachen](../schema/language) sind einzelne Änderungsformate für bestimmte [Strukturierungssprachen](structure) ausgelegt.

Der Hauptanwendungsfall von Änderungsformaten sind Systeme zur Versionskontrolle.  In einem Änderungsformat abgelegte Änderungen werden je nach Anwendung als **Diff** oder als **Patch** bezeichnet. Dabei handelt es sich um zwei Seiten derselben Medaille:

* Diff betont, dass die Änderung den Unterschied zwischen zwei Versionen eines Datensatz ausdrückt
* Patch betont dass die Änderung alle Informationen beinhaltet um eine Version eines Datensatz in eine andere zu überführen

In der Formatdatenbank sind bislang folgende Änderungsformate erfasst:

<formats-tree application="patch"/>

Da für viele Strukturierungssprachen kein etabliertes Änderungsformat existiert, wird oft auf das Änderungsformat einer Serialisierung zurückgegriffen, also beispielsweise [Unidiff](unidiff) statt [JSON Patch](json-patch) für Änderungen an [JSON](json)-Daten. Ein Vorteil dieses kleinsten gemeinsamen Nenners besteht darin, dass Diff-Programme keine Kenntnis über das Strukturierungsformat haben müssen, allerdings können semantisch irrelevante Änderungen auf Syntax-Ebene so nicht erkannt werden.

Für Dokumente die gleichzeitige von mehreren Personen bearbeitet werden sollen (kollaborative Editoren), bieten sich Änderungsformate auch als primäres [Dokumentformat](application/documents) an.
