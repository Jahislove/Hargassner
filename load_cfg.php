<?php 
require_once("conf/config.inc.php");

// if not exist settings.ini(first install) then create it 
if (!file_exists('conf/settings.ini' )){
	echo 'for first installation , please go to settings page';
	file_put_contents('conf/settings.ini',
';Do not modify
[localization]
    language = en
    cost_origin = France

[settings_boiler]
    firmware = v14.0HAR.p
    zone_chauffage = zone1
    zone_ecs = ballon1
    zone_mode_chauffage = modeChauffage1

[chart_chanel]
    chart_last24_chan = c23,c21,c3,c6,c7,c138,c134
    chart1_chan = c0,c0,c134,c3,c4,c5,c6,c1,c2,c53,c27,c56,c7,c138,c21,c23,c22,c24,c99,c92,c112,c12,c111
    json_conso_jour_chanel = dateB,c23,c21,c3,c6,c138,c134,c56');
}

//loading data from settings.ini
	//read settings.ini
	$parameters = parse_ini_file('conf/settings.ini', true);
	foreach ($parameters as $key => $settings) {
			extract($parameters[$key]);//transforme les key du tableau en nom de variable
	}
//loading data from locale/en,fr,de.php
	//load localization
	if (!isset($language)) {
	  $language = 'en';
	}
	include('locale/' . $language . '.php');
?>
