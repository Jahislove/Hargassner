<?php

// OBSOLETE

// lit les parametres de zone dans settings.inc.php
// et ajuste les chanel telnet et colonnes BDD en consequences
// telnet utilisé par json_telnet
// colonnes BDD utilisées par les pages de courbes

require_once("conf/settings.inc.php");

switch ($zone_chauffage) {
    case 1:
		$chanel_depart_chauffage_est = 56;
		$chanel_depart_chauffage_doit = 57;
		break;
    case 2:
		$chanel_depart_chauffage_est = 62;
		$chanel_depart_chauffage_doit = 63;
		break;
    case 3:
		$chanel_depart_chauffage_est = 68;
		$chanel_depart_chauffage_doit = 69;
		break;
}
switch ($zone_ecs) {
	case 1:
		$chanel_temp_ecs = 95;
		break;
	case 2:
		$chanel_temp_ecs = 98;
		break;
	case 3:
		$chanel_temp_ecs = 101;
		break;
}

?>
