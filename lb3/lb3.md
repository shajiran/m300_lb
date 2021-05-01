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
        - [MySQL](#mysql)
    - [Docker-Compose](#dockercompose)
        - [Service Konfiguration](#servicekonfiguration)
        - [Web Service Konfiguration](#webkonfiguration)
        - [MySQL Service Konfiguration](#mysqlkonfiguration)
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
Für den Webserver verwenden wir folgenden Image: [php:7.3.3](https://hub.docker.com/r/djenko/httpd-php-ext). **PHP** ist eine serverseitige Scriptsprache, die für Webentwicklungen entwickelt wurde, kann aber auch für allgemeine Zwecke eingesetzt werden. Für unser Projekt perfekt geeignet. 

<a name="mysql"></a>
#### MySQL
Für den MySQL Server verwenden wir folgenden Image: [mysql:8.0](https://hub.docker.com/_/mysql). **MySQL** ist ein weit verbreitets Datenbankmanagementsystem und somit die beliebteste Open-Source-Datenbank der Welt. Mit seiner bewährten Leistungsfähigkeit, Zuverlässigkeit und Benutzerfreundlichkeit hat sich MySQL zur führenden Datenbank für webbasierte Anwendungen entwickelt, die das gesamte Spektrum von persönlichen Projekten und Webseiten abdecken.

<a name="dockercompose"></a>
### Docker-Compose
Nun müssen wir die Images in unsere Umgebung einbauen. Dazu verwenden wir Docker-Compose. Docker-Compose ist ein Tool, das zum Definieren und Freigeben von Containeranwendungen entwickelt wurde. Wir erstellen ein YAML-Datei für das Docker-Compose, um die Dienste zu definieren, die wir mit einem einzigen Befehl starten bzw. beenden können. Den [ganzen Code](https://github.com/shajiran/m300_lb/blob/main/lb3/docker-compose.yml) findet man im Repository. Wir werden hier nun die einzelnen Schritte genauer anschauen.

<a name="servicekonfiguration"></a>
#### Service Konfiguration
Wir bestimmen zuerst die Version des Docker-Compose Files "3.3". Anschliessend bestimmen wir mittels "services: " die Services, die wir benutzen wollen. Dabei können wir frei wählen, wie wir die Services benennen. In unserem Fall nennen wir diese "web: " und "mysql: ". 
```
version: '3.3'
services:
  web:
    ...
    ...
    ...
    
  mysql:
    ...
    ...
    ...
```

<a name="webkonfiguration"></a>
#### Web Service Konfiguration
##### Build
Im "build: " können wir nun den Service Aufbau definieren. Build kann entweder als String angegeben werden, der einen Pfad direkt zum Build-Kontext enthält, oder als Objekt mit dem unter "context: " angegebenen Pfad und optional "dockerfile: " angegeben werden. 
```
    build: 
      context: ./php
      dockerfile: dockerfile
```

##### Container Name
Mittels "container_name: " können wir dem Container einen eigenen Namen vergeben.
```
    container_name: php
```

##### Depends on
Mittels "depends_on: " können wir die Abhängigkeit zwischen weitere Dienste / Services ausdrücken. Dies Bedeutet, dass es Dienste / Services in der Reihenfolge ihrer Abhängigkeit startet. Im folgenden Codezeile wird also "mysql" vor "web" gestartet.
```
    depends_on:
      - mysql
```


<a name="quellenangaben"></a>
## Quellenverzeichnis
- [Docker-Compose](https://docs.docker.com/compose/)
- [Docker-Compose Versionen](https://docs.docker.com/compose/compose-file/compose-versioning/)
- [Docker-Compose Build](https://docs.docker.com/compose/compose-file/compose-file-v3/#context)
