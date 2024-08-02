<?php
//Charts localization
define("months", 		"['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']");
define("weekdays", 		"['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']");
define("shortMonths", 	"['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',  'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec']");

//header menu
define("menu_home", 			"Home");
define("menu_data", 			"Data");
define("menu_graph", 			"Chart");
define("menu_consumption", 		"Consumption");
define("menu_settings", 		"Settings");
define("menu_about", 			"About");

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
define("text_temp_tank", 		"Domestic hot water tank °C");
define("text_state_tank", 		"Domestic hot water state");
define("text_var_F", 			"Variable F");
define("text_var_K", 			"Variable K");
define("text_wood",				"% wood");
define("text_suction",			"Suction");

define("chart_home_title",		"Real time data");
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
define("chart1_chart_title",	"Chart of the day");
define("chart2_chart_title",	"Electric igniter");

define("gauge1_chart_day",		"Average power for the day");
define("gauge2_chart_zoom",		"Average power in zoom");
define("gauge2_chart_unzoom",	"Average power in heating");
define("gauge2_chart_tooltip",	"Zoom on chart <br>to display power average <br>inside zoom");


//consumption page
define("calendar_consum_title",	"90 last days");

define("chart1_consum_kilo",	"Pellet use by day");
define("chart1_consum_cost",	"Pellet cost by day");
define("chart1_consum_outT",	"Outdoor average temperature");

define("chart2_consum_title",	"Chart of selected day");
define("chart2_consum_serie0",	"T° Departure z1 must");
define("chart2_consum_serie1",	"T° Departure z1 is");
define("chart2_consum_serie2",	"T° boiler is");
define("chart2_consum_serie3",	"T° Outdoor");
define("chart2_consum_serie4",	"T° Indoor");
define("chart2_consum_serie5",	"Power");
define("chart2_consum_serie6",	"% wood");

// define("chart3_consum_title",	"");


?>