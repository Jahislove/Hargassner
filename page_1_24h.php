<?php require("header.php"); ?>

<div id="chart_last24"></div>

<?php
	require_once("conf/settings.inc.php");
    // $chart_last24_name = ['T° depart consigne','T° depart','T° chaudière','T° extérieur','T° ext moy','T° intérieur','Puissance'];
    //$chart_last24_chan = 'c23,c21,c3,c6,c7,c138,c134';
    // => remplacé par conf/settings.inc.php
?>



<script type="text/javascript">
//********* déclaration des cookies pour stockage visibilité des courbes****************************
//*** creation cookie******
function setCookie(sName, sValue) {
	var today = new Date(), expires = new Date();
	expires.setTime(today.getTime() + (365*24*60*60*1000));
	document.cookie = sName + "=" + encodeURIComponent(sValue) + ";expires=" + expires.toGMTString();
}
//*** lecture cookie******
function getCookie(sName) {
	var cookContent = document.cookie, cookEnd, i, j;
	var sName = sName + "=";
	for(var i=0,c=cookContent.length;i<c;i++) {
	j = i + sName.length;
		if(cookContent.substring(i, j) == sName) {
			cookEnd = cookContent.indexOf(";", j);
			if(cookEnd == -1) {
				cookEnd = cookContent.length;
			}
			return decodeURIComponent(cookContent.substring(j, cookEnd));
		}
	}
	return true;
}
//*** lecture des cookies pour chaque serie et affectation dans une variable*******
var etat = [];
for (var k=0;k<7;k++) {	
	etat[k] = Boolean(getCookie('hargassner-p1c1-serie'+k)); // transforme la string des cookies en booleen , pour chaque serie
}	

$(document).ready(function(){
//*** definition du graphe ******************************
    Highcharts.setOptions({
		lang: {
			months: <?php echo $months; ?>,
			weekdays: <?php echo $weekdays; ?>,
			shortMonths: <?php echo $shortMonths; ?>,
			thousandsSep: <?php echo $thousandsSep; ?>,
		},
		global: {
			useUTC: false
		}
    });

	chart_last24 = new Highcharts.Chart({
		chart: {
            renderTo: 'chart_last24',
			type: 'line',
			zoomType: 'x',
			backgroundColor: null,
			events: {
				load: requestData('call_ajax_regul') // in header.php
			},
		},
	    credits: {
			enabled: false,
		},
		title: {
			text: '',
			style:{
				color: '#4572A7',
			},
		},
		subtitle: {
			text: ''
		},
		legend: {
			enabled: true,
			backgroundColor: '<?php echo $color_legend; ?>',
			borderRadius: 14,
		},
		xAxis: {
			type: 'datetime',
			dateTimeLabelFormats: { 
                day: '%e %B',
			}
		 },
		yAxis: { //axe 0
			gridLineColor: '#CACACA', 
			labels: {
				format: '{value}',
				style: {
					color: '#4572A7',
				}
			},
		   title: {
				text: '',
			},
            plotBands: [{
                color: '#E7FFFF',
                from: 0,
                to: -30,
            }],
            height: 450,
            // top: 160,
		},
		tooltip: {
	        shared: true,
			
			crosshairs: true,
			borderRadius: 6,
			borderWidth: 1,
			// valueSuffix: ' °C',
			xDateFormat: '%e %B %H:%M:%S',
		 },
		plotOptions: {
			series: {
                lineWidth: 1.5,
				marker: {
					enabled: false,
				},
                states: {
                    hover: {
                        enabled: false,
                    }
                },
                events: { //memorisation de l'etat visible des courbes
                    legendItemClick: function(event) {
                        var visibility = this.visible ? '' : true; // for boolean => true=true and ''=false
						setCookie('hargassner-p1c1-serie' + this.index, visibility);
                    }
                }
			},
		},

		// series: [{
			// name: '<?php echo $chart_last24_name[0]; ?>',
			// color: '<?php echo $color_TdepD; ?>',
            // visible: etat[0],
			// zIndex: 5,
			// data: []
		// }, {
			// name: '<?php echo $chart_last24_name[1]; ?>',
			// color: '<?php echo $color_TdepE; ?>',
            // visible: etat[1],
			// zIndex: 3,
			// data: []
		// }, {
			// name: '<?php echo $chart_last24_name[2]; ?>',
			// color: '<?php echo $color_Tchaud; ?>',
            // visible: etat[2],
			// zIndex: 2,
			// data: []
		// }, {
			// name: '<?php echo $chart_last24_name[3]; ?>',
			// color: '<?php echo $color_Text; ?>',
            // visible: etat[3],
			// zIndex: 4,
			// data: []
		// }, {
			// name: '<?php echo $chart_last24_name[4]; ?>',
			// color: '<?php echo $color_TextM; ?>',
            // visible: etat[4],
			// zIndex: 4,
			// data: []
		// }, {
			// name: '<?php echo $chart_last24_name[5]; ?>',
			// color: '<?php echo $color_Tint; ?>',
            // visible: etat[5],
			// zIndex: 4,
			// data: []
		// }, {
			// name: '<?php echo $chart_last24_name[6]; ?>',
			// color: '<?php echo $color_puiss; ?>',
            // visible: etat[6],
			// zIndex: 4,
            // yAxis: 1,
			// data: []
		// }] 
	});
//****************************************************************************************************
//*** chargement des données en asynchrone *****************************
	var msg = '\
		Le tableau représente le contenu des données provenant de la chaudière par telnet.\
		En cliquant par exemple sur la première case , cela affiche la courbe correspondant au parametre 0 du telnet (T0) et , normalement, a la colonne 0 de la BDD (c0).\
		Cependant au fil des firmwares , Hargassner a modifier l\'ordre des parametres\
		et la colonne réelle de la BDD ne correspond plus au parametre, donc le nom de la courbe indique le numero du paramètre Telnet et la colonne correspondante en BDD\
		';
    chart_last24.showLoading(msg);

    // $.ajax({
        // dataType: "json",
        // url: 'json_chan-period.php',
        // data: 'channel=<?php echo $chart_last24_chan; ?>' + '&periode=1440',
        // cache: false,
        // success: function(data) {
            // chart_last24.series[0].setData(data[0],false);
            // chart_last24.series[1].setData(data[1],false);
            // chart_last24.series[2].setData(data[2],false);
            // chart_last24.series[3].setData(data[3],false);
            // chart_last24.series[4].setData(data[4],false);
            // chart_last24.series[5].setData(data[5],false);
            // chart_last24.series[6].setData(data[6],false);
            // chart_last24.redraw();
            // chart_last24.hideLoading();
        // }
    // });


//****************************************************************************************************
//*** clic sur tableau *****************************
    $(".telnetTable").on('click','tbody.id>tr>td',function(){
		if (document.getElementById(this.id).className == 'select'){
			document.getElementById(this.id).className = '';
			chart_last24.get('t'+this.id).remove();
			if (chart_last24.series.length == 0){
				chart_last24.showLoading(msg);
			};
		} else {
            chart_last24.hideLoading();
			document.getElementById(this.id).className = 'select';
			console.log(this.id);
			$.ajax({
				dataType: "json",
				url: 'json_chan-period-1.php',
				data: 'id=' + this.id + '&periode=1440',
				cache: false,
				success: function(object) {
					// chart_last24.addSeries({
						// data: data[0],
					// });
					chart_last24.addSeries(object);
				}
			});
		} 
    });



});
</script>


<table class="telnetTable">
<tbody class="id">
<tr>
<td id="0" >&nbsp;</td><td id="1" >&nbsp;</td><td id="2" >&nbsp;</td><td id="3" >&nbsp;</td><td id="4" >&nbsp;</td><td id="5" >&nbsp;</td><td id="6" >&nbsp;</td><td id="7" >&nbsp;</td><td id="8" >&nbsp;</td><td id="9" >&nbsp;</td></tr>
<tr>
<td id="10">&nbsp;</td><td id="11">&nbsp;</td><td id="12">&nbsp;</td><td id="13">&nbsp;</td><td id="14">&nbsp;</td><td id="15">&nbsp;</td><td id="16">&nbsp;</td><td id="17">&nbsp;</td><td id="18">&nbsp;</td><td id="19">&nbsp;</td></tr>
<tr>
<td id="20">&nbsp;</td><td id="21">&nbsp;</td><td id="22">&nbsp;</td><td id="23">&nbsp;</td><td id="24">&nbsp;</td><td id="25">&nbsp;</td><td id="26">&nbsp;</td><td id="27">&nbsp;</td><td id="28">&nbsp;</td><td id="29">&nbsp;</td></tr>
<tr>
<td id="30">&nbsp;</td><td id="31">&nbsp;</td><td id="32">&nbsp;</td><td id="33">&nbsp;</td><td id="34">&nbsp;</td><td id="35">&nbsp;</td><td id="36">&nbsp;</td><td id="37">&nbsp;</td><td id="38">&nbsp;</td><td id="39">&nbsp;</td></tr>
<tr>
<td id="40">&nbsp;</td><td id="41">&nbsp;</td><td id="42">&nbsp;</td><td id="43">&nbsp;</td><td id="44">&nbsp;</td><td id="45">&nbsp;</td><td id="46">&nbsp;</td><td id="47">&nbsp;</td><td id="48">&nbsp;</td><td id="49">&nbsp;</td></tr>
<tr>
<td id="50">&nbsp;</td><td id="51">&nbsp;</td><td id="52">&nbsp;</td><td id="53">&nbsp;</td><td id="54">&nbsp;</td><td id="55">&nbsp;</td><td id="56">&nbsp;</td><td id="57">&nbsp;</td><td id="58">&nbsp;</td><td id="59">&nbsp;</td></tr>
<tr>
<td id="60">&nbsp;</td><td id="61">&nbsp;</td><td id="62">&nbsp;</td><td id="63">&nbsp;</td><td id="64">&nbsp;</td><td id="65">&nbsp;</td><td id="66">&nbsp;</td><td id="67">&nbsp;</td><td id="68">&nbsp;</td><td id="69">&nbsp;</td></tr>
<tr>
<td id="70">&nbsp;</td><td id="71">&nbsp;</td><td id="72">&nbsp;</td><td id="73">&nbsp;</td><td id="74">&nbsp;</td><td id="75">&nbsp;</td><td id="76">&nbsp;</td><td id="77">&nbsp;</td><td id="78">&nbsp;</td><td id="79">&nbsp;</td></tr>
<tr>
<td id="80">&nbsp;</td><td id="81">&nbsp;</td><td id="82">&nbsp;</td><td id="83">&nbsp;</td><td id="84">&nbsp;</td><td id="85">&nbsp;</td><td id="86">&nbsp;</td><td id="87">&nbsp;</td><td id="88">&nbsp;</td><td id="89">&nbsp;</td></tr>
<tr>
<td id="90">&nbsp;</td><td id="91">&nbsp;</td><td id="92">&nbsp;</td><td id="93">&nbsp;</td><td id="94">&nbsp;</td><td id="95">&nbsp;</td><td id="96">&nbsp;</td><td id="97">&nbsp;</td><td id="98">&nbsp;</td><td id="99">&nbsp;</td></tr>
</tbody>
</tr>
</table>
<table class="telnetTable">
<tbody class="id">
<tr>
<td id="100">&nbsp;</td><td id="101">&nbsp;</td><td id="102">&nbsp;</td><td id="103">&nbsp;</td><td id="104">&nbsp;</td><td id="105">&nbsp;</td><td id="106">&nbsp;</td><td id="107">&nbsp;</td><td id="108">&nbsp;</td><td id="109">&nbsp;</td></tr>
<tr>
<td id="110">&nbsp;</td><td id="111">&nbsp;</td><td id="112">&nbsp;</td><td id="113">&nbsp;</td><td id="114">&nbsp;</td><td id="115">&nbsp;</td><td id="116">&nbsp;</td><td id="117">&nbsp;</td><td id="118">&nbsp;</td><td id="119">&nbsp;</td></tr>
<tr>
<td id="120">&nbsp;</td><td id="121">&nbsp;</td><td id="122">&nbsp;</td><td id="123">&nbsp;</td><td id="124">&nbsp;</td><td id="125">&nbsp;</td><td id="126">&nbsp;</td><td id="127">&nbsp;</td><td id="128">&nbsp;</td><td id="129">&nbsp;</td></tr>
<tr>
<td id="130">&nbsp;</td><td id="131">&nbsp;</td><td id="132">&nbsp;</td><td id="133">&nbsp;</td><td id="134">&nbsp;</td><td id="135">&nbsp;</td><td id="136">&nbsp;</td><td id="137">&nbsp;</td><td id="138">&nbsp;</td><td id="139">&nbsp;</td></tr>
<tr>
<td id="140">&nbsp;</td><td id="141">&nbsp;</td><td id="142">&nbsp;</td><td id="143">&nbsp;</td><td id="144">&nbsp;</td><td id="145">&nbsp;</td><td id="146">&nbsp;</td><td id="147">&nbsp;</td><td id="148">&nbsp;</td><td id="149">&nbsp;</td></tr>
<tr>
<td id="150">&nbsp;</td><td id="151">&nbsp;</td><td id="152">&nbsp;</td><td id="153">&nbsp;</td><td id="154">&nbsp;</td><td id="155">&nbsp;</td><td id="156">&nbsp;</td><td id="157">&nbsp;</td><td id="158">&nbsp;</td><td id="159">&nbsp;</td></tr>
<tr>
<td id="160">&nbsp;</td><td id="161">&nbsp;</td><td id="162">&nbsp;</td><td id="163">&nbsp;</td><td id="164">&nbsp;</td><td id="165">&nbsp;</td><td id="166">&nbsp;</td><td id="167">&nbsp;</td><td id="168">&nbsp;</td><td id="169">&nbsp;</td></tr>
<tr>
<td id="170">&nbsp;</td><td id="171">&nbsp;</td><td id="172">&nbsp;</td><td id="173">&nbsp;</td><td id="174">&nbsp;</td><td id="175">&nbsp;</td><td id="176">&nbsp;</td><td id="177">&nbsp;</td><td id="178">&nbsp;</td><td id="179">&nbsp;</td></tr>
<tr>
<td id="180">&nbsp;</td><td id="181">&nbsp;</td><td id="182">&nbsp;</td><td id="183">&nbsp;</td><td id="184">&nbsp;</td><td id="185">&nbsp;</td><td id="186">&nbsp;</td><td id="187">&nbsp;</td><td id="188">&nbsp;</td><td id="189">&nbsp;</td></tr>
<tr>
<td id="190">&nbsp;</td><td id="191">&nbsp;</td><td id="192">&nbsp;</td><td id="193">&nbsp;</td><td id="194">&nbsp;</td><td id="195">&nbsp;</td><td id="196">&nbsp;</td><td id="197">&nbsp;</td><td id="198">&nbsp;</td><td id="199">&nbsp;</td></tr>
</tbody>
</tr>
</table>

<?php require("footer.php");?>
