<?php require("header.php"); ?>

<script type="text/javascript">
	requestData('call_ajax_light');
</script>

<h2>
<p>
    Version <?php echo $version ;?> :<br>
    site web permettant la visualisation en temps réel d'une chaudière à granulés Hargassner.<br>
	Ce site est personnel et n'engage aucunement la marque Hargassner
	<br>
    ma configuration :<br>
        - Chaudière Hargassner NanoPK avec touchtronic <br>
        - base MySQL/MariaDB sur NAS synology DS916+<br>
        - site web + php sur NAS synology D916+<br>
	<br>
    ce site est divisé en 2 parties :<br>
    Une version simple , la page d'accueil uniquement, propose le temps réel. Elle ne nécessite qu'un serveur web+php sur le même réseau que la chaudière.<br>
    une version avancée (les autres menus)qui nécessite en plus une base de données MySQL ou MariaDB .<br>
	<br>
    La Chaudière dialogue par telnet , ce protocole n'est pas du tout sécurisé .<br>
    C'est pour cette raison qu'il est nécessaire d'héberger le site web en local , afin d'éviter de diffuser le telnet sur internet.<br>
	<br>
    le site web est disponible ici :<a href="https://github.com/Jahislove/Hargassner"> Github </a><br>
    le forum pour discuter : <a href="http://forums.futura-sciences.com/habitat-bioclimatique-isolation-chauffage/503952-chaudieres-hargassner-regroupement-dinformations-98.html"> Forum Futura-sciences </a>
</p>
</h2>

<object data="notes_version.txt"> </object> 
<?php require("footer.php");?>

