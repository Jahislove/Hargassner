<?php
//French localization
//define("Constant_name<=doNotModify",	"word to translate");
//Charts localization
define("months", 		"'Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'");
define("weekdays", 		"'Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'");
define("shortMonths", 	"'Janv', 'Fev', 'Mars', 'Avr', 'Mai', 'Juin',  'Juil', 'Aout', 'Sept', 'Oct', 'Nov', 'Dec'");

//header menu
define("menu_main", 			"Accueil");
define("menu_data", 			"Données");
define("menu_graph", 			"Courbes");
define("menu_consumption", 		"Consommation");
define("menu_settings", 		"Réglages");
define("menu_about", 			"A propos");

define("modeCommand_auto", 		"Mode auto");
define("modeCommand_nigh", 		"Mode réduit forcé");
define("modeCommand_comf", 		"Mode confort forcé");
define("modeCommand_stop",		"Arrêt");
define("modeCommand_tmpComf", 	"Mode confort temporaire");
define("modeCommand_tmpNigh", 	"Mode réduit temporaire");

define("modeChauff_Summ", 		"Mode été");
define("modeChauff_Comf", 		"Mode confort");
define("modeChauff_Red", 		"Confort => mode réduit");
define("modeChauff_Nigh", 		"Mode réduit");
define("modeChauff_Stop", 		"Arrêt");
define("modeChauff_StopTemp", 	"Arrêt par temp ext");
define("modeChauff_StopProg",	"Arrêt en cours");

//status
define("status_init", 			"Initialisation");
define("status_stop", 			"Arrêt");
define("status_tray", 			"Init grille");
define("status_start", 			"Démarrage chaudière");
define("status_prev", 			"Contrôle allumage résiduel");
define("status_igni", 			"Allumage électrique");
define("status_StComb", 		"Démarrage combustion");
define("status_comb", 			"Combustion");
define("status_Sleep", 			"Veille");
define("status_stopAsh", 		"Arrêt pour décendrage");
define("status_ash", 			"Décendrage");
define("status_cool", 			"Refroidissement : utilisation chaleur residuelle");
define("status_clean", 			"Nettoyage");
define("status_manu", 			"Mode manuel");
define("status_assist", 		"Assistant de combustion");

//settings page
define("sett_title", 			"paramètres");
define("sett_heat", 			"Zone Chauffage");
define("sett_save", 			"Enregistrer");
define("sett_add", 				"Ajouter");
define("sett_addSeas", 			"Ajouter une saison");
define("sett_del", 				"Supprimer");
define("sett_info", 			"Info");
define("sett_info2", 			"pour chaque saison, indiquez le prix en euro par kilo de granulés");
define("sett_info3", 			"si vous avez des tarifs différents pendant la saison , indiquez le prix moyen");
define("sett_info4", 			"La suppression ne concerne que la saison avec son tarif et n'a pas d'impact sur les données de la base");

//home page
define("chart_home_title",		"Données temps réel");

//chanel
define("text_state", 			"Etat");
define("text_power", 			"Puissance");
define("text_fan", 				"Puissance du ventilateur extraction des fumées");
define("text_temp_smoke",		"Température des fumées");
define("text_temp_waterIs",		"Température eau est");
define("text_temp_waterMust",	"Température eau doit");
define("text_temp_indoor", 		"Température intérieure");
define("text_temp_outdoor", 	"Température extérieure");
define("text_temp_outdoorAvg",	"Température extérieure moyenne");
define("text_tempZ1_toHeaterIs","Température départ radiateur Z1 est");
define("text_tempZ1_toHeaterMust","Température départ radiateur Z1 doit");
define("text_tempZ2_toHeaterIs","Température départ radiateur Z2 est");
define("text_tempZ2_toHeaterMust","Température départ radiateur Z2 doit");
define("text_pump_ECS", 		"Pompe eau chaude sanitaire");
define("text_pump_heater", 		"Pompe radiateur");
define("text_pellet_left", 		"Granulés restant");
define("text_pell_consumTot",	"Consommation granulés totale");
define("text_pell_consumDay",	"Consommation du jour");
define("text_pell_inst_consum", "Consommation instantanée");
define("text_feeder", 			"pourcentage amené de la vis à granulé et conso par heure");
define("text_lambda", 			"O² Lambda");
define("text_oxyIs",			"O² est");
define("text_oxyMust",			"O² doit");
define("text_temp_returnIs", 	"Température retour est");
define("text_temp_returnMust",	"Température retour doit");
define("text_time_ash", 		"Temps pour décendrage est");
define("text_state_ash", 		"Etat décendrage");
define("text_move_ash",			"Mouvement grille");
define("text_time_screw",		"Temps vis depuis aspi");
define("text_temp_tank", 		"Temperature Ballon ECS");
define("text_state_tank", 		"Etat Ballon ECS");
define("text_var_F", 			"Variable F");
define("text_var_K", 			"Variable K");
define("text_wood",				"% bois");
define("text_suction",			"Aspiration");

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
define("chart1_titleDay",		"Fonctionnement du jour");
define("chart2_titleIgni",		"Allumage electrique");
define("gauge1_day",			"Puissance Moyenne journée");
define("gauge2_zoom",			"Puissance moyenne zoom");
define("gauge2_unzoom",			"Puissance Moy. en Chauffe");
define("gauge2_tooltip",		"Faites un zoom sur le <br>graphe pour afficher <br>la puissance moyenne <br>dans le zoom");

//consumption page
define("calendar_title",		"90 derniers jours");
define("chart1_kiloPerDay",		"Consommation granulés par jour");
define("chart1_costPerDay",		"Coût granulés par jour");
define("chart1_outTemp",		"Temperature ext moyenne");
define("chart2_title",			"Courbes du jour sélectionné");
define("chart3_title",			"Consommation annuelle");
define("chart3_annualPellet",	"Quantité annuelle");
define("chart3_Annualcost",		"Coût annuel");
define("chart4_title",			"Consommation et température moyenne par mois");
define("chart4_subTitle",		"Pour chaque saison");
define("chart4_avg",			"Moyenne");
define("chart4_avgTemp",		"T° moy");
define("chart5_title",			"historique prix achat");
define("chart5_perTon",			"Par tonne");
define("chart6_avgPrice",		"Historique prix moyen en France");
define("text_help",				"Cliquez sur une colonne au dessus pour afficher les courbes du jour ici");
define("text_perDay",			"Par jour");
define("text_perMonth",			"Par mois");
define("text_Tmin",				"Temperature minimale enregistrée");
define("text_Tmax",				"Temperature maximale enregistrée");
define("text_hotWaterAvg",		"consommation moyenne ECS");
define("text_hotWaterTip",		"Calculer depuis Jun-Jul-Aug");
define("text_Pelletmax",		"Consommation maximale de granulés");

//page About
define("text_desc1",			"site web permettant la visualisation en temps réel d'une chaudière à granulés Hargassner.");
define("text_desc2",			"Ce site est personnel et n'engage aucunement la marque Hargassner");
define("text_desc3",			"pre-requisite : ");
define("text_desc4",			"- Chaudière Hargassner NanoPK raccordée sur le reseau");
define("text_desc5",			"- MySQL/MariaDB10+ database");
define("text_desc6",			"- apache/php7.4+ server");
define("text_desc7",			"la page d'accueil est uniquement alimentée par le telnet de la chaudière et ne nécessite pas de base de données");
define("text_desc8",			"toutes les autres pages ont besoin d'une  base de données SQL/MariaDB");
?>



