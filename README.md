# Hargassner


site web permettant la visualisation en temps réel d'une chaudière Hargassner + touchtronic

Ce site web permet de monitorer une chaudière à granulés Hargassner  .
Dans sa version simple (temps réel uniquement) il ne nécessite qu'un serveur apache/php impérativement sur votre réseau local.
Pour utiliser les menus supplémentaires et naviguer dans l'historique , il faut une base MySQL en plus.

La Chaudière dialogue par telnet , ce protocole n'est pas du tout sécurisé . 
C'est pour cette raison qu'il est nécessaire d'héberger le site web en local , afin d'éviter de diffuser le telnet sur internet.

Ce site est développé initialement pour une NanoPK. Mais il fonctionne parfaitement avec un modèle Classic ou HSV
La passerelle internet Hargassner n'est pas nécéssaire

le fichier qui m'a servit de réference pour la Nano PK est channel-nanoPK-v14.0d.txt situé dans /conf

condition necessaire :

1 - version simple (temps réel uniquement):
 - chaudiere hargassner avec regulation touchtronic branchée sur le reseau local
 - ce site web hébergé sur un serveur apache/PHP sur le meme reseau local
 
2 - version avancé (temps réel + historique):
 - meme chose + 
 - base MySQL ou MariaDB
 - script python pour enregistrer les données https://github.com/Jahislove/hargassner-python
