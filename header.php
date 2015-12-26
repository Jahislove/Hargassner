<!DOCTYPE html>
<html>
<head>
    <title>My nanoPK</title>
    <link rel="icon" type="image/png" href="img/Owl-Logo.png" />
	<link type="text/css" rel="stylesheet" href="css/main.css" />
    <link href='http://fonts.googleapis.com/css?family=Cabin+Condensed' rel='stylesheet' type='text/css'>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/highstock.js"></script>
	<script src="js/highcharts-more.js"></script>
    <script src="js/solid-gauge.src.js"></script>
    
<script type="text/javascript">	
// auto refresh div conso_instant, temps_reel with ajax/html
var gauge_signal;
var gauge_battery;
var chart_instant; // global
var id;
var solid_gauge_temp1; // global
var solid_gauge_temp2; // global
var solid_gauge_temp3; // global
var id2;
var heure;
var chart_instant2; // global
var chart_silo; // global
var etat;

function requestData() {
    call_ajax(); //call ajax immediatly on load
    id = setInterval(call_ajax, 1000); //call ajax again every 10sec
    setTimeout(stop_refresh, 600000); // 600000 stop refresh after 10 mn
};

function stop_refresh() {clearInterval(id)};

function call_ajax() {
    $.ajax({
        url: 'query_json.inc.php', 
        cache: false,
        success: function(channel) {
            // update tableInstant
            var heure = channel[0];
            channel.shift(); // supprime la 1ere valeur (date) pour etre synchro avec les numero de channel
            switch(channel[0]) { // remplace valeur num de etat par une chaine
                case 0:
                    etat = '0';
                    break;
                case 1:
                    etat = 'Arrêt';
                    break;
                case 2:
                    etat = 'Allumage';
                    break;
                case 3:
                    etat = 'Démarrage';
                    break;
                case 4:
                    etat = 'Controle allumage';
                    break;
                case 5:
                    etat = '5';
                    break;
                case 6:
                    etat = 'Démarrage combustion';
                    break;
                case 7:
                    etat = 'Combustion';
                    break;
                case 8:
                    etat = 'Veille';
                    break;
                case 9:
                    etat = 'Décendrage dans 7mn';
                    break;
                case 10:
                    etat = 'Décendrage';
                    break;
                case 11:
                    etat = '11';
                    break;
                case 12:
                    etat = 'Nettoyage';
                    break;
                default:
                    etat = '13+';
                    break;
            }        
                   
                    
            document.getElementById('row_instant').innerHTML =  '<td>' + etat         + ' </td>' +
                                                                '<td>' + channel[134] + ' %</td>' +
                                                                '<td>' + channel[3]   + ' °</td>' +
                                                                '<td>' + channel[21]  + ' °</td>' +
                                                                '<td>' + channel[138] + ' °</td>' +
                                                                '<td>' + channel[6]   + ' °</td>' +
                                                                '<td>' + channel[115] + ' kg</td>';
            //document.getElementById('test').innerHTML =  channel ; //debug
            //document.getElementById('schema').innerHTML =  '<IMG SRC="img/Nano' + channel[0] + '.jpg" ALT="Owl intuition" WIDTH=374 HEIGHT=416 >' ;

            // update chart temps reel
            // var shift = chart_instant.series[0].data.length > 900;
            // chart_instant.series[0].addPoint([heure, channel[134]], true, shift);
            // chart_instant.series[1].addPoint([heure, channel[56]], true, shift);
            // chart_instant.series[2].addPoint([heure, channel[1]], true, shift);
            
            // update gauges
            //gauge_battery.series[0].points[0].update(channel[4]);
            //gauge_signal.series[0].points[0].update(channel[5]);
            document.getElementById('datetemp').innerHTML = heure;
            solid_gauge_temp1.series[0].points[0].update(channel[6]);
            solid_gauge_temp2.series[0].points[0].update(channel[138]);
            solid_gauge_temp3.series[0].points[0].update(channel[134]);
            
            // silo
            //chart_silo.series[0].points[0].update(channel[115]);
           
            // graphe
            //voir channel.txt pour les channels
            // var shift2 = chart_instant2.series[0].data.length > 2500;
            // chart_instant2.series[0].addPoint([heure, channel[0]], true, shift2);
            // chart_instant2.series[1].addPoint([heure, channel[3]], true, shift2);
            // chart_instant2.series[2].addPoint([heure, channel[53]], true, shift2);
            // chart_instant2.series[3].addPoint([heure, channel[56]], true, shift2);
            // chart_instant2.series[4].addPoint([heure, channel[134]], true, shift2);
            // chart_instant2.series[5].addPoint([heure, channel[160]], true, shift2);
            // chart_instant2.series[6].addPoint([heure, channel[55]], true, shift2);
            // chart_instant2.series[7].addPoint([heure, channel[70]*100], true, shift2); // channel 70 = decendrage *100 pour plus de visibilité
				
                
document.getElementById('titi').innerHTML = '<table class="tg">' +
    '<tr>' +
    '<th>0</th>'+
    '<th class="tg-yw41">' + channel[0] + '</th>'+
    '<th class="tg-yw41">' + channel[3] + '</th>'+
    '<th class="tg-yw41">' + channel[53] + '</th>'+
    '<th class="tg-yw41">' + channel[56] + '</th>'+
    '<th class="tg-yw41">' + channel[134] + '</th>'+
    '<th class="tg-yw41">' + channel[160] + '</th>'+
    '<th class="tg-yw41">' + channel[55] + '</th>'+
    '<th class="tg-yw41">' + channel[4] + '</th>'+
    '<th class="tg-yw41">' + channel[21] + '</th>'+
    '<th class="tg-yw41">' + channel[23] + '</th>'+
    '</tr>' +
 ' </tr></table>';

    
    document.getElementById('toto').innerHTML = '<table class="tg">' +
    '<tr>' +
    '<th>0</th>'+
    '<th class="tg-yw4l">' + channel[0] + '</th>'+
    '<th class="tg-yw4l">' + channel[1] + '</th>'+
    '<th class="tg-yw4l">' + channel[2] + '</th>'+
    '<th class="tg-yw4l">' + channel[3] + '</th>'+
    '<th class="tg-yw4l">' + channel[4] + '</th>'+
    '<th class="tg-yw4l">' + channel[5] + '</th>'+
    '<th class="tg-yw4l">' + channel[6] + '</th>'+
    '<th class="tg-yw4l">' + channel[7] + '</th>'+
    '<th class="tg-yw4l">' + channel[8] + '</th>'+
    '<th class="tg-yw4l">' + channel[9] + '</th>'+
    '</tr>' +
    '<tr>' +
    '<th>1</th>'+
    '<td class="tg-yw4l">' + channel[10] + '</td>'+
    '<td class="tg-yw4l">' + channel[11] + '</td>'+
    '<td class="tg-yw4l">' + channel[12] + '</td>'+
    '<td class="tg-yw4l">' + channel[13] + '</td>'+
    '<td class="tg-yw4l">' + channel[14] + '</td>'+
    '<td class="tg-yw4l">' + channel[15] + '</td>'+
    '<td class="tg-yw4l">' + channel[16] + '</td>'+
    '<td class="tg-yw4l">' + channel[17] + '</td>'+
    '<td class="tg-yw4l">' + channel[18] + '</td>'+
    '<td class="tg-yw4l">' + channel[19] + '</td>'+
    '</tr>' +
    '<tr>' +
    '<th>2</th>'+
    '<td class="tg-yw4l">' + channel[20] + '</td>'+
    '<td class="tg-yw4l">' + channel[21] + '</td>'+
    '<td class="tg-yw4l">' + channel[22] + '</td>'+
    '<td class="tg-yw4l">' + channel[23] + '</td>'+
    '<td class="tg-yw4l">' + channel[24] + '</td>'+
    '<td class="tg-yw4l">' + channel[25] + '</td>'+
    '<td class="tg-yw4l">' + channel[26] + '</td>'+
    '<td class="tg-yw4l">' + channel[27] + '</td>'+
    '<td class="tg-yw4l">' + channel[28] + '</td>'+
    '<td class="tg-yw4l">' + channel[29] + '</td>'+
    '<tr>' +
    '<th>3</th>'+
    '<td class="tg-yw4l">' + channel[30] + '</td>'+
    '<td class="tg-yw4l">' + channel[31] + '</td>'+
    '<td class="tg-yw4l">' + channel[32] + '</td>'+
    '<td class="tg-yw4l">' + channel[33] + '</td>'+
    '<td class="tg-yw4l">' + channel[34] + '</td>'+
    '<td class="tg-yw4l">' + channel[35] + '</td>'+
    '<td class="tg-yw4l">' + channel[36] + '</td>'+
    '<td class="tg-yw4l">' + channel[37] + '</td>'+
    '<td class="tg-yw4l">' + channel[38] + '</td>'+
    '<td class="tg-yw4l">' + channel[39] + '</td>'+
    '</tr>' +
    '<tr>' +
    '<th>4</th>'+
    '<td class="tg-yw4l">' + channel[40] + '</td>'+
    '<td class="tg-yw4l">' + channel[41] + '</td>'+
    '<td class="tg-yw4l">' + channel[42] + '</td>'+
    '<td class="tg-yw4l">' + channel[43] + '</td>'+
    '<td class="tg-yw4l">' + channel[44] + '</td>'+
    '<td class="tg-yw4l">' + channel[45] + '</td>'+
    '<td class="tg-yw4l">' + channel[46] + '</td>'+
    '<td class="tg-yw4l">' + channel[47] + '</td>'+
    '<td class="tg-yw4l">' + channel[48] + '</td>'+
    '<td class="tg-yw4l">' + channel[49] + '</td>'+
    '</tr>' +
    '<tr>' +
    '<th>5</th>'+
    '<td class="tg-yw4l">' + channel[50] + '</td>'+
    '<td class="tg-yw4l">' + channel[51] + '</td>'+
    '<td class="tg-yw4l">' + channel[52] + '</td>'+
    '<td class="tg-yw4l">' + channel[53] + '</td>'+
    '<td class="tg-yw4l">' + channel[54] + '</td>'+
    '<td class="tg-yw4l">' + channel[55] + '</td>'+
    '<td class="tg-yw4l">' + channel[56] + '</td>'+
    '<td class="tg-yw4l">' + channel[57] + '</td>'+
    '<td class="tg-yw4l">' + channel[58] + '</td>'+
    '<td class="tg-yw4l">' + channel[59] + '</td>'+
    '</tr>' +
    '<tr>' +
    '<th>6</th>'+
    '<td class="tg-yw4l">' + channel[60] + '</td>'+
    '<td class="tg-yw4l">' + channel[61] + '</td>'+
    '<td class="tg-yw4l">' + channel[62] + '</td>'+
    '<td class="tg-yw4l">' + channel[63] + '</td>'+
    '<td class="tg-yw4l">' + channel[64] + '</td>'+
    '<td class="tg-yw4l">' + channel[65] + '</td>'+
    '<td class="tg-yw4l">' + channel[66] + '</td>'+
    '<td class="tg-yw4l">' + channel[67] + '</td>'+
    '<td class="tg-yw4l">' + channel[68] + '</td>'+
    '<td class="tg-yw4l">' + channel[69] + '</td>'+
    '</tr>' +
    '<tr>' +
    '<th>7</th>'+
    '<td class="tg-yw4l">' + channel[70] + '</td>'+
    '<td class="tg-yw4l">' + channel[71] + '</td>'+
    '<td class="tg-yw4l">' + channel[72] + '</td>'+
    '<td class="tg-yw4l">' + channel[73] + '</td>'+
    '<td class="tg-yw4l">' + channel[74] + '</td>'+
    '<td class="tg-yw4l">' + channel[75] + '</td>'+
    '<td class="tg-yw4l">' + channel[76] + '</td>'+
    '<td class="tg-yw4l">' + channel[77] + '</td>'+
    '<td class="tg-yw4l">' + channel[78] + '</td>'+
    '<td class="tg-yw4l">' + channel[79] + '</td>'+
    '</tr>' +
    '<tr>' +
    '<th>8</th>'+
    '<td class="tg-yw4l">' + channel[80] + '</td>'+
    '<td class="tg-yw4l">' + channel[81] + '</td>'+
    '<td class="tg-yw4l">' + channel[82] + '</td>'+
    '<td class="tg-yw4l">' + channel[83] + '</td>'+
    '<td class="tg-yw4l">' + channel[84] + '</td>'+
    '<td class="tg-yw4l">' + channel[85] + '</td>'+
    '<td class="tg-yw4l">' + channel[86] + '</td>'+
    '<td class="tg-yw4l">' + channel[87] + '</td>'+
    '<td class="tg-yw4l">' + channel[88] + '</td>'+
    '<td class="tg-yw4l">' + channel[89] + '</td>'+
    '</tr>' +
    '<tr>' +
    '<th>9</th>'+
    '<td class="tg-yw4l">' + channel[90] + '</td>'+
    '<td class="tg-yw4l">' + channel[91] + '</td>'+
    '<td class="tg-yw4l">' + channel[92] + '</td>'+
    '<td class="tg-yw4l">' + channel[93] + '</td>'+
    '<td class="tg-yw4l">' + channel[94] + '</td>'+
    '<td class="tg-yw4l">' + channel[95] + '</td>'+
    '<td class="tg-yw4l">' + channel[96] + '</td>'+
    '<td class="tg-yw4l">' + channel[97] + '</td>'+
    '<td class="tg-yw4l">' + channel[98] + '</td>'+
    '<td class="tg-yw4l">' + channel[99] + '</td>'+
    '</tr>' +
    '<tr>' +
    '<th>10</th>'+
    '<th class="tg-yw4l">' + channel[100] + '</th>'+
    '<th class="tg-yw4l">' + channel[101] + '</th>'+
    '<th class="tg-yw4l">' + channel[102] + '</th>'+
    '<th class="tg-yw4l">' + channel[103] + '</th>'+
    '<th class="tg-yw4l">' + channel[104] + '</th>'+
    '<th class="tg-yw4l">' + channel[105] + '</th>'+
    '<th class="tg-yw4l">' + channel[106] + '</th>'+
    '<th class="tg-yw4l">' + channel[107] + '</th>'+
    '<th class="tg-yw4l">' + channel[108] + '</th>'+
    '<th class="tg-yw4l">' + channel[109] + '</th>'+
    '</tr>' +
    '<tr>' +
    '<th>11</th>'+
    '<td class="tg-yw4l">' + channel[110] + '</td>'+
    '<td class="tg-yw4l">' + channel[111] + '</td>'+
    '<td class="tg-yw4l">' + channel[112] + '</td>'+
    '<td class="tg-yw4l">' + channel[113] + '</td>'+
    '<td class="tg-yw4l">' + channel[114] + '</td>'+
    '<td class="tg-yw4l">' + channel[115] + '</td>'+
    '<td class="tg-yw4l">' + channel[116] + '</td>'+
    '<td class="tg-yw4l">' + channel[117] + '</td>'+
    '<td class="tg-yw4l">' + channel[118] + '</td>'+
    '<td class="tg-yw4l">' + channel[119] + '</td>'+
    '</tr>' +
    '<tr>' +
    '<th>12</th>'+
    '<td class="tg-yw4l">' + channel[120] + '</td>'+
    '<td class="tg-yw4l">' + channel[121] + '</td>'+
    '<td class="tg-yw4l">' + channel[122] + '</td>'+
    '<td class="tg-yw4l">' + channel[123] + '</td>'+
    '<td class="tg-yw4l">' + channel[124] + '</td>'+
    '<td class="tg-yw4l">' + channel[125] + '</td>'+
    '<td class="tg-yw4l">' + channel[126] + '</td>'+
    '<td class="tg-yw4l">' + channel[127] + '</td>'+
    '<td class="tg-yw4l">' + channel[128] + '</td>'+
    '<td class="tg-yw4l">' + channel[129] + '</td>'+
    '<tr>' +
    '<th>13</th>'+
    '<td class="tg-yw4l">' + channel[130] + '</td>'+
    '<td class="tg-yw4l">' + channel[131] + '</td>'+
    '<td class="tg-yw4l">' + channel[132] + '</td>'+
    '<td class="tg-yw4l">' + channel[133] + '</td>'+
    '<td class="tg-yw4l">' + channel[134] + '</td>'+
    '<td class="tg-yw4l">' + channel[135] + '</td>'+
    '<td class="tg-yw4l">' + channel[136] + '</td>'+
    '<td class="tg-yw4l">' + channel[137] + '</td>'+
    '<td class="tg-yw4l">' + channel[138] + '</td>'+
    '<td class="tg-yw4l">' + channel[139] + '</td>'+
    '</tr>' +
    '<tr>' +
    '<th>14</th>'+
    '<td class="tg-yw4l">' + channel[140] + '</td>'+
    '<td class="tg-yw4l">' + channel[141] + '</td>'+
    '<td class="tg-yw4l">' + channel[142] + '</td>'+
    '<td class="tg-yw4l">' + channel[143] + '</td>'+
    '<td class="tg-yw4l">' + channel[144] + '</td>'+
    '<td class="tg-yw4l">' + channel[145] + '</td>'+
    '<td class="tg-yw4l">' + channel[146] + '</td>'+
    '<td class="tg-yw4l">' + channel[147] + '</td>'+
    '<td class="tg-yw4l">' + channel[148] + '</td>'+
    '<td class="tg-yw4l">' + channel[149] + '</td>'+
    '</tr>' +
    '<tr>' +
    '<th>15</th>'+
    '<td class="tg-yw4l">' + channel[150] + '</td>'+
    '<td class="tg-yw4l">' + channel[151] + '</td>'+
    '<td class="tg-yw4l">' + channel[152] + '</td>'+
    '<td class="tg-yw4l">' + channel[153] + '</td>'+
    '<td class="tg-yw4l">' + channel[154] + '</td>'+
    '<td class="tg-yw4l">' + channel[155] + '</td>'+
    '<td class="tg-yw4l">' + channel[156] + '</td>'+
    '<td class="tg-yw4l">' + channel[157] + '</td>'+
    '<td class="tg-yw4l">' + channel[158] + '</td>'+
    '<td class="tg-yw4l">' + channel[159] + '</td>'+
    '</tr>' +
    '<tr>' +
    '<th>16</th>'+
    '<td class="tg-yw4l">' + channel[160] + '</td>'+
    '<td class="tg-yw4l">' + channel[161] + '</td>'+
    '<td class="tg-yw4l">' + channel[162] + '</td>'+
    '<td class="tg-yw4l">' + channel[163] + '</td>'+
    '<td class="tg-yw4l">' + channel[164] + '</td>'+
    '<td class="tg-yw4l">' + channel[165] + '</td>'+
    '<td class="tg-yw4l">' + channel[166] + '</td>'+
    '<td class="tg-yw4l">' + channel[167] + '</td>'+
    '<td class="tg-yw4l">' + channel[168] + '</td>'+
    '<td class="tg-yw4l">' + channel[169] + '</td>'+
    '</tr>' +
 ' </tr></table>';

			},
		});
	};
    
</script>

</head>

<body>
	<?php require_once("conf/config.inc.php");?>
	<?php require_once("conf/connectBDD.inc.php");?>
    
	<header>
		<h1>
		    My Own 
		    <IMG SRC="img/Owl-Intuition.png" ALT="Owl intuition" WIDTH=115 HEIGHT=33 >
		    <!-- <IMG SRC="img/Owl-Logo.png" ALT="Logo" WIDTH=30 HEIGHT=30 > -->
		</h1>
	</header>

	<nav>
		<ul class="fancyNav">
			<li id="home">   <a href="index.php" class="homeIcon">Accueil</a></li>
			<li id="chart">  <a href="graph_highchart.php">temps reel</a></li>
			<li id="eco">    <a href="graph_highchart2.php">2</a></li>
			<li id="cost">   <a href="graph_highchart3.php">3</a></li>
			<li id="spa">    <a href="graph_spa.php">-</a></li>
			<li id="temp">   <a href="graph_meteo.php">-</a></li>
			<li id="about">  <a href="about.php">a propos</a></li>
		</ul>
	</nav>

	<div id="bandeau">
		<!-- <div id="battery"></div>  -->
		<div id="conso_instant"> 
			<table class="TableInstant">
				<tr>
					<td>Etat</td>
					<td>Puissance</td>
					<td>T° chaudière</td>
					<td>T° départ</td>
					<td>T° int</td>
					<td>T° ext</td>
					<td>Pellets</td>
				</tr>
				<tr id="row_instant">
				</tr>
			</table>
		</div>
		<!-- <div id="signal"></div>  -->
	</div>
        <div id='clear'>
	</div>
	
    <div id="temp0">
		<div id="datetemp"></div>
		<div id="temps_reel"></div>
        <div id="temp1"></div>
        <div id="temp2"></div>
        <div id="temp3"></div>
    </div>

    <div id="silo"> </div>

    <div id="test"> </div>
	
	<?php //require("graph_battery.inc.php"); ?>
	<?php //require("graph_signal.inc.php"); ?>
	<?php //require("graph_temps_reel.inc.php");?>
	<?php require("graph_solid_gauge.inc.php"); ?>
	<?php //require("graph_silo.inc.php"); ?>
	

