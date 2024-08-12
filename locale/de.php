<?php
//Deutch localization (need tranlation)
//define("Constant_name<=doNotModify",	"word to translate");
//Charts localization
define("months", 		"'Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'");
define("weekdays", 		"'Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'");
define("shortMonths", 	"'Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun',  'Jul', 'Aug', 'Sept', 'Okt', 'Nov', 'Dez'");

//header menu
define("menu_home", 			"Home");
define("menu_data", 			"Daten");
define("menu_graph", 			"Messwerte");
define("menu_consumption", 		"Verbrauch");
define("menu_settings", 		"Einstellungen");
define("menu_about", 			"Über");

define("modeCommand_auto", 		"Automatik-Modus");
define("modeCommand_nigh", 		"manueller Nachtbetrieb");
define("modeCommand_comf", 		"manueller Komfort-Modus");
define("modeCommand_stop",		"Stop");
define("modeCommand_tmpComf", 	"Temporärer Komfort-Modus");
define("modeCommand_tmpNigh", 	"Temporärer Nachtbetrieb");

define("modeChauff_Summ", 		"Sommerbetrieb");
define("modeChauff_Comf", 		"Komfort-Modus");
define("modeChauff_Red", 		"Komfort-Modus => Nachtbetrieb");
define("modeChauff_Nigh", 		"Nachtbetrieb");
define("modeChauff_Stop", 		"Stop");
define("modeChauff_StopTemp", 	"Außentemperatur-Abschaltung");
define("modeChauff_StopProg",	"Stopp läuft");

//status
define("status_init", 			"Initialisierung");
define("status_stop", 			"Stop");
define("status_tray", 			"Initialisierung Entaschung"); //ash grid
define("status_start", 			"Kessel starten");
define("status_prev", 			"Prüfung vorherige Feuerung");
define("status_igni", 			"Elektrische Zündung");
define("status_StComb", 		"Starten der Verbrennung");
define("status_comb", 			"Verbrennung");
define("status_Sleep", 			"Sleep");
define("status_stopAsh", 		"Stopp für Entaschung");
define("status_ash", 			"Entaschung");
define("status_cool", 			"Kühlung");
define("status_clean", 			"Reinigung");
define("status_manu", 			"Manueller Modus");
define("status_assist", 		"Verbrennungsunterstützung");

//settings page
define("sett_title", 			"Parameter");
define("sett_heat", 			"Heizkreis");
define("sett_save", 			"Sichern");
define("sett_add", 				"Zufügen");
define("sett_addSeas", 			"Eine Heizperiode zufügen");
define("sett_del", 				"Löschen");
define("sett_info", 			"Info");
define("sett_info2", 			"Eingabe Pelletpreis / Kilo pro Heizperiode");
define("sett_info3", 			"Wenn es während der Heizperiode unterschiedliche Preise gibt, nehmen Sie den Durschnittspreis");
define("sett_info4", 			"Das Löschen der Werte pro Heizperiode löscht nur den Namen und den Preis. Alle Kesseldaten bleiben erhalten.");

//home page
define("chart_home_title",		"Echtzeitdaten");

//chanel
define("text_state", 				"Status");
define("text_power", 				"Power");
define("text_fan", 					"Rauchabzug durch Ventilator");
define("text_temp_smoke",			"Rauchgastemperatur");
define("text_temp_waterIs",			"Kessel Temperatur Ist");
define("text_temp_waterMust",		"Kessel Temperatur Soll");
define("text_temp_indoor", 			"Innentemperatur");
define("text_temp_outdoor", 		"Außentemperatur");
define("text_temp_outdoorAvg",		"Außentemperatur gemittelt");
define("text_tempZ1_toHeaterIs",	"Vorlauftemperatur Z1 ist");
define("text_tempZ1_toHeaterMust",	"Vorlauftemperatur Z1 Soll");
define("text_tempZ2_toHeaterIs",	"Vorlauftemperatur Z2 ist");
define("text_tempZ2_toHeaterMust",	"Vorlauftemperatur Z2 Soll");
define("text_pump_ECS", 			"Brauchwarmwasserpumpe");
define("text_pump_heater", 			"Heizkreispumpe");
define("text_pellet_left", 			"Lagerstand");
define("text_pell_consumTot",		"Gesamtverbrauch Pellets");
define("text_pell_consumDay",		"Verbrauch pro Tag");
define("text_pell_inst_consum", 	"Aktueller Verbrauch");
define("text_feeder", 				"Pelletschneckenförderung und Verbrauch / Stunde");
define("text_lambda", 				"O² Lambda");
define("text_oxyIs",				"O² Ist");
define("text_oxyMust",				"O² Soll");
define("text_temp_returnIs", 		"Rücklauf Temperatur Ist");
define("text_temp_returnMust",		"Rücklauf Temperatur Soll");
define("text_time_ash", 			"Time for ash removal is");
define("text_state_ash", 			"Status Entaschung");
define("text_move_ash",				"Bewegung Schieberost");
define("text_time_screw",			"Zeit nach der letzten Ansaugung");
define("text_temp_tank", 			"Brauchwasserspeicher");
define("text_state_tank", 			"Status Brauchwasserspeicher");
define("text_var_F", 				"Variable F");
define("text_var_K", 				"Variable K");
define("text_wood",					"% Holz");
define("text_suction",				"Absaugung");

//data page
define("help_msg",				"\
		Das Array zeigt Echtzeitdaten von Telnet und wird hauptsächlich zum Debuggen neuer Firmware verwendet.<br/>\
		Durch Klicken auf ein Kästchen wird eine Zeile angezeigt, die dem Telnet-Kanal und seiner wahren Spalte<br/>\
		in der Datenbank entspricht. In den ersten Firmwares hatten wir beispielsweise Telnet-Kanal 10 (t10) = Spalte 10 (c10).<br/>\
		Im Laufe der Zeit hat Hargassner jedoch die Reihenfolge der Parameter innerhalb des Telnet geändert,<br/>\
		sodass die Spalte in der Datenbank jetzt nicht mehr immer mit dem Telnet-Kanal übereinstimmt.<br/>\
		Sofern bekannt, werden der Telnet-Kanal (t..), seine wahre Spalte in der Datenbank (c..)<br/>\
		und seine Beschreibung angezeigt.\
		");

//chart page
define("chart1_titleDay",		"Tagesdiagramm");
define("chart2_titleIgni",		"Electrische Zündung");
define("gauge1_day",			"Durschnittliche Leistung pro Tag");
define("gauge2_zoom",			"Durschnittliche Leistung in ");
define("gauge2_unzoom",			"Durschnittliche Heizleistung ");
define("gauge2_tooltip",		"Klicke auf das Diagramm<br>um die Durchschnittsleitung<br>anzuzeigen");

//consumption page
define("calendar_title",		"letzte 90 Tage");
define("chart1_kiloPerDay",		"Pelletverbrauch pro Tag");
define("chart1_costPerDay",		"Pelletkosten pro Tag");
define("chart1_outTemp",		"Durchnittsaußentemperatur ");
define("chart2_title",			"Diagramm des ausgewählten Tages");
define("chart3_title",			"jährlicher Verbrauch");
define("chart3_annualPellet",	"jährliche Menge");
define("chart3_Annualcost",		"jährliche Kosten");
define("chart4_title",			"monatlicher Verbrauch und Durchnittstemperatur");
define("chart4_subTitle",		"für jede Heizperiode");
define("chart4_avg",			"Durchschnitt");
define("chart4_avgTemp",		"Durchnittstemperatur");
define("chart5_title",			"Historie Kaufpreis");
define("chart5_perTon",			"pro Tonne");
define("chart6_avgPrice",		"durchsnittlicher Pelletpreis in Deutschland");
define("text_help",				"Klicke auf die Spalte oben um das Diagramm des Tages anzuzeigen.");
define("text_perDay",			"pro Tag");
define("text_perMonth",			"pro Monat");
define("text_Tmin",				"niedrigste Temperatur aller Zeiten");
define("text_Tmax",				"höchste Temperatur aller Zeiten");
define("text_hotWaterAvg",		"durchsnittlicher Warmwasserverbrauch");
define("text_hotWaterTip",		"berechnet von Jun-Jul-Aug");
define("text_Pelletmax",		"max. Pelletverbrauch");

//page About
define("text_desc1",			"Diese Seite ist die Echtzeitanzeige des Hargassner Pellet Kessels");
define("text_desc2",			"Die Seite ist lokal und hat keine Verbindung oder sonstige Links zum Hersteller");
define("text_desc3",			"Systemvoraussetzungen: ");
define("text_desc4",			"- Hargassner Kessel muss im lokalen Netzwerk erreichbar sein");
define("text_desc5",			"- MySQL/MariaDB10+ Datenbank");
define("text_desc6",			"- apache/php7.4+ Webserver");
define("text_desc7",			"Die Startseite zeigt nur die aktuellen Daten an, die per Telnet vom Kessel kommen. Sei funktioniert auch ohne Datenbank");
define("text_desc8",			"Alle anderen Seiten benötigen eine MySQL/MariaDB Datenbank");

//installation new version
define("text_OK",				"OK");
define("text_ERROR",			"FEHLER");
define("text_download",			"Herunterladen der neuen Version");
define("text_cancel",			"Abbruch Installation");
define("text_extract",			"Entpacken der neuen Version");
define("text_delete",			"Löschen altes Backup");
define("text_backup",			"Backup");
define("text_update",			"Installation");
define("text_help",				"Berechtigung vom Verzeichnis hargassner prüfen, user oder group http muss Schreibberechtigung haben");
define("text_gitko",			"Kann github.com nicht erreichen, versuche es später noch einmal");
define("text_gitmsg",			"Wenn der Fehler bestehen bleibt, überprüfe, dass der php-Server mit der openssl-Erweiterung und dass die zip Erweiterung installiert ist.");
define("text_new",				"Neue Version verfügbar");

// known error list
define("TabErreur",	array(
					0 => "OK",
					5 => "Aschelade entleeren",
					6 => "Aschelade ist zu voll",
					7 => "Aschebox verklemmt",
					9 => "Überstrom Ascheschnecke",
					15 => "Unterbrechung Boilerfühler 1",
					27 => "Rauchgastemperatur unterschritten",
					29 => "Verbrennungsstörung! Start nicht möglich",
					32 => "Maximale Füllzeit überschritten",	
					49 => "Saugzuggebläse Störung",	
					70 => "Pelletslagerstand gering",
					93 => "Aschelade offen",
					229 => "Bitte Füllstandsmelder reinigen / kontrollieren",
					371 => "Brennraum auf Verschmutzung prüfen, gegebenenfalls reinigen",
					7101 => "Max. Boilerladezeit überschritten, Boilerladung träge! Fühlerposition prüfen, Durchfluss prüfen, Heizungsbauer verständigen",
					65402 => "Can't connect to web server"
					)
		);

?>

