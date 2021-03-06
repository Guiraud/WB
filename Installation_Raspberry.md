WB : Date de création :  08/03/2015
#Installation de la RaspBerry PI

## Environnement de travail
>Assurez vous d'avoir au moins 7 Go d'espace libre sur votre disque de travail.
>Créez un dossier «WB_Install» dans le dossier WB que vous venez de télécharger via Github.
>Ouvrez un terminal et rendez-vous dans le dossier «WB_Install».

    mkdir WB_Install
    cd WB_Install

## Première étape : télécharger de l'image ISO Raspbian la plus récente :
    wget -O Raspian.zip http://downloads.raspberrypi.org/raspbian_latest
    unzip Raspian.zip
    cp *-raspbian-*.img Raspian.img

Selon votre système d'exploitation le transfert sur la carte SD ou micro SD se fait différemment.
##Deuxième étape : Graver de la carte SD 
###Sous Mac OS X 10.5

    sudo dd bs=1m if=chemin_vers_Raspian.img of=/dev/diskn

>Vous pourrez connaitre le chemin en passant par la commande 'pwd'.
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
>Il faudra aussi "démonter" en exécutant la commande :

    diskutil unmountdisk /dev/disk2

>Puis la commande sera : 

    sudo dd bs=1m if=Raspian.img of=/dev/disk2

>Au bout d'un certain temps, il y aura un message de succès :

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
* Sélectionnez l'image que vous venez de télécharger. Choisissez la lettre du lecteur de votre carte SD.
Attention de ne pas vous trompez de lecteur, tout serait effacé sur le lecteur de destination !
* Cliquez sur `Write`
* Lorsque la gravure est terminée, éjectez la carte SD.

## Se connecter à la Raspberry PI

>Vérifier d'abord que la carte SD est bien gravée. En général quand vous branchez l'alimentation sur la Raspberry, deux leds devraient s'allumer. Une led rouge reste allumée et une led verte se met à clignoter. Si les deux leds ont une lumière fixe, c'est qu'il y a un problème avec la carte SD et que la Raspberry n'y trouve pas l'information nécessaire au démarrage normal.

### Comment obtenir l'adresse IP de la Raspberry PI :

#### Sous Windows :
Dans le panneau de contrôle, 

![Voir les connections](http://www.hacktrix.com/wp-content/uploads/2010/09/delete-dial-up-connection-in-windows-7.png)

puis regardez l'état de votre connexion :

![État de votre connexion](http://www.home-network-help.com/images/network-connexion-status-for-network-adapter.jpg)
#### sous mac OS X et Linux
>

### Se connecter en ligne de commande via SSH

Le login est pi et le mot de passe, raspberry.

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
### Changer le mot de passe

    pi@raspberrypi ~ $ sudo raspi-config

>Choisissez l'option 2 : «Change password for the default user (pi)» 

    Enter new UNIX password: 
    Retype new UNIX password:

>Si tout c'est bien passé, vous avez le message suivant :

    Password changed successfully

### Mettre à jour du système

    sudo apt-get update
    sudo apt-get -y upgrade

### Changer de l'espace occupé

>RaspBian est configuré au départ pour une carte SD de petite taille. Il faut donc demander au système de remplir entièrement la carte afin d'avoir suffisamment de place.

    sudo raspi-config

>Sélectionnez «Ensures that all of the SD card storage is available to the OS»
>Une fois que c'est terminé vous avez ce message : «The filesystem will be enlarged upon the next reboot».
>Faites circuler votre selection jusqu'à «Finish».
>Rebootez.
>Logiquement vous devriez être déconnecté de votre Raspberry PI. Reconnectez-vous en utilisant le mot de passe que vous avez créé précédemment.

###Changer la langue du système :

>Une fois reconnecté revenez sur l'interface de connexion

>Sélectionnez l'option 4 : «Internationalisation Options   Set up language and regional settings to match your location»

>Descendez à l'aide des flèches du clavier jusqu'à «fr_FR.UTF-8 UTF-8»

>La barre d'espace permet de sélectionner la langue. Un astérisque "*" devrait apparaître.

>Tapez sur la touche entrée

>A nouveau sélectionnez la langue française : «fr_FR.UTF-8»

>Tapez sur Entrée.

>Vous devriez voir ce message apparaître :

    Generating locales (this might take a while)...
    en_GB.UTF-8... done
    fr_FR.UTF-8... done
    Generation complete.
### Allouer le maximum de mémoire disponible au processeur

>Puisque la whistlebox n'est relié à aucun écran, il n'est pas nécessaire de donner de la mémoire au processeur graphique (GPU)

    sudo raspi-config

>Sélectionnez « Advanced options » puis « A3 Memory split », ensuite écrire 16 à la place de 64.

Voilà c'est la fin de la première partie. À ce niveau là, c'est bien de faire une pause. Vous avez une Raspberry PI qui est prête pour l'installation du système WHISTLEBOX.
