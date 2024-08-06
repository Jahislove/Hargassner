<?php
//Charts localization
define("months", 		"['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre']");
define("weekdays", 		"['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi']");
define("shortMonths", 	"['Janv', 'Fev', 'Mars', 'Avr', 'Mai', 'Juin',  'Juil', 'Aout', 'Sept', 'Oct', 'Nov', 'Dec']");

//home page
define("menu_main", 			"Accueil");
define("menu_data", 			"Données");
define("menu_graph", 			"Courbes");
define("menu_consumption", 		"Consommation");
define("menu_settings", 		"Réglages");
define("menu_about", 			"A propos");

define("tooltip_power", 		"Puissance");
define("tooltip_fan", 			"Puissance du ventilateur d'extraction des fumées");
define("tooltip_temp_smoke",	"Température des fumées");
define("tooltip_temp_water",	"Température de l'eau");
define("tooltip_temp_indoor", 	"Température intérieure");
define("tooltip_temp_outdoor", 	"Température extérieure");
define("tooltip_temp_toHeater", "température de départ chauffage");
define("tooltip_pump_ECS", 		"Pompe eau chaude sanitaire");
define("tooltip_pump_heater", 	"Pompe radiateur");
define("tooltip_pellet_left", 	"Granulés restant");
define("tooltip_feeder", 		"pourcentage d'amené de la vis à granulé et conso par heure");

define("array_gauche1", 		"O² Lambda");
define("array_gauche2",			"T° interieur");
define("array_gauche3",			"T° exterieur");
define("array_gauche4",			"T° exterieur moy");
define("array_gauche5", 		"T° depart est");
define("array_gauche6", 		"T° depart doit");
define("array_gauche7", 		"T° chaudière est");
define("array_gauche8", 		"T° chaudière doit");
define("array_gauche9", 		"T° retour est");
define("array_gauche10",	 	"T° retour doit");
define("array_droite1", 		"tps comb pour décend est");
define("array_droite2",			"tps vis depuis aspi");
define("array_droite3",			"Mouvement grille");
define("array_droite4",			"Consommation granulés");
define("array_droite5", 		"Granulés restants");
define("array_droite6", 		"Ballon ECS °C");
define("array_droite7", 		"Ballon ECS On/Off/recyc");
define("array_droite8", 		"Variable F");
define("array_droite9", 		"Variable K");

define("chart_home_title",		"Données temps réel");
define("chart_home_serie1", 	"Etat");
define("chart_home_serie2",		"T° eau");
define("chart_home_serie3",		"Extraction");
define("chart_home_serie4",		"% bois");
define("chart_home_serie5",		"Puissance");
define("chart_home_serie6",		"T° départ");

//data page
define("help_msg",				"\
		Le tableau représente le contenu des données provenant en temps réel de la chaudière par telnet.<br/>\
		En cliquant sur une case , cela affiche la courbe correspondant au telnet et a la colonne de la BDD.<br/>\
		Dans les premiers firmware on avait donc telnet 10 (t10) = colonne 10 (c10)<br/>\
		Cependant au fil des firmwares , Hargassner a modifier l\'ordre des paramètres<br/>\
		et la colonne réelle de la BDD ne correspond plus au paramètre telnet,<br/>\
		En cliquant , on affiche le numero du paramètre Telnet (t..), la colonne correspondante en BDD (c..) et sa description si connue\
		");


//chart page
define("chart1_chart_title",	"Fonctionnement du jour");
define("chart1_chart_serie0",	"Etat");
define("chart1_chart_serie1",	"Décendrage");
define("chart1_chart_serie2",	"Puissance");
define("chart1_chart_serie3",	"T° chaudiere est");
define("chart1_chart_serie4",	"T° chaudiere doit");
define("chart1_chart_serie5",	"T° fumée");
define("chart1_chart_serie6",	"T° exterieur");
define("chart1_chart_serie7",	"O² est");
define("chart1_chart_serie8",	"O² doit");
define("chart1_chart_serie9",	"Vitesse Extracteur");
define("chart1_chart_serie10",	"T° Ballon ECS");
define("chart1_chart_serie11",	"% bois");
define("chart1_chart_serie12",	"T° exterieur Moy");
define("chart1_chart_serie13",	"T° interieur");
define("chart1_chart_serie14",	"T° Départ z1 est");
define("chart1_chart_serie15",	"T° Départ z1 doit");
define("chart1_chart_serie16",	"T° Départ z2 est");
define("chart1_chart_serie17",	"T° Départ z2 doit");
define("chart1_chart_serie18",	"Conso du jour");
define("chart1_chart_serie19",	"Ballon ECS Etat");
define("chart1_chart_serie20",	"Aspiration");
define("chart1_chart_serie21",	"T° Retour");
define("chart1_chart_serie22",	"Temps décendrage");
define("chart1_chart_serie23",	"conso instantanée");

define("gauge1_chart_day",		"Puissance Moyenne journée");
define("gauge2_chart_zoom",		"Puissance moyenne zoom");
define("gauge2_chart_unzoom",	"Puissance Moy. en Chauffe");
define("gauge2_chart_tooltip",	"Faites un zoom sur le <br>graphe pour afficher <br>la puissance moyenne <br>dans le zoom");

define("chart2_chart_title",	"allumage electrique");



	0	=> status_init,
	1   => status_init,
	2   =>'Init grille',
	3   =>'Démarrage chaudière',
	4   =>'Contrôle allumage résiduel',
	5   =>'Allumage électrique', 
	6   =>'Démarrage combustion',
	7   =>'Combustion',
	8   =>'Veille',
	9   =>'Arrêt pour décendrage',
	10  =>'Décendrage',
	11  =>'Refroidissement : utilisation chaleur residuelle',
	12  =>'Nettoyage',
	15	=>'Mode manuel',
	17	=>'Assistant de combustion'

?>