# File Server
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
In diesem Projekt befassen wir uns mit **Infrastructure as Code (IaC)** an. Auf Basis von **VirtualBox / Vagrant** wollen wir nun einen Fileserver automatisieren.


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
Den ganzen Code findet man im Repository.
#### Vagrant Konfiguration
X
```
Vagrant.configure("2") do |config|
    ...
    ...
    ...
end
```

#### VM Konfiguration
Für das Projekt verwenden wir eine Ubuntu Maschnine und holen dazu die entsprechende Image, welche für die VM verwendet soll.
```
    config.vm.box = "ubuntu/trusty64"
```
X  
```
    config.vm.provider "virtualbox" do |vb|
```
X
```
        vb.name = "Fileserver (Samba)"
        vb.memory = "2048"
        vb.cpus = 2
        vb.gui = true
```

#### Netzwerk Konfiguration
X
```
    config.vm.network :public_network
```
X
```
    config.vm.network :forwarded_port, guest: 80, host: 8000
    config.vm.network :forwarded_port, guest: 22, host: 2200, id: "ssh"
```
#### Provisionierung
X
```
    SCRIPT_INSTALL = <<-SCRIPT
        ...
        ...
        ...
    SCRIPT
    
    config.vm.provision :shell, inline: SCRIPT_INSTALL
```

#### Samba Installation
X
```
        apt-get -y update
        apt-get -y upgrade
        apt-get -y install samba
```

#### Samba Konfiguration
X
```     
        sudo cp /etc/samba/smb.conf /etc/samba/smb.conf-backup
        sudo rm /etc/samba/smb.conf
```
X
```
  config.vm.provision "file", 
        source: "https://raw.githubusercontent.com/shajiran/m300_lb/main/lb2/smb.conf", 
        destination: "/tmp/smb.conf"
```
X
```
        sudo mv /tmp/smb.conf /etc/samba/smb.conf
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
        sudo adduser $LOGIN
        sudo groupadd $LOGIN
        sudo addgroup $LOGIN $LOGIN
```
X
```
        echo $PASS | sudo smbpasswd --stdin $LOGIN
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
