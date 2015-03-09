WB : Date de création :  08/03/2015
#Installation d'une Whistle BOX

## Environnement de travail
>créez un dossier «Install» dans le dossier WB que vous venez de télécharger via Github.
>Sinon créez-le
>Ouvrez un terminal et rendez-vous dans le dossier «Install».

## Première étape téléchargement de l'image ISO Raspbian la plus récente :
    wget http://downloads.raspberrypi.org/raspbian_latest
    cp raspbian_latest Raspian.img

>selon votre système d'exploitation le transfert sur la carte SD ou micro SD se fait differemment
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
    974+1 records in
    974+1 records out
    1021592274 bytes transferred in 480.752682 secs (2124985 bytes/sec)
