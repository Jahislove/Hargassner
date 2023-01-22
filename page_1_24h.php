<?php require("header.php"); ?>

<div id="chart_last24"></div>

<?php
	require_once("conf/settings.inc.php");
    $chart_last24_name = ['T° depart consigne','T° depart','T° chaudière','T° extérieur','T° ext moy','T° intérieur','Puissance'];
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
			type: 'spline',
			zoomType: 'x',
			backgroundColor: null,
			events: {
				load: requestData('call_ajax_light') // in header.php
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
		yAxis: [{ //axe 0
			gridLineColor: '#CACACA', 
			labels: {
				format: '{value} °C',
				style: {
					color: '#4572A7',
				}
			},
		   title: {
				text: 'Températures',
			},
            plotBands: [{
                color: '#E7FFFF',
                from: 0,
                to: -30,
            }],
            height: 450,
            top: 160,
		},{ //axe 1
			gridLineColor: '#CACACA', 
			labels: {
				format: '{value} %',
                x: 55,
				style: {
					color: 'red',
				},
			},
		   title: {
				text: 'Puissance',
				style: {
					color: 'red',
				},
			},
            top: 10,
            height: 100,
            max: 100,
        }],
		tooltip: {
	        shared: true,
			crosshairs: true,
			borderRadius: 6,
			borderWidth: 1,
			valueSuffix: ' °C',
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

		series: [{
			name: '<?php echo $chart_last24_name[0]; ?>',
			color: '<?php echo $color_TdepD; ?>',
            visible: etat[0],
			zIndex: 5,
			data: []
		}, {
			name: '<?php echo $chart_last24_name[1]; ?>',
			color: '<?php echo $color_TdepE; ?>',
            visible: etat[1],
			zIndex: 3,
			data: []
		}, {
			name: '<?php echo $chart_last24_name[2]; ?>',
			color: '<?php echo $color_Tchaud; ?>',
            visible: etat[2],
			zIndex: 2,
			data: []
		}, {
			name: '<?php echo $chart_last24_name[3]; ?>',
			color: '<?php echo $color_Text; ?>',
            visible: etat[3],
			zIndex: 4,
			data: []
		}, {
			name: '<?php echo $chart_last24_name[4]; ?>',
			color: '<?php echo $color_TextM; ?>',
            visible: etat[4],
			zIndex: 4,
			data: []
		}, {
			name: '<?php echo $chart_last24_name[5]; ?>',
			color: '<?php echo $color_Tint; ?>',
            visible: etat[5],
			zIndex: 4,
			data: []
		}, {
			name: '<?php echo $chart_last24_name[6]; ?>',
			color: '<?php echo $color_puiss; ?>',
            visible: etat[6],
			zIndex: 4,
            yAxis: 1,
			data: []
		}] 
	});
//****************************************************************************************************
//*** chargement des données en asynchrone *****************************
    chart_last24.showLoading('loading');

    $.ajax({
        dataType: "json",
        url: 'json_chan-period.php',
        data: 'channel=<?php echo $chart_last24_chan; ?>' + '&periode=1440',
        cache: false,
        success: function(data) {
            chart_last24.series[0].setData(data[0],false);
            chart_last24.series[1].setData(data[1],false);
            chart_last24.series[2].setData(data[2],false);
            chart_last24.series[3].setData(data[3],false);
            chart_last24.series[4].setData(data[4],false);
            chart_last24.series[5].setData(data[5],false);
            chart_last24.series[6].setData(data[6],false);
            chart_last24.redraw();
            chart_last24.hideLoading();
            //requestData();
        }
    });

});
</script>


<table class="telnetTable">
<tbody>
<tr>
<td id="cell_0_0">&nbsp;</td><td id="cell_1_0">&nbsp;</td><td id="cell_2_0">&nbsp;</td><td id="cell_3_0">&nbsp;</td><td id="cell_4_0">&nbsp;</td><td id="cell_5_0">&nbsp;</td><td id="cell_6_0">&nbsp;</td><td id="cell_7_0">&nbsp;</td><td id="cell_8_0">&nbsp;</td><td id="cell_9_0">&nbsp;</td></tr>
<tr>
<td id="cell_0_1">&nbsp;</td><td id="cell_1_1">&nbsp;</td><td id="cell_2_1">&nbsp;</td><td id="cell_3_1">&nbsp;</td><td id="cell_4_1">&nbsp;</td><td id="cell_5_1">&nbsp;</td><td id="cell_6_1">&nbsp;</td><td id="cell_7_1">&nbsp;</td><td id="cell_8_1">&nbsp;</td><td id="cell_9_1">&nbsp;</td></tr>
<tr>
<td id="cell_0_2">&nbsp;</td><td id="cell_1_2">&nbsp;</td><td id="cell_2_2">&nbsp;</td><td id="cell_3_2">&nbsp;</td><td id="cell_4_2">&nbsp;</td><td id="cell_5_2">&nbsp;</td><td id="cell_6_2">&nbsp;</td><td id="cell_7_2">&nbsp;</td><td id="cell_8_2">&nbsp;</td><td id="cell_9_2">&nbsp;</td><</tr>
<tr>
<td id="cell_0_3">&nbsp;</td><td id="cell_1_3">&nbsp;</td><td id="cell_2_3">&nbsp;</td><td id="cell_3_3">&nbsp;</td><td id="cell_4_3">&nbsp;</td><td id="cell_5_3">&nbsp;</td><td id="cell_6_3">&nbsp;</td><td id="cell_7_3">&nbsp;</td><td id="cell_8_3">&nbsp;</td><td id="cell_9_3">&nbsp;</td></tr>
<tr>
<td id="cell_0_4">&nbsp;</td><td id="cell_1_4">&nbsp;</td><td id="cell_2_4">&nbsp;</td><td id="cell_3_4">&nbsp;</td><td id="cell_4_4">&nbsp;</td><td id="cell_5_4">&nbsp;</td><td id="cell_6_4">&nbsp;</td><td id="cell_7_4">&nbsp;</td><td id="cell_8_4">&nbsp;</td><td id="cell_9_4">&nbsp;</td></tr>
<tr>
<td id="cell_0_5">&nbsp;</td><td id="cell_1_5">&nbsp;</td><td id="cell_2_5">&nbsp;</td><td id="cell_3_5">&nbsp;</td><td id="cell_4_5">&nbsp;</td><td id="cell_5_5">&nbsp;</td><td id="cell_6_5">&nbsp;</td><td id="cell_7_5">&nbsp;</td><td id="cell_8_5">&nbsp;</td><td id="cell_9_5">&nbsp;</td></tr>
<tr>
<td id="cell_0_6">&nbsp;</td><td id="cell_1_6">&nbsp;</td><td id="cell_2_6">&nbsp;</td><td id="cell_3_6">&nbsp;</td><td id="cell_4_6">&nbsp;</td><td id="cell_5_6">&nbsp;</td><td id="cell_6_6">&nbsp;</td><td id="cell_7_6">&nbsp;</td><td id="cell_8_6">&nbsp;</td><td id="cell_9_6">&nbsp;</td></tr>
<tr>
<td id="cell_0_7">&nbsp;</td><td id="cell_1_7">&nbsp;</td><td id="cell_2_7">&nbsp;</td><td id="cell_3_7">&nbsp;</td><td id="cell_4_7">&nbsp;</td><td id="cell_5_7">&nbsp;</td><td id="cell_6_7">&nbsp;</td><td id="cell_7_7">&nbsp;</td><td id="cell_8_7">&nbsp;</td><td id="cell_9_7">&nbsp;</td></tr>
<tr>
<td id="cell_0_8">&nbsp;</td><td id="cell_1_8">&nbsp;</td><td id="cell_2_8">&nbsp;</td><td id="cell_3_8">&nbsp;</td><td id="cell_4_8">&nbsp;</td><td id="cell_5_8">&nbsp;</td><td id="cell_6_8">&nbsp;</td><td id="cell_7_8">&nbsp;</td><td id="cell_8_8">&nbsp;</td><td id="cell_9_8">&nbsp;</td></tr>
<tr>
<td id="cell_0_9">&nbsp;</td><td id="cell_1_9">&nbsp;</td><td id="cell_2_9">&nbsp;</td><td id="cell_3_9">&nbsp;</td><td id="cell_4_9">&nbsp;</td><td id="cell_5_9">&nbsp;</td><td id="cell_6_9">&nbsp;</td><td id="cell_7_9">&nbsp;</td><td id="cell_8_9">&nbsp;</td><td id="cell_9_9">&nbsp;</td></tr>
</tbody>
</tr>
</table>

<?php require("footer.php");?>
