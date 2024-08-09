<?php
//English localization
//define("Constant_name<=doNotModify",	"word to translate");
//Charts localization
define("months", 		"'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'");
define("weekdays", 		"'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'");
define("shortMonths", 	"'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',  'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'");

//header menu
define("menu_home", 			"Home");
define("menu_data", 			"Data");
define("menu_graph", 			"Chart");
define("menu_consumption", 		"Consumption");
define("menu_settings", 		"Settings");
define("menu_about", 			"About");

define("modeCommand_auto", 		"Auto mode");
define("modeCommand_nigh", 		"Night mode forced");
define("modeCommand_comf", 		"Comfort mode forced");
define("modeCommand_stop",		"Stop");
define("modeCommand_tmpComf", 	"Temporary comfort mode");
define("modeCommand_tmpNigh", 	"Temporary Night mode");

define("modeChauff_Summ", 		"Summer mode");
define("modeChauff_Comf", 		"Comfort mode");
define("modeChauff_Red", 		"Comfort => Night mode");
define("modeChauff_Nigh", 		"Night mode");
define("modeChauff_Stop", 		"Stop");
define("modeChauff_StopTemp", 	"Stop from outside temp");
define("modeChauff_StopProg",	"Stop in progress");

//status
define("status_init", 			"Initialization");
define("status_stop", 			"Stop");
define("status_tray", 			"Init tray"); //ash grid
define("status_start", 			"Starting boiler");
define("status_prev", 			"Control previous fire");
define("status_igni", 			"Electric igniter");
define("status_StComb", 		"Starting combustion");
define("status_comb", 			"Combustion");
define("status_Sleep", 			"Sleep");
define("status_stopAsh", 		"Stopping for ash removal");
define("status_ash", 			"Ash removal");
define("status_cool", 			"Cooling");
define("status_clean", 			"Cleaning");
define("status_manu", 			"Manual mode");
define("status_assist", 		"Combustion assist");

//settings page
define("sett_title", 			"parameters");
define("sett_heat", 			"Heating zone");
define("sett_save", 			"Save");
define("sett_add", 				"Add");
define("sett_addSeas", 			"Add a season");
define("sett_del", 				"Delete");
define("sett_info", 			"Info");
define("sett_info2", 			"For each season, enter price/kilo of pellet");
define("sett_info3", 			"if you have different price during season then use the average price");
define("sett_info4", 			"deleting a season only delete the name of season and the price. all boiler data are preserved");

//home page
define("chart_home_title",		"Real time data");

//chanel
define("text_state", 			"State");
define("text_power", 			"Power");
define("text_fan", 				"Smoke Fan exhaust ");
define("text_temp_smoke",		"Smoke Temperature");
define("text_temp_waterIs",		"Boiler Temperature is");
define("text_temp_waterMust",	"Boiler Temperature must");
define("text_temp_indoor", 		"Indoor Temperature");
define("text_temp_outdoor", 	"Outdoor Temperature");
define("text_temp_outdoorAvg",	"Outdoor Temperature avg");
define("text_tempZ1_toHeaterIs","Departure heater Z1 Temp is ");
define("text_tempZ1_toHeaterMust","Departure heater Z1 Temp must");
define("text_tempZ2_toHeaterIs","Departure heater Z2 Temp is ");
define("text_tempZ2_toHeaterMust","Departure heater Z2 Temp must");
define("text_pump_ECS", 		"Domestic hot water pump");
define("text_pump_heater", 		"Heater pump");
define("text_pellet_left", 		"Pellet left");
define("text_pell_consumTot",	"Total Pellet consumption");
define("text_pell_consumDay",	"Consumption of the day");
define("text_pell_inst_consum", "Instant consumption");
define("text_feeder", 			"Pellet screw feed and consumption per hour");
define("text_lambda", 			"O² Lambda");
define("text_oxyIs",			"O² is");
define("text_oxyMust",			"O² must");
define("text_temp_returnIs", 	"return Temperature is");
define("text_temp_returnMust",	"return Temperature must");
define("text_time_ash", 		"Time for ash removal is");
define("text_state_ash", 		"ash removal state");
define("text_move_ash",			"Ashtray grid move");
define("text_time_screw",		"Time screw since last suction");
define("text_temp_tank", 		"Domestic hot water tank");
define("text_state_tank", 		"Domestic hot water state");
define("text_var_F", 			"Variable F");
define("text_var_K", 			"Variable K");
define("text_wood",				"% wood");
define("text_suction",			"Suction");

//data page
define("help_msg",				"\
		The array show real time data from telnet and is mainly use for debuging new firmware<br/>\
		by clicking on a case , it show a line coresponding to the Telnet chanel and his true column in the Database.<br/>\
		for exemple , in the first firmwares we got  telnet chanel 10 (t10) = column 10 (c10)<br/>\
		However, over the time, Hargassner has modified the order of the parameters inside the telnet<br/>\
		so now, the column in the database is no longer always the same as the telnet chanel,<br/>\
		it display the Telnet chanel (t..), his true column in the database (c..) and his desciption if known\
		");

//chart page
define("chart1_titleDay",		"Chart of the day");
define("chart2_titleIgni",		"Electric igniter");
define("gauge1_day",			"Average power for the day");
define("gauge2_zoom",			"Average power in zoom");
define("gauge2_unzoom",			"Average power in heating");
define("gauge2_tooltip",		"Zoom on chart <br>to display power average <br>inside zoom");

//consumption page
define("calendar_title",		"90 last days");
define("chart1_kiloPerDay",		"Pellet use per day");
define("chart1_costPerDay",		"Pellet cost per day");
define("chart1_outTemp",		"Outdoor average temperature");
define("chart2_title",			"Chart of selected day");
define("chart3_title",			"Annual consumption");
define("chart3_annualPellet",	"Annual Quantity");
define("chart3_Annualcost",		"Annual Cost");
define("chart4_title",			"Consumption and Average temperature per month");
define("chart4_subTitle",		"For each season");
define("chart4_avg",			"Average");
define("chart4_avgTemp",		"T° avg");
define("chart5_title",			"Historic price purchase");
define("chart5_perTon",			"per ton");
define("chart6_avgPrice",		"Historic average price in France");
define("text_help",				"Click on column above to display chart of this day here");
define("text_perDay",			"per day");
define("text_perMonth",			"per month");
define("text_Tmin",				"Min temperature ever");
define("text_Tmax",				"Max temperature ever");
define("text_hotWaterAvg",		"Average consumtion hot water");
define("text_hotWaterTip",		"Calculated from Jun-Jul-Aug");
define("text_Pelletmax",		"Max pellet consumption");

//page About
define("text_desc1",			"web site for real time vizualisation of an Hargassner Pellet Boiler");
define("text_desc2",			"this is a personal web site and there is no link with official Hargasnner");
define("text_desc3",			"pre-requisite : ");
define("text_desc4",			"- Hargassner boiler pluged in your network");
define("text_desc5",			"- MySQL/MariaDB10+ database");
define("text_desc6",			"- apache/php7.4+ server");
define("text_desc7",			"home page is only provided with fresh data from boiler telnet and will work even without database");
define("text_desc8",			"all other page need a ySQL/MariaDB database");

//installation new version
define("text_OK",				"OK");
define("text_ERROR",			"ERROR");
define("text_download",			"Downloading new version");
define("text_cancel",			"Canceling installation");
define("text_extract",			"Unzipping new version");
define("text_delete",			"Deleting old backup");
define("text_backup",			"Backup");
define("text_update",			"Installation");
define("text_help",				"Check right of directory hargassner , user or group http must have writing right");
define("text_gitko",			"Can't reach github.com , try again later");
define("text_gitmsg",			"If error persist, check if your php server is launched with openssl and zip extensions");
define("text_new",				"New version available");

// known error list
define("TabErreur",	array(
					0 => "OK",
					5 => "Please empty ash tray",
					6 => "Ash tray full",
					7 => "Ash tray is stuck",
					9 => "Overload cleaning motor (springs are stuck)",
					15 => "tank 1 sensor problem",
					27 => "Smoke temperature too low",
					29 => "Combustion fault, start impossible",
					32 => "Filling time exceeded",	
					49 => "Smoke fan fault",	
					70 => "Pellet stock low",
					93 => "Ash tray open",
					229 => "Check/clean pellet level sensor(inside boiler)",
					371 => "Check fireplace, clean if necessary",
					7101 => "Time max for domestic hot water exceeded. check hours, sensor, pump",
					65402 => "Can't connect to web server"
					)
		);

?>