<?php require("header_debut.php"); ?>
<script type="text/javascript" src="js/call_ajax_light.js">	</script>
<?php require("header_fin.php"); ?>
    
<script type="text/javascript">
	requestData();
</script>

<?php
// appelé par page_reglages.php
// permet d'ecrire les parametres de zone dans settings.inc.php


file_put_contents('conf/settings.inc.php','
<?php
//ne pas modifier manuellement , les modifs se font par la page Reglages
$zone_chauffage = "'.$_POST['zone_chauffage'].'";
$zone_ecs = "'.$_POST['zone_ecs'].'";
// page_1_24h.php
$chart_last24_chan = "c23,c21,c3,c6,c7,c138,c134";
// page_2_courbes.php
$chart1_chan = "c0,c0,c134,c3,c4,c5,c6,c1,c2,c53,c27,c56,c7,c138,c21,c23,c22,c24,c99,c92,c112,c12,c111"; // la 2 eme valeur (decendrage) est calculé d"apres c0
// json_conso_jour.php (via page_3_conso.php)
$json_conso_jour_chanel = "dateB,c23,c21,c3,c6,c138,c134,c56";
?>	
');

//$event = $event.";"."\n";
?>
<?php require("footer.php");?>
