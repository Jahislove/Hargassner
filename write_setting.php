<?php
// appelé par page_reglages.php
// permet d'ecrire les parametres de zone dans settings.inc.php

// la page d'acceuil affiche 1 seule zone de chauffe et 1 seul ballon ECS, au choix

file_put_contents('conf/settings.inc.php',
'<?php
	//ne pas modifier manuellement , les modifs se font par la page Reglages
	$zone_chauffage = "'.$_POST['zone_chauffage'].'";
	$zone_ecs = "'.$_POST['zone_ecs'].'";
'
);

// pour l'instant la page "variables" affiche les zone1 et zone2 pour le chauffage ( pas de choix)
// et 1 seul ballon (au choix)

switch ($_POST['zone_ecs']){
	case 'ballon1':
		$ballon_ECS = 'c27';
		break;
	case 'ballon2':
		$ballon_ECS = 'c35';
		break;
	case 'ballon3':
		$ballon_ECS = 'c43';
		break;
}

file_put_contents('conf/settings.inc.php',
'
	// page_1_24h.php
	$chart_last24_chan = "c23,c21,c3,c6,c7,c138,c134";
	// page_2_courbes.php
	$chart1_chan = "c0,c0,c134,c3,c4,c5,c6,c1,c2,c53,'.$ballon_ECS.',c56,c7,c138,c21,c23,c22,c24,c99,c92,c112,c12,c111"; // la 2 eme valeur (decendrage) est calculé d"apres c0
	// json_conso_jour.php (via page_3_conso.php)
	$json_conso_jour_chanel = "dateB,c23,c21,c3,c6,c138,c134,c56";
',FILE_APPEND);

file_put_contents('conf/settings.inc.php','?>',FILE_APPEND);

require("index.php");
?>
