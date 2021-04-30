# Dokumentation LB3 - Webformular
| Autor         | Raveendran Shajiran                                          |
|:--------------|:-------------------------------------------------------------|
| Erstell Datum | 16. April 2021                                               |
| Klasse        | ST18e                                                        |
| Modul         | 300 / Plattformübergreifende Dienste im Netzwerk integrieren | 
| Lehrperson    | Berger Marco                                                 |


## Inhaltsverzeichnis
- [Einleitung](#einleitung)
    - [Service](#service)
- [Umsetzung](#umsetzung)
    - [Tools](#tools)
    - [Netzwerkkonfiguration](#netzwerkkonfiguration)
    - [Image](#image)
    - [Docker-Compose](#dockercompose)
    - [Dockerfile](#dockerfile)
- [Testen](#testen)
- [Quellenverzeichnis](#quellenverzeichnis)
-----------------

<a name="einleitung"></a>
## Einleitung
In diesem Projekt befassen wir uns mit **Docker**. **Docker** ist eine Freie Software zur Isolierung von Anwendungen mit Hilfe von Containervirtualisierung. Docker vereinfacht die Bereitstellung von Anwendungen, weil sich Container, die alle nötigen Pakete enthalten, leicht als Dateien transportieren und installieren lassen. 


### Service
Mittels **PHP-Apache** werden wir nun eine Webumgebung einrichten. Anschliessend richten wir mittles **MySQL** einen Datenbank ein. Zum Schluss wollen wir diese nun zusammenführen. Wir erstellen danach also einen Webformular, in der dann Daten eingetragen werden können und diese Daten werden anschliessend in der Datenbank von MySQL gespeichert. 
