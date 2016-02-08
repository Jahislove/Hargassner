<?php require("header_debut.php"); ?>
<script type="text/javascript" src="js/call_ajax_light.js">	</script>
<?php require("header_fin.php"); ?>
    
<?php
    $chart1_name = ['T° ext','T° ext moy','T° int','T° depart est','T° depart doit'];
    $chart1_chan = "c6,c7,c138,c21,c23";
    $chart2_name = ['Etat','Puissance','T° chaudiere','T° fumée','O² lambda'];
    $chart2_chan = "c0,c134,c3,c5,c1";
    $chart3_name = ['Vitesse Extracteur','Variable F','% bois','Variable K','Regulateur bois'];
    $chart3_chan = "c53,c54,c56,c160,c55";
    $chart4_name = ['Aspiration RAPS'];
    $chart4_chan = "c169";
    
    $query1 = "SELECT dateB,$chart1_chan FROM nanoPK
              ORDER by dateB DESC LIMIT 1440";
    $query2 = "SELECT dateB,$chart2_chan FROM nanoPK
              ORDER by dateB DESC LIMIT 120";
    $query3 = "SELECT dateB,$chart3_chan FROM nanoPK
              ORDER by dateB DESC LIMIT 120";

	connectMaBase($hostname, $database, $username, $password);
    $req1 = mysql_query($query1) ;
    $req2 = mysql_query($query2) ;
    $req3 = mysql_query($query3) ;
	mysql_close();
	
    while($data = mysql_fetch_row($req1)){
        $dateD = strtotime($data[0]) * 1000;
        $chart1_data1[] = "[$dateD, $data[1]]";
        $chart1_data2[] = "[$dateD, $data[2]]";
        $chart1_data3[] = "[$dateD, $data[3]]";
        $chart1_data4[] = "[$dateD, $data[4]]";
        $chart1_data5[] = "[$dateD, $data[5]]";
    }
    while($data = mysql_fetch_row($req2)){
        $dateD = strtotime($data[0]) * 1000;
        $chart2_data1[] = "[$dateD, $data[1]]";
        $chart2_data2[] = "[$dateD, $data[2]]";
        $chart2_data3[] = "[$dateD, $data[3]]";
        $chart2_data4[] = "[$dateD, $data[4]]";
        $chart2_data5[] = "[$dateD, $data[5]]";
    }
    while($data = mysql_fetch_row($req3)){
        $dateD = strtotime($data[0]) * 1000;
        $chart3_data1[] = "[$dateD, $data[1]]";
        $chart3_data2[] = "[$dateD, $data[2]]";
        $chart3_data3[] = "[$dateD, $data[3]]";
        $chart3_data4[] = "[$dateD, $data[4]]";
        $chart3_data5[] = "[$dateD, $data[5]]";
    }

    $chart1_data1 = join(',', array_reverse($chart1_data1));
    $chart1_data2 = join(',', array_reverse($chart1_data2));
    $chart1_data3 = join(',', array_reverse($chart1_data3));
    $chart1_data4 = join(',', array_reverse($chart1_data4));
    $chart1_data5 = join(',', array_reverse($chart1_data5));

    $chart2_data1 = join(',', array_reverse($chart2_data1));
    $chart2_data2 = join(',', array_reverse($chart2_data2));
    $chart2_data3 = join(',', array_reverse($chart2_data3));
    $chart2_data4 = join(',', array_reverse($chart2_data4));
    $chart2_data5 = join(',', array_reverse($chart2_data5));

    $chart3_data1 = join(',', array_reverse($chart3_data1));
    $chart3_data2 = join(',', array_reverse($chart3_data2));
    $chart3_data3 = join(',', array_reverse($chart3_data3));
    $chart3_data4 = join(',', array_reverse($chart3_data4));
    $chart3_data5 = join(',', array_reverse($chart3_data5));

?>

<div class="rel">
    <div id="graphe1" class="page2_quad"></div>
    <div id="graphe2" class="page2_quad"></div>
    <div id="graphe4" class="page2_quad"></div>
    <div id="graphe3" class="page2_quad"></div>
</div>

<div class="clear"></div>

<?php require("footer.php");?>

<script type="text/javascript">
$(document).ready(function(){
//$(function() {
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
			backgroundColor: '#FBF8EF',
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
			}
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
			//min: -20
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
				marker: {
					enabled: false
				},
			}
		},
    });

    // *************chart 1 ********************************************
	$('#graphe1').highcharts({
		chart: {
			events: {
				//load: requestData // in header_debut.php
			}
        },
		title: {
			text: 'Températures',
		},
		series: [{
			name: '<?php echo $chart1_name[0]; ?>',
			color: '<?php echo $color_Text; ?>',
			data: [<?php echo $chart1_data1; ?>]
		}, {
			name: '<?php echo $chart1_name[1]; ?>',
			color: '<?php echo $color_TextM; ?>',
			data: [<?php echo $chart1_data2; ?>]
		}, {
			name: '<?php echo $chart1_name[2]; ?>',
			color: '<?php echo $color_Tint; ?>',
			data: [<?php echo $chart1_data3; ?>]
		}, {
			name: '<?php echo $chart1_name[3]; ?>',
			color: '<?php echo $color_TdepE; ?>',
			data: [<?php echo $chart1_data4; ?>]
		}, {
			name: '<?php echo $chart1_name[4]; ?>',
			color: '<?php echo $color_TdepD; ?>',
			data: [<?php echo $chart1_data5; ?>]
		}] 
	});
    // *************chart 2 ********************************************
	$('#graphe2').highcharts({
		title: {
			text: 'Fonctionnement',
		},
		xAxis: {
            tickInterval: 15*60*1000,
		 },
		series: [{
			name: '<?php echo $chart2_name[0]; ?>',
			color: '<?php echo $color_etat; ?>',
			data: [<?php echo $chart2_data1; ?>]
		}, {
			name: '<?php echo $chart2_name[1]; ?>',
			color: '<?php echo $color_puiss; ?>',
			data: [<?php echo $chart2_data2; ?>]
		}, {
			name: '<?php echo $chart2_name[2]; ?>',
			color: '<?php echo $color_Tchaud; ?>',
			data: [<?php echo $chart2_data3; ?>]
		}, {
			name: '<?php echo $chart2_name[3]; ?>',
			color: '<?php echo $color_fum; ?>',
			data: [<?php echo $chart2_data4; ?>]
		}, {
			name: '<?php echo $chart2_name[4]; ?>',
			color: '<?php echo $color_O2; ?>',
			data: [<?php echo $chart2_data5; ?>]
		}] 
	});
    // *************chart 3 ********************************************
	chart3 = new Highcharts.Chart({
		chart: {
			renderTo: 'graphe3',
        },
		title: {
			text: 'Variables',
		},
		xAxis: {
            tickInterval: 15*60*1000,
		 },
		series: [{
			name: '<?php echo $chart3_name[0]; ?>',
			color: '<?php echo $color_etat; ?>',
			data: [<?php echo $chart3_data1; ?>]
		}, {
			name: '<?php echo $chart3_name[1]; ?>',
			color: '<?php echo $color_puiss; ?>',
			data: [<?php echo $chart3_data2; ?>]
		}, {
			name: '<?php echo $chart3_name[2]; ?>',
			color: '<?php echo $color_Tchaud; ?>',
			data: [<?php echo $chart3_data3; ?>]
		}, {
			name: '<?php echo $chart3_name[3]; ?>',
			color: '<?php echo $color_fum; ?>',
			data: [<?php echo $chart3_data4; ?>]
		}, {
			name: '<?php echo $chart3_name[4]; ?>',
			color: '<?php echo $color_O2; ?>',
			data: [<?php echo $chart3_data5; ?>],
            tooltip: {
                valueSuffix: ' °C',
             },
		}] 
	});
    // *************chart 4 ********************************************
	chart4 = new Highcharts.Chart({
		chart: {
			renderTo: 'graphe4',
        },
		title: {
			text: 'Aspiration',
		},
		xAxis: {
            tickInterval: 3*3600*1000,
		 },
		series: [{
			name: '<?php echo $chart4_name[0]; ?>',
			color: '<?php echo $color_aspi; ?>',
			data: []
		}] 
	});
//****************************************************************************************************
// ************* chargement asynchrone des graphes****************************************************
//    chart3.showLoading('loading');
    chart4.showLoading('loading');

    // $.ajax({
        // dataType: "json",
        // url: 'json_conso.php',
        // cache: false,
        // success: function(data) {
            // chart3.series[0].setData(data[0],false);
            // chart3.series[1].setData(data[1],false);
            // chart3.redraw();
            // chart3.hideLoading();
        // }
    // });

    $.ajax({
        dataType: "json",
        url: 'json_solo.php',
        data: 'channel=<?php echo $chart4_chan; ?>',
        cache: false,
        success: function(data) {
            chart4.series[0].setData(data,false);
            chart4.redraw();
            chart4.hideLoading();
        }
    });
});
</script>



