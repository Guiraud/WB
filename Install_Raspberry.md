WB : Date de création :  08/03/2015
#Installation de la RaspBerry PI

## Environnement de travail
>Assurez vous d'avoir au moins 7 Go d'espace libre sur votre disque de travail
>créez un dossier «Install» dans le dossier WB que vous venez de télécharger via Github.
>Sinon créez-le
>Ouvrez un terminal et rendez-vous dans le dossier «Install».

## Première étape téléchargement de l'image ISO Raspbian la plus récente :
    wget -O Raspian.zip http://downloads.raspberrypi.org/raspbian_latest
    unzip Raspian.zip
    cp *-raspbian-*.img Raspian.img

Selon votre système d'exploitation le transfert sur la carte SD ou micro SD se fait differemment
##Deuxième étape, Gravure de la carte SD 
###Sous Mac OS X 10.5

    sudo dd bs=1m if=chemin_vers_Raspian.img of=/dev/diskn

>Vous pourrez connaitre le chemin en passant par la commande 'pwd'
>Le diskn correspond à la carte micros SD connectée via une prise USB. 
>On peut retrouver le 'n' en passant par l'utilitaire de disque en ligne de commande 'diskutil list'. Vous devriez avoir un résultat du type :

    /dev/disk0
       #:                       TYPE NAME                    SIZE       IDENTIFIER
       0:      GUID_partition_scheme                        *500.1 GB   disk0
       1:                        EFI EFI                     209.7 MB   disk0s1
       2:          Apple_CoreStorage                         499.2 GB   disk0s2
       3:                 Apple_Boot Recovery HD             650.0 MB   disk0s3
    /dev/disk1
      #:                       TYPE NAME                    SIZE       IDENTIFIER
       0:                  Apple_HFS Macintosh HD           *498.9 GB   disk1
                                     Logical Volume on disk0s2
                                    0638A8D3-67AE-4C16-9429-F2810EC7AAC6
                                     Unencrypted
    /dev/disk2
       #:                       TYPE NAME                    SIZE       IDENTIFIER
       0:     FDisk_partition_scheme                        *16.0 GB    disk2
       1:                 DOS_FAT_32 SANS TITRE              16.0 GB    disk2s1

>Ici c'est le '/dev/disk2' qui  nous intéresse puisque cela correspond à notre carte micro-SD. ( 16GB et DOS_FAT_32 ).
>il faudra aussi "démonter" en éxecutant la commande :

    diskutil unmountdisk /dev/disk2

>Puis la commande sera : 

    sudo dd bs=1m if=Raspian.img of=/dev/disk2

>Au bout d'un certain temps il y aura un message de succès

    $sudo dd bs=1m if=Raspian.img of=/dev/disk2
    Password:
    3125+0 records in
    3125+0 records out
    3276800000 bytes transferred in 1367.577549 secs (2396062 bytes/sec)

>Ejectez la carte SD avec la commande suivante :
    diskutil eject /dev/disk2


###Sous Windows
* Téléchargez l'image du système d'exploitation spécifique au Raspberry PI à partir [du site Raspian](http://downloads.raspberrypi.org/raspbian_latest).
* Téléchargez l'outil Win32DiskImager à partir du [dépot sourceforge](http://sourceforge.net/projects/win32diskimager/)
* Décompressez le fichier zip et exécutez-le "en tant qu'administrateur".
* Séletionnez l'image que vous venez de télécharger. Choisissez la lettre du lecteur de votre carte SD.
Attention de ne pas vous trompez de lecteur, tout sera effacé sur le lecteur de destination !
* Cliquez sur `Write`
* Lorsque la gravure est terminé ejectez la carte SD.

## Se connecter à la Raspberry PI

>D'abord vérifier que la carte SD est bien gravé. En général quand vous branchez l'alimentation sur la Raspberry, deux leds devrait s'allumer. Une led rouge reste allumée et une led verte se met à clignoter. Si les deux leds ont une lumières fixe, c'est qu'il y a un problème avec la carte SD et que la Raspberry n'y trouve pas l'information nécessaire un démarrage normal.

### Comment obtenir l'adresse IP de la Raspberry PI

#### Sous Windows
Dans le panneau de contrôle, 

![Voir les connections](http://www.hacktrix.com/wp-content/uploads/2010/09/delete-dial-up-connection-in-windows-7.png)

puis regardez l'état de votre connection :

![État de votre connection](http://www.home-network-help.com/images/network-connection-status-for-network-adapter.jpg)
#### sous mac OS X et Linux
>

### Se connecter en ligne de commande via SSH

Le login est pi et le mote de passe raspberry

    $ssh pi@192.168.0.14
    The authenticity of host '192.168.0.14 (192.168.0.14)' can't be established.
    RSA key fingerprint is 0b:4d:90:82:77:00:50:c5:f1:12:06:fd:ce:41:a3:6b.
    Are you sure you want to continue connecting (yes/no)? yes
    Warning: Permanently added '192.168.0.14' (RSA) to the list of known hosts.
    pi@192.168.0.14's password: 
    Warning: untrusted X11 forwarding setup failed: xauth key data not generated
    Linux raspberrypi 3.18.7-v7+ #755 SMP PREEMPT Thu Feb 12 17:20:48 GMT 2015 armv7l
    
    The programs included with the Debian GNU/Linux system are free software;
    the exact distribution terms for each program are described in the
    individual files in /usr/share/doc/*/copyright.
    
    Debian GNU/Linux comes with ABSOLUTELY NO WARRANTY, to the extent
    permitted by applicable law.
    /usr/bin/xauth:  file /home/pi/.Xauthority does not exist
    
    NOTICE: the software on this Raspberry Pi has not been fully configured. Please run 'sudo raspi-config'
    
    pi@raspberrypi ~ $

## Les premiers pas sous RaspBerry PI
### Changement du mot de passe

    pi@raspberrypi ~ $ sudo raspi-config

>Choisissez l'option 2 : «Change password for the default user (pi)» 

    Enter new UNIX password: 
    Retype new UNIX password:

>Si tout c'est bien passé vous avez le message suivant :

    password changed successfully

### Mise à jour du système

    sudo apt-get update
    sudo apt-get -y upgrade

### Changement de l'espace occupé

>RaspBian est configuré au départ pour une carte SD de petite taille. Il faut donc demander au système de remplir entièrement la carte afin d'avoir suffisamment de place.

    sudo raspi-config

>Sélectionnez «Ensures that all of the SD card storage is available to the OS»
>Une fois que c'est terminé vous avez ce message : «The filesystem will be enlarged upon the next reboot»
>faites circuler votre selection jusqu'à «Finish»
>rebootez.
>Logiquement vous devriez être déconnecté de votre Raspberry PI. Reconnectez-vous en utilisant le mot de passe que vous avez créé plus haut.

###Changement de la langue du système

>Une fois reconnecté revenez sur l'interface de connection
>Sélectionnez l'option 4 : «Internationalisation Options   Set up language and regional settings to match your location»
>Descendez à l'aide des flèches du clavier jusqu'à «fr_FR.UTF-8 UTF-8»
>La barre d'espace permet de sélectionner la langue. Un astérisque "*" devrait apparaitre.
>Tapez sur la touche entrée
>à nouveau sélectionnez la langue française : «fr_FR.UTF-8»
>Tapez entrée
>Vous devriez voir ce message apparaître

    Generating locales (this might take a while)...
    en_GB.UTF-8... done
    fr_FR.UTF-8... done
    Generation complete.

Voilà c'est la fin de la première partie. À ce niveau là, c'est bien de faire une pause. Vous avez une rapberry PI qui est prête pour l'instalation du système WHISTLEBOX.




