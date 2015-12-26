# Hargassner
26/12/2015

site web permettant la visualisation en temps réel d'une chaudière Hargassner Nano PK

Ce site web permet de visualiser l'état d'une chaudière à granulés Hargassner Nano PK .
Dans sa version simple (temps réel uniquement) il ne nécessite qu'un serveur apache/php impérativement sur votre réseau local.
Pour utiliser les menus supplémentaires et naviguer dans l'historique , il faut une base MySQL en plus.
Pour remplir cette base il faut un script python ( en cours de dev)

La Chaudière dialogue par telnet , ce protocole n'est pas du tout sécurisé . 
C'est pour cette raison qu'il est nécessaire d'héberger le site web en local , afin d'éviter de diffuser le telnet sur internet.

les paramètres diffusés par la chaudière ne portent pas les mêmes numéro en fonction du modèle de chaudière.
si vous disposez d'un modèle Classic ou HSV , des modifications légères seront à apporter.
le fichier qui m'a servit de réference pour la Nano PK est channel-nanoPK-v14.0c.txt situé dans /conf

