<!DOCTYPE html>

<head>
	<link type="text/css" rel="stylesheet" href="css/main.css" />
</head>

<html>
    <?php
    require_once("conf/version.php");
    ?>

<h2>
<p>
    Version <?php echo $version ;?> :
    site web permettant la visualisation en temps réel d'une chaudière à granulés Hargassner .Ce site est personnel et n'engage aucunement la marque Hargassner
</p>
<p>
    ma configuration :
</p>
<p>
        - Chaudière Hargassner NanoPK + régulation touchtronic 
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
    le site web est disponible ici : https://github.com/Jahislove/Hargassner
</p>
<p>
    le script python ici : https://github.com/Jahislove/hargassner-python
    
</p>
<p>
    le forum pour discuter : http://forums.futura-sciences.com/habitat-bioclimatique-isolation-chauffage/503952-chaudieres-hargassner-regroupement-dinformations-98.html
</p>
<div>
    <br/>
</div></h2>

</html>