﻿<?php require("header_debut.php"); ?>
<script type="text/javascript" src="js/call_ajax_light.js">	</script>
<?php require("header_fin.php"); ?>
    
<?php
    $chart1_name = ['Etat','Décendrage','Puissance','T° chaudiere est','T° chaudiere doit','T° fumée','T° exterieur','O² est','O² doit','Vitesse Extracteur','Variable F','% bois','Variable K','Regulateur bois']; // etat et decendrage obligatoire , ne pas modifier ces 2 valeurs
    $chart1_chan = "c0,c0,c134,c3,c4,c5,c6,c1,c2,c53,c54,c56,c160,c55"; // la 2 eme valeur (decendrage) est calculé d'apres c0
    //$chart2_name = ['Vitesse<br/>Extracteur','Variable F','% bois','Variable K','Regulateur<br/>bois'];
    //$chart2_chan = "c53,c54,c56,c160,c55";
    $chart3_name = ['Aspiration RAPS'];
    $chart3_chan = "c169";
    $chart4_name = ['allumage electrique','-','-','-','-'];
    $chart4_chan = "c157,c0,c53,c134,c129";
    
?>

<div class="rel">
    <div id="graphe1" class="graphe_size2"></div>
    <!--<div id="graphe2" class="graphe_size"></div>-->
    <div id="graphe4" class="graphe_size"></div>
    <div id="graphe3" class="graphe_size"></div>
</div>

<div class="clear"></div>

<?php require("footer.php");?>

<script type="text/javascript">

$(document).ready(function(){
    // ************* options communes a tous les charts ******************************
    Highcharts.setOptions({
		lang: {
			months: <?php echo $months; ?>,
			weekdays: <?php echo $weekdays; ?>,
			shortMonths: <?php echo $shortMonths; ?>,
			thousandsSep: <?php echo $thousandsSep; ?>,
		},
		global: {
			useUTC: false
		},
		chart: {
			type: 'line',
			zoomType: 'x',
			backgroundColor: null,
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
				day: '%e %b',
			},
		},
		yAxis: {
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
            plotBands: {
                color: '#E7FFFF',
                from: 0,
                to: -30,
            },
		},
		tooltip: {
	        shared: true,
			crosshairs: true,
			borderRadius: 26,
			borderWidth: 1,
            pointFormat: '<span style="color:{point.color}">\u25CF</span> {series.name}: <b>{point.y}</b><br/>',		
			xDateFormat: '%H:%M:%S',
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
			}
		},
    });

    // *************chart 1 ********************************************
	$('#graphe1').highcharts({
		title: {
			text: 'Fonctionnement',
		},
		legend: {
			enabled: true,
			backgroundColor: '<?php echo $color_legend; ?>',
			borderRadius: 14,
            itemDistance: 10,
            itemMarginBottom: 5,
            itemMarginTop: 5,
            itemWidth: 150,
            width: 1100,
		},
		xAxis: {
            tickInterval: 15*60*1000,
		 },
		series: [{
			name: '<?php echo $chart1_name[0]; ?>',
			color: '<?php echo $color_etat; ?>',
            legendIndex: 0,
            tooltip: {
                pointFormat: '<span style="color:{point.color}">\u25CF</span> {series.name}: <b>{point.valeur}</b><br/>',		
            },
			data: []
		}, {
			name: '<?php echo $chart1_name[1]; ?>',
			color: '<?php echo $color_decend; ?>',
            legendIndex: 7,
            type: 'area',
            zIndex: -1,
            // pointPadding: 0,
            // groupPadding: 0,
            // borderWidth: 0,
            tooltip: {
                pointFormat: '<span style="color:{point.color}">\u25CF</span> {series.name}: <b>{point.valeur}</b><br/>',		
            },
			data: []
		}, {
			name: '<?php echo $chart1_name[2]; ?>',
			color: '<?php echo $color_puiss; ?>',
            lineWidth: 1,
            legendIndex: 2,
            tooltip: {
                valueSuffix: ' %',
             },
			data: []
		}, {
			name: '<?php echo $chart1_name[3]; ?>',
			color: '<?php echo $color_Tchaud; ?>',
            legendIndex: 6,
            tooltip: {
                valueSuffix: ' °C',
             },
			data: []
		}, {
			name: '<?php echo $chart1_name[4]; ?>',
			color: '<?php echo $color_Tchauddoit; ?>',
            legendIndex: 13,
            tooltip: {
                valueSuffix: ' °C',
             },
			data: [],
		}, {
			name: '<?php echo $chart1_name[5]; ?>',
			color: '<?php echo $color_fum; ?>',
            legendIndex: 5,
            tooltip: {
                valueSuffix: ' °C',
             },
			data: [],
		}, {
			name: '<?php echo $chart1_name[6]; ?>',
			color: '<?php echo $color_Text; ?>',
            legendIndex: 11,
            visible: false,
			data: []
		}, {
			name: '<?php echo $chart1_name[7]; ?>',
			color: '<?php echo $color_O2; ?>',
            legendIndex: 1,
            tooltip: {
                valueSuffix: ' %',
             },
			data: []
		}, {
			name: '<?php echo $chart1_name[8]; ?>',
			color: '<?php echo $color_O2doit; ?>',
            legendIndex: 8,
            visible: false,
            tooltip: {
                valueSuffix: ' %',
             },
			data: [],
		}, {
			name: '<?php echo $chart1_name[9]; ?>',
			color: '<?php echo $color_extrac; ?>',
            legendIndex: 9,
            visible: false,
			data: []
		}, {
			name: '<?php echo $chart1_name[10]; ?>',
			color: '<?php echo $color_varF; ?>',
            legendIndex: 3,
            visible: false,
			data: []
		}, {
			name: '<?php echo $chart1_name[11]; ?>',
			color: '<?php echo $color_bois; ?>',
            legendIndex: 5,
            visible: false,
			data: []
		}, {
			name: '<?php echo $chart1_name[12]; ?>',
			color: '<?php echo $color_varK; ?>',
            legendIndex: 10,
            visible: false,
			data: []
		}, {
			name: '<?php echo $chart1_name[13]; ?>',
			color: '<?php echo $color_regul; ?>',
            legendIndex: 12,
            visible: false,
			data: [],
		}] 
	});
    // *************chart 2 ********************************************
	// $('#graphe2').highcharts({
		// title: {
			// text: 'Variables',
		// },
		// xAxis: {
            // tickInterval: 15*60*1000,
		 // },
            // tooltip: {
                // valueSuffix: ' %',
             // },
		// series: [{
			// name: '<?php echo $chart2_name[0]; ?>',
			// color: '<?php echo $color_extrac; ?>',
			// data: []
		// }, {
			// name: '<?php echo $chart2_name[1]; ?>',
			// color: '<?php echo $color_varF; ?>',
			// data: []
		// }, {
			// name: '<?php echo $chart2_name[2]; ?>',
			// color: '<?php echo $color_bois; ?>',
			// data: []
		// }, {
			// name: '<?php echo $chart2_name[3]; ?>',
			// color: '<?php echo $color_varK; ?>',
			// data: []
		// }, {
			// name: '<?php echo $chart2_name[4]; ?>',
			// color: '<?php echo $color_regul; ?>',
			// data: [],
		// }] 
	// });
    // *************chart 3 ********************************************
	$('#graphe3').highcharts({
		chart: {
			events: {
				load: requestData // in header_debut.php
			}
        },
        title: {
			text: 'Aspiration',
		},
		xAxis: {
            tickInterval: 3*3600*1000,
		 },
		series: [{
			name: '<?php echo $chart3_name[0]; ?>',
			color: '<?php echo $color_aspi; ?>',
			data: []
		}] 
	});
    // *************chart 4 ********************************************
	$('#graphe4').highcharts({
		title: {
			text: 'allumeur electrique',
		},
		xAxis: {
            tickInterval: 24*3600*1000,
		 },
		series: [{
			name: '<?php echo $chart4_name[0]; ?>',
			color: '<?php echo $color_extrac; ?>',
            type: 'column',
            tooltip: {
                shared: true,
                crosshairs: true,
                borderRadius: 26,
                borderWidth: 1,
                valueSuffix: '',
                xDateFormat: '%d %B',
            },
			data: []
		}] 
	});
//****************************************************************************************************
//****************************************************************************************************
// ************* chargement asynchrone des graphes****************************************************
    var chart1 = $('#graphe1').highcharts();
    //var chart2 = $('#graphe2').highcharts();
    var chart3 = $('#graphe3').highcharts();
    var chart4 = $('#graphe4').highcharts();
    chart1.showLoading('loading');
    //chart2.showLoading('loading');
    chart3.showLoading('loading');
    chart4.showLoading('loading');

    $.ajax({
        dataType: "json",
        url: 'json_chan-period-2.php',
        data: 'channel=<?php echo $chart1_chan; ?>' + '&periode=720',
        cache: false,
        success: function(data) {
            chart1.series[0].setData(data[0].data,false); //objet
            chart1.series[1].setData(data[1].data,false); 
            chart1.series[2].setData(data[2],false);// array
            chart1.series[3].setData(data[3],false);
            chart1.series[4].setData(data[4],false);
            chart1.series[5].setData(data[5],false);
            chart1.series[6].setData(data[6],false);
            chart1.series[7].setData(data[7],false);
            chart1.series[8].setData(data[8],false);
            chart1.series[9].setData(data[9],false);
            chart1.series[10].setData(data[10],false);
            chart1.series[11].setData(data[11],false);
            chart1.series[12].setData(data[12],false);
            chart1.series[13].setData(data[13],false);
            chart1.redraw();
            chart1.hideLoading();
        }
    });
    
/*     $.ajax({
        dataType: "json",
        url: 'json_chan-period.php',
        data: 'channel=<?php echo $chart2_chan; ?>' + '&periode=720',
        cache: false,
        success: function(data) {
            // chart1.series[0].setData(data[0],false);
            // chart1.series[1].setData(data[1],false);
            // chart1.series[2].setData(data[2],false);
            // chart1.series[3].setData(data[3],false);
            // chart1.series[4].setData(data[4],false);
            chart1.series[8].setData(data[0],false);
            chart1.series[9].setData(data[1],false);
            chart1.series[10].setData(data[2],false);
            chart1.series[11].setData(data[3],false);
            chart1.series[12].setData(data[4],false);
            chart1.redraw();
            chart1.hideLoading();
        }
    });
 */    
    $.ajax({
        dataType: "json",
        url: 'json_solo.php',
        data: 'channel=<?php echo $chart3_chan; ?>',
        cache: false,
        success: function(data) {
            chart3.series[0].setData(data,false);
            chart3.redraw();
            chart3.hideLoading();
        }
    });
    
    $.ajax({
        dataType: "json",
        url: 'json_allumeur.php',
        cache: false,
        success: function(data) {
            chart4.series[0].setData(data,false);
            chart4.redraw();
            chart4.hideLoading();
        }
    });
    
});
</script>



