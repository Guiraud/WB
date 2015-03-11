WB : Date de création :  08/03/2015
#La Whistle BOX ?

##Présentation rapide
##Présentation technique


#Installation de la RaspBerry PI

Pour installer la base du système, il faut commencer par se procurer 

1. Une Raspberry PI
2. Une carte Micro SD
3. Un accès réseau
4. Un ordinateur
5. Le logiciel putty pour ceux qui sont sous Windows ( [que vous pouvez télécharger ici](http://www.chiark.greenend.org.uk/~sgtatham/putty/download.html)
6. Ensuite allez sur cette [page](https://github.com/Guiraud/WB/blob/master/Install_Raspberry.md)

## Création de votre clef PGP

## Installation de la Whistlebox

###Installation sur la Raspberry PI des fichiers du serveur.

    Guiraud@WB$scp files/web.tar.bz pi@192.168.0.14:
    pi@192.168.0.14's password: 
    web.tar.bz                                                                                                                                                                               100% 4354KB   4.3MB/s   00:01    
    mguiraud@192.168.0.25/169.254.228.195/WB$ssh pi@192.168.0.14
    pi@192.168.0.14's password: 
    Linux raspberrypi 3.18.7-v7+ #755 SMP PREEMPT Thu Feb 12 17:20:48 GMT 2015 armv7l
    
    The programs included with the Debian GNU/Linux system are free software;
    the exact distribution terms for each program are described in the
    individual files in /usr/share/doc/*/copyright.
    
    Debian GNU/Linux comes with ABSOLUTELY NO WARRANTY, to the extent
    permitted by applicable law.
    Last login: Wed Mar 11 08:20:14 2015 from 192.168.0.25
    pi@raspberrypi ~ $ sudo tar jxvf web.tar.bz -C /var/
    www/
    www/.htaccess
    www/api.php
    www/fichiers/
    www/getKey.php
    www/index.php
    ...
    www/fichiers/admin/img/verrou2.gif
    www/fichiers/admin/img/verrou2.jpg
    www/fichiers/admin/img/vide.gif
    pi@raspberrypi ~ $ 

Effacer les fichiers du serveurs par défaut.

    pi@raspberrypi ~ $ sudo rm -f /var/www/index.html.en /var/www/index.html
    pi@raspberrypi ~ $ 

### Démarrage du serveur tor
    sudo -s
    cd /var/lib/tor
    mkdir hidden_service
    service tor restart
