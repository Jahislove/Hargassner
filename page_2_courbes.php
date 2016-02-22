<?php require("header_debut.php"); ?>
<script type="text/javascript" src="js/call_ajax_light.js">	</script>
<?php require("header_fin.php"); ?>
    
<?php
    $chart1_name = ['T° ext','Puissance','T° chaudiere','T° fumée','O² lambda'];
    $chart1_chan = "c6,c134,c3,c5,c1";
    $chart2_name = ['Vitesse Extracteur','Variable F','% bois','Variable K','Regulateur bois'];
    $chart2_chan = "c53,c54,c56,c160,c55";
    $chart3_name = ['Aspiration RAPS'];
    $chart3_chan = "c169";
    $chart5_name = ['T° ext','T° ext moy','T° int','T° depart est','T° depart doit'];
    $chart5_chan = "c6,c7,c138,c21,c23";
    
?>

<div class="rel">
    <div id="graphe1" class="graphe_size"></div>
    <div id="graphe2" class="graphe_size"></div>
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
            tickInterval: 3600*1000,
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
			valueSuffix: '',
			xDateFormat: '%H:%M:%S',
		 },
		plotOptions: {
			series: {
                lineWidth: 1.5,
				marker: {
					enabled: false
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
		xAxis: {
            tickInterval: 15*60*1000,
		 },
		series: [{
			name: '<?php echo $chart1_name[0]; ?>',
			color: '<?php echo $color_Text; ?>',
			data: []
		}, {
			name: '<?php echo $chart1_name[1]; ?>',
			color: '<?php echo $color_puiss; ?>',
			data: []
		}, {
			name: '<?php echo $chart1_name[2]; ?>',
			color: '<?php echo $color_Tchaud; ?>',
			data: []
		}, {
			name: '<?php echo $chart1_name[3]; ?>',
			color: '<?php echo $color_fum; ?>',
			data: []
		}, {
			name: '<?php echo $chart1_name[4]; ?>',
			color: '<?php echo $color_O2; ?>',
			data: []
		}] 
	});
    // *************chart 2 ********************************************
	$('#graphe2').highcharts({
		title: {
			text: 'Variables',
		},
		xAxis: {
            tickInterval: 15*60*1000,
		 },
		series: [{
			name: '<?php echo $chart2_name[0]; ?>',
			color: '<?php echo $color_extrac; ?>',
			data: []
		}, {
			name: '<?php echo $chart2_name[1]; ?>',
			color: '<?php echo $color_varF; ?>',
			data: []
		}, {
			name: '<?php echo $chart2_name[2]; ?>',
			color: '<?php echo $color_bois; ?>',
			data: []
		}, {
			name: '<?php echo $chart2_name[3]; ?>',
			color: '<?php echo $color_varK; ?>',
			data: []
		}, {
			name: '<?php echo $chart2_name[4]; ?>',
			color: '<?php echo $color_regul; ?>',
			data: [],
            tooltip: {
                valueSuffix: ' °C',
             },
		}] 
	});
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
//****************************************************************************************************
// ************* chargement asynchrone des graphes****************************************************
    var chart1 = $('#graphe1').highcharts();
    var chart2 = $('#graphe2').highcharts();
    var chart3 = $('#graphe3').highcharts();
    chart1.showLoading('loading');
    chart2.showLoading('loading');
    chart3.showLoading('loading');

    $.ajax({
        dataType: "json",
        url: 'json_chan-period.php',
        data: 'channel=<?php echo $chart1_chan; ?>' + '&periode=720',
        cache: false,
        success: function(data) {
            chart1.series[0].setData(data[0],false);
            chart1.series[1].setData(data[1],false);
            chart1.series[2].setData(data[2],false);
            chart1.series[3].setData(data[3],false);
            chart1.series[4].setData(data[4],false);
            chart1.redraw();
            chart1.hideLoading();
        }
    });
    $.ajax({
        dataType: "json",
        url: 'json_chan-period.php',
        data: 'channel=<?php echo $chart2_chan; ?>' + '&periode=720',
        cache: false,
        success: function(data) {
            chart2.series[0].setData(data[0],false);
            chart2.series[1].setData(data[1],false);
            chart2.series[2].setData(data[2],false);
            chart2.series[3].setData(data[3],false);
            chart2.series[4].setData(data[4],false);
            chart2.redraw();
            chart2.hideLoading();
        }
    });
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
});
</script>



