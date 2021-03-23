# Dokumentation LB2 - Fileserver
| Autor         | Raveendran Shajiran                                          |
|:--------------|:-------------------------------------------------------------|
| Erstell Datum | 12. März 2021                                                |
| Klasse        | ST18e                                                        |
| Modul         | 300 / Plattformübergreifende Dienste im Netzwerk integrieren | 
| Lehrperson    | Berger Marco                                                 |

## Inhaltsverzeichnis
- [1 - Einleitung](#einleitung)
- [2 - Umsetzung](#umsetzung)
    - [2.1 - Tools](#tools)
    - [2.2 - Code](#code)
- [3 - Testen](#testen)
- [4 - Quellenangaben](#quellenangaben)


<a name="einleitung"></a>
## 1 - Einleitung
In diesem Projekt befassen wir uns mit **Infrastructure as Code (IaC)** an. Auf Basis von **VirtualBox / Vagrant** wollen wir nun einen Fileserver mittels Samba automatisch aufsetzen.


<a name="umsetzung"></a>
## 2 - Umsetzung
<a name="tools"></a>
### 2.1 - Tools
Bevor wir dem Code zuwenden, benötigen wir folgende Tools:
- VirtualBox
- Vagrant
- VisualStudioCode
- GitBash
<a name="code"></a>
### 2.2 - Code
Den [ganzen Code](https://github.com/shajiran/m300_lb/blob/main/lb2/Vagrantfile) findet man im Repository. Wir werden hier nun die einzelnen Schritte genauer anschauen.
#### Vagrant Konfiguration
Die "2" in der ersten Zeile steht für die Version des Konfigurationsobjekts **config**, das zur Konfiguration für diesen Block verwendet wird (der Abschnitt zwischen dem **do** und dem **end**). Dieses Objekt kann von Version zu Version sehr unterschiedlich sein. Derzeit gibt es nur zwei unterstützte Versionen: "1" und "2", wobei die "2" die neuere Version ist. Dies enthält neue und weitere Konfigurationsmöglichkeiten als die Vesion "1".
```
Vagrant.configure("2") do |config|
    ...
    ...
    ...
end
```

#### VM Konfiguration
Die Einstellungen in **config.vm** ändern die Konfiguration der Maschine, die Vagrant verwaltet. Hier wird konfiguriert, welche Maschine hochfahren sollte. Für unser Projekt verwenden wir eine Ubuntu Maschnine (**ubuntu/trusty64**) und holen dazu die entsprechende [Image](https://app.vagrantup.com/boxes/search). Dieses Image ist bereits mit einem vorgegebenen Benutzer ausgestattet *(Username: **vagrant** / Password: **vagrant**)*.
```
    config.vm.box = "ubuntu/trusty64"
```
Für die Virtualisierung bestimmen wir hier, welchen Provider / Virtualisierungsanwendungen wir benutzen wollen. In diesem Projekt richten wir eine einfache VM (Virtuelle Maschine) mit VirtualBox ein. Mittels dem Befehle im GIT Bash z.B. `vagrant up` können wir die Maschine starten und mittels `vagrant destroy` stoppt es die Maschine und löscht alle Daten.
```
    config.vm.provider "virtualbox" do |vb|
```
Man kann nun auch noch die Virtuelle Maschnine anpassen. Man kann z.B. einen Namen für die Maschine bestimmen, Memory Speicher und Anzahl CPUs vergeben, etc. Die GUI funktion ist nicht notwendig. Dient dazu, dass nachdem man ein `vagrant up` gestartet hat, direkt in die Maschine gelangt. Wir setzen diese Funktion auf `true` für spätige Testzwecken, kann aber in unserem Fall auch auf `false` gesetzt sein.
```
        vb.name = "Fileserver (Samba)"
        vb.memory = "2048"
        vb.cpus = 2
        vb.gui = true
```

#### Netzwerk Konfiguration
Für unser Fileserver benötigen wir Internetzugang, um die Verbindung auch von aussen zu ermöglichen. Hier konfigurieren wir das Netzwerk auf der Maschine. Wir unterscheiden zwischen zwei Netzwerke `private` und `public`. Die Idee dahinter ist, dass private Netzwerke niemals der Öffentlichkeit Zugang zu Ihrem Rechner gewähren sollten, public Netzwerke aber schon. Wir können zugleich auch eine statische IP-Adresse vergeben, mit der wir dann vom lokalen Rechner auf dem Fileserver zugreifen können.
```
     config.vm.network "public_network", ip: "192.168.1.200"
```
Wir könnten noch ein **Port-Forwarding** machen, wäre aber nicht nötig für unser Fileserver. Hätten wir z.B. noch einen einfachen **Webserver**, hätten wir unter `http://localhost:8000` diesen Webserver erreichen. Davor müsste man aber noch `apache2` installieren, um dann in die index.html Datei (Startdatei Apache Web Server) zu erlangen. Diese Datei kann man dann beliebig abändern.
**SSH** wäre eine weitere Port-Weiterleitung, welche uns eine sichere Möglichkeit bietet, über ein ungesichertes Netzwerk auf eine Maschine zuzugreifen z.B. über Putty. Dabei gibt man die IP des Localhosts `127.0.0.1` an und den weitergeleiteten Port `2200` an, welche dann auf den Port `22` umgeleitet wird.
```
    config.vm.network :forwarded_port, guest: 80, host: 8000
    config.vm.network :forwarded_port, guest: 22, host: 2200, id: "ssh"
```
#### Provisionierung
Mit der Provisionierung kann man in Vagrant als Teil des Vagrant-Up-Prozesses automatisch Software installieren, Konfigurationen ändern, usw. Die Befehle die man sonst auf dem Bash in der Maschine eintippt, können nun unter dem Abschnitt `SCRIPT` eingefügt werden. Diese werden in der Variable `SCRIPT_INSTALL` gespeichert. In der unteren Zeile erkennt dann die Provisionierung, dass es sich um eine `Shell / Bash` Provision handelt. Wir sagen also der Shell, dass folgende Befehle von `SCRIPT_INSTALL` ausgeführt werden soll, bzw. automatisch eingetippt werden soll. Man könnte auch die Bash Befehle in einem getrennten Datei speichern, sodass man anstatt die Variable im Code `inline:`, einen relativen Pfad mittels `path:` die Datei im Vagrantfile verweist. So hätte man z.B. die Provisionierung und die Netzwerk Konfiguration in seperaten Dateien, um eine besseren Übersicht zu erhalten. Dies benötigt man jedoch bei grösseren Vagrantfiles. Da unser Vagrantfile jedoch klein ist, ist es in unserem Fall in Ordnung, wenn alles im Vagrantfile befindet.
```
    SCRIPT_INSTALL = <<-SCRIPT
        ...
        ...
        ...
    SCRIPT
    
    config.vm.provision :shell, inline: SCRIPT_INSTALL
```

#### Samba Installation
Bevor wir **Samba** installieren, nutzen wir die Befehle `sudo apt-get update` um die Paketlisten neu einzulesen und zu aktualisieren. Der Befehl `sudo apt-get upgrade` führt das eigentliche „Update“ aus. Somit sind wir auf dem aktuellsten Stand und können dann unser Samba installieren, welche uns für die Freigabe und das Teilen von Ordner und Dateien ermöglicht. 
```
        sudo apt-get -y update
        sudo apt-get -y upgrade
        sudo apt-get -y install samba
```

#### Samba Konfiguration
X
```     
        sudo cp /etc/samba/smb.conf /etc/samba/smb.conf-backup
        sudo rm /etc/samba/smb.conf
```
X
```
        sudo wget -P /etc/samba/ https://raw.githubusercontent.com/shajiran/m300_lb/main/lb2/smb.conf 
```


#### User einrichten
X
```
        LOGIN=test
        PASS=password
```
X
```
        sudo mkdir /home/$LOGIN
```
X
```
        echo -ne "$PASS\n$PASS\n" | sudo adduser $LOGIN
        sudo addgroup $LOGIN $LOGIN
```
X
```
        echo -ne "$PASS\n$PASS\n" | sudo smbpasswd -a -s $LOGIN
```
X
```
        sudo chown $LOGIN:$LOGIN /home/$LOGIN
        sudo chmod 2770 /home/$LOGIN
```
X
```
        sudo /etc/init.d/samba restart
```

<a name="testen"></a>
## 3 - Testen



<a name="quellenangaben"></a>
## 4 - Quellenverzeichnis
- [VagrantBox Katalog](https://app.vagrantup.com/boxes/search)
- [Provisioning](https://semaphoreci.com/community/tutorials/getting-started-with-vagrant)
- [Samba Installation und Konfiguration](https://www.thomas-krenn.com/de/wiki/Einfache_Samba_Freigabe_unter_Debian)
- [Samba Konfigurations File anpassen](https://wiki.ubuntuusers.de/Samba_Server/smb.conf/)
- [Samba Konfigurations File verschieben](https://stackoverflow.com/questions/54067192/vagrant-config-vm-provision-does-not-allow-me-to-copy-a-file-to-etc-nginx-conf/54099162)
- [Samba Freigabe mit Authentifizierung](https://www.thomas-krenn.com/de/wiki/Samba_Freigabe_mit_Authentifizierung)
