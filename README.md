# Hargassner
auteur : JahisLove,  2015-2022
licence GPL-3.0-or-later

site web permettant la visualisation en temps réel d'une chaudière Hargassner avec regulation touchtronic

Ce site web permet de monitorer une chaudière à granulés Hargassner  .
Dans sa version simple (temps réel uniquement) il ne nécessite qu'un serveur apache/php impérativement sur votre réseau local.
Pour utiliser les menus supplémentaires et naviguer dans l'historique , il faut une base MySQL/MariaDB en plus.

La Chaudière dialogue par telnet , ce protocole n'est pas du tout sécurisé . 
C'est pour cette raison qu'il est nécessaire d'héberger le site web en local , afin d'éviter de diffuser le telnet sur internet.

Ce site est développé initialement pour une NanoPK. Mais il fonctionne parfaitement avec un modèle Classic ou HSV
La passerelle internet Hargassner n'est pas nécéssaire


condition necessaire :

1 - version simple (temps réel uniquement):
 - chaudiere hargassner avec regulation touchtronic branchée sur le reseau local
 - ce site web hébergé sur un serveur apache/PHP sur le meme reseau local
 
2 - version avancé (temps réel + historique + courbes):
 - meme chose + 
 - base MySQL ou MariaDB
 
 le remplissage de la base se fait en utilisant le script php stockBDD.php fourni (voir le fichier installation.txt)
    
   voir  https://github.com/Jahislove/Hargassner/wiki/installation pour plus d'info

-----------------------------------------------------------
website allowing the real-time visualization of a Hargassner boiler

This website allows you to monitor a Hargassner pellet boiler.
In it's simplest version (real time only) it only requires an apache / php server on your local network.
To use the full version : additional menus and navigate in the history, you need an additional MySQL database.

The Boiler dialogues by telnet, this protocol is not secure at all.
It is for this reason that it is necessary to host the website locally, in order to avoid broadcasting the telnet on the internet.

This site is initially developped for a NanoPK. But it is compatible with a Classic or HSV model

what you need:

1 - simple version (real time only, aka main page only):
 - hargassner boiler on local network
 - this web site hosted on apache/PHP server on same local network

2 - full version (real time + history):
 - same as above +
 - MySQL or MariaDB database

filling the database is done using the php script stockBDD.php provided (see the installation wiki)

Here is my configuration:

    -website on NAS synology DS916 (apache 2.2 , php7.4)
    -BDD MariaDB 10 on same synology DS916 NAS

for installation see https://github.com/Jahislove/Hargassner/wiki/Installation-english