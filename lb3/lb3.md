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
    - [Netzplan](#netzplan)
    - [Image](#image)
        - [PHP](#php)  
    - [Docker-Compose](#dockercompose)
    - [Dockerfile](#dockerfile)
- [Testen](#testen)
- [Quellenverzeichnis](#quellenverzeichnis)
-----------------

<a name="einleitung"></a>
## Einleitung
In diesem Projekt befassen wir uns mit **Docker**. **Docker** ist eine Freie Software zur Isolierung von Anwendungen mit Hilfe von Containervirtualisierung. Docker vereinfacht die Bereitstellung von Anwendungen, weil sich Container, die alle nötigen Pakete enthalten, leicht als Dateien transportieren und installieren lassen. 

<a name="service"></a>
### Service
Mittels **PHP-Apache** werden wir nun eine Webumgebung einrichten. Anschliessend richten wir mittles **MySQL** einen Datenbank ein. Zum Schluss wollen wir diese nun zusammenführen. Wir erstellen danach also einen Webformular, in der dann Daten eingetragen werden können und diese Daten werden anschliessend in der Datenbank von MySQL gespeichert. 

<a name="umsetzung"></a>
## Umsetzung
<a name="tools"></a>
### Tools
Bevor wir dem Code zuwenden, benötigen wir folgende Tools:
- VirtualBox
- Vagrant
- Docker
- Docker-Compose
- VisualStudioCode
- GitBash

<a name="netzplan"></a>
### Netzplan
Um eine bessere Übersicht zum Projekt zu erhalten, erstellte ich hier ein Netzplan:
![image](images/Netzwerkplan.JPG)

<a name="image"></a>
### Image
Wie man auf dem Plan sieht, haben wir zwei Server in unserer Umgebung. Das bedeutet, wir verwenden ebenfalls zwei Images, wobei eines davon wir selber erstellen werden. Die Images werden von der [Docker-Hub](https://hub.docker.com/search?q=&type=image) Seite entwendet.

<a name="php"></a>
#### PHP
Für den Webserver verwenden wir den folgenden Image: [php:7.3.3](https://hub.docker.com/r/djenko/httpd-php-ext).
