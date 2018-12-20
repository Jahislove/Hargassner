<?php require("header_debut.php"); ?>
<script type="text/javascript" src="js/call_ajax_light.js">	</script>
<?php require("header_fin.php"); ?>


<h2>
<p>
    Version <?php echo $version ;?> :
    site web permettant la visualisation en temps réel d'une chaudière à granulés Hargassner .Ce site est personnel et n'engage aucunement la marque Hargassner
</p>
<p>
    ma configuration :
</p>
<p>
        - Chaudière Hargassner NanoPK avec touchtronic 
</p>
<p>
        - base MySQL/MariaDB sur NAS synology DS916+
</p>
<p>
        - site web + php sur NAS synology D916+
</p>

<p>
    ce site est divisé en 2 parties :
</p>
<p>
    Une version simple , la page d'accueil uniquement, propose le temps réel. Elle ne nécessite qu'un serveur web+php sur le même réseau que la chaudière.
</p>
<p>
    une version avancée (les autres menus)qui nécessite en plus une base de données MySQL ou MariaDB .
</p>

<p>
    La Chaudière dialogue par telnet , ce protocole n'est pas du tout sécurisé .

    C'est pour cette raison qu'il est nécessaire d'héberger le site web en local , afin d'éviter de diffuser le telnet sur internet.
</p>

<p>
    le site web est disponible ici :<a href="https://github.com/Jahislove/Hargassner"> Github </a>
</p>

<p>
    le forum pour discuter : <a href="http://forums.futura-sciences.com/habitat-bioclimatique-isolation-chauffage/503952-chaudieres-hargassner-regroupement-dinformations-98.html"> Forum Futura-sciences </a>
</p>
<div>
    <br/>
</div></h2>
<?php require("footer.php");?>

<script type="text/javascript">
	requestData();
</script>