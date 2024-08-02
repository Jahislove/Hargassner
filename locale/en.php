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

//home page
define("text_state", 			"State");
define("text_power", 			"Power");
define("text_fan", 				"Smoke Fan exhaust ");
define("text_temp_smoke",		"Smoke Temperature");
define("text_temp_waterIs",		"Boiler Temperature is");
define("text_temp_waterMust",	"Boiler Temperature must");
define("text_temp_indoor", 		"Indoor Temperature");
define("text_temp_outdoor", 	"Outdoor Temperature");
define("text_temp_outdoorAvg",	"Outdoor Temperature avg");
define("text_temp_toHeaterIs", 	"Departure heater Temp is ");
define("text_temp_toHeaterMust","Departure heater Temp must");
define("text_pump_ECS", 		"Domestic hot water pump");
define("text_pump_heater", 		"Heater pump");
define("text_pellet_left", 		"Pellet left");
define("text_pellet_consum",	"Pellet consumption");
define("text_feeder", 			"Pellet screw feed and consumption per hour");
define("text_lambda", 			"O² Lambda");
define("text_temp_returnIs", 	"return Temperature is");
define("text_temp_returnMust",	"return Temperature must");
define("text_time_ash", 		"Time for ash removal is");
define("text_move_ash",			"Ashtray grid move");
define("text_time_screw",		"Time screw since last suction");
define("text_temp_tank", 		"Domestic hot water tank °C");
define("text_state_tank", 		"Dom. hot water t. On/Off/recyc");
define("text_var_F", 			"Variable F");
define("text_var_K", 			"Variable K");
define("text_wood",				"% wood");

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

define("chart1_chart_serie0",	"State");
define("chart1_chart_serie1",	"Ash removal");
define("chart1_chart_serie2",	"Power");
define("chart1_chart_serie3",	"T° boiler is");
define("chart1_chart_serie4",	"T° boiler must");
define("chart1_chart_serie5",	"T° smoke");
define("chart1_chart_serie6",	"T° Outdoor");
define("chart1_chart_serie7",	"O² is");
define("chart1_chart_serie8",	"O² must");
define("chart1_chart_serie9",	"exhaust fan speed");
define("chart1_chart_serie10",	"T° domestic water tank");
define("chart1_chart_serie11",	"% wood");
define("chart1_chart_serie12",	"T° Outdoor avg");
define("chart1_chart_serie13",	"T° Indoor");
define("chart1_chart_serie14",	"T° Departure z1 is");
define("chart1_chart_serie15",	"T° Departure z1 must");
define("chart1_chart_serie16",	"T° Departure z2 is");
define("chart1_chart_serie17",	"T° Departure z2 must");
define("chart1_chart_serie18",	"Consumption of the day");
define("chart1_chart_serie19",	"domestic water tank state");
define("chart1_chart_serie20",	"Suction");
define("chart1_chart_serie21",	"T° return");
define("chart1_chart_serie22",	"Time ash removal");
define("chart1_chart_serie23",	"Instant consumption");

define("gauge1_chart_day",		"Average power for the day");
define("gauge2_chart_zoom",		"Average power in zoom");
define("gauge2_chart_unzoom",	"Average power in heating");
define("gauge2_chart_tooltip",		"Zoom on chart <br>to display power average <br>inside zoom");

define("chart2_chart_title",	"Electric igniter");

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