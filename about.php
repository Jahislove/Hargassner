<!DOCTYPE html>

<head>
	<link type="text/css" rel="stylesheet" href="css/main.css" />
</head>

<html>
<h2>
<p>
    20/02/2016 :
    site web permettant la visualisation en temps réel d'une chaudière à granulés Hargassner Nano PK .
</p>
<p>
    ma configuration :
</p>
<p>
        - Chaudière Hargassner NanoPK + régulation touchtronic + passerelle internet (pas obligatoire je pense)
</p>
<p>
        - base MySQL/MariaDB sur NAS synology DS411J
</p>
<p>
        - site web + php sur NAS synology DS411J
</p>
<p>
        - script python sur Raspberry pi
</p>
<p>
    ce site est divisé en 2 parties :
</p>
<p>
    Une version simple , la page d'accueil uniquement, propose le temps réel. Elle ne nécessite qu'un serveur web+php sur le même réseau que la chaudière.
</p>
<p>
    une version avancée (les autres menus)qui nécessite en plus une base de données MySQL ou MariaDB et un script pour remplir cette base.
</p>
<p>
    Pour remplir cette base J'ai développé un script python qui tourne en permanence sur le Raspberry
</p>
<p>
    La Chaudière dialogue par telnet , ce protocole n'est pas du tout sécurisé .

    C'est pour cette raison qu'il est nécessaire d'héberger le site web en local , afin d'éviter de diffuser le telnet sur internet.
</p>
<p>
    les paramètres diffusés par la chaudière ne portent pas les mêmes numéros en fonction du modèle de chaudière.

    si vous disposez d'un modèle Classic ou HSV branché sur le réseau (c'est a dire avec touchtronic), des modifications seront à apporter.
</p>
<p>
    le site web est disponible ici : https://github.com/Jahislove/Hargassner
</p>
<p>
    le script python ici : https://github.com/Jahislove/hargassner-python
    
</p>
<div>
    <br/>
</div></h2>

</html>