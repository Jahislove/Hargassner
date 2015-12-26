
<?php
require("header.php");

    $liste1 = "";
    $liste2 = "";
    $liste3 = "";
    $liste4 = "";

    $query = "SELECT dateB,chan0,c3,c53,m56,m134,c12,c13,c15,c18,c33,c34 FROM nanoPK
                WHERE id > 58000 and id < 71500
              ORDER by id DESC ";
    // $query = "SELECT dateB,chan0,c3,c53,m56,m134,c12,c13,c15,c18,c33,c34 FROM nanoPK
                
              // ORDER by id DESC LIMIT 8000";

	connectMaBase($hostname, $database, $username, $password);
    $req = mysql_query($query) ;
	mysql_close();
	
    while($data = mysql_fetch_assoc($req))
    {
    $dateD = strtotime($data['dateB']) * 1000;
    $liste0 = "[" . $dateD . "," . $data['chan0'] ."]," . $liste0;
    $liste1 = "[" . $dateD . "," . $data['c3'] ."]," . $liste1;
    $liste2 = "[" . $dateD . "," . $data['c53'] ."]," . $liste2;
    $liste3 = "[" . $dateD . "," . $data['m56'] ."]," . $liste3;
    $liste4 = "[" . $dateD . "," . $data['m134'] ."]," . $liste4;
    $liste5 = "[" . $dateD . "," . $data['c12'] ."]," . $liste5;
    $liste6 = "[" . $dateD . "," . $data['c13'] ."]," . $liste6;
    $liste7 = "[" . $dateD . "," . $data['c15'] ."]," . $liste7;
    $liste8 = "[" . $dateD . "," . $data['c18'] ."]," . $liste8;
    $liste9 = "[" . $dateD . "," . $data['c33'] ."]," . $liste9;
    $liste10 = "[" . $dateD . "," . $data['c34'] ."]," . $liste10;


    }
?>

<div id="phases2"></div>
<?php include("schema.inc.php");?>

<?php require("footer.php");?>

<script type="text/javascript">
$(function() {
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

	$('#phases2').highcharts({
		chart: {
			type: 'line',
			zoomType: 'x',
			backgroundColor: null,
		},
		title: {
			text: '<?php echo $conso; ?>',
			style:{
				color: '#4572A7',
			},
		},
		subtitle: {
			text: '<?php echo $duree; ?>'
		},
		legend: {
			enabled: true,
			backgroundColor: 'white',
			borderRadius: 14,
		},
		xAxis: {
			type: 'datetime',
			dateTimeLabelFormats: { // don't display the dummy year
				month: '%e. %b',
				year: '%b'
			}
		 },
		yAxis: {
			gridLineColor: null, 
			labels: {
				format: '{value}',
				style: {
					color: '#4572A7',
				}
			},
		   title: {
				text: 'Consommation',
			},
			//min: -20
		},
		tooltip: {
            shadow: false,
	        shared: true,
			crosshairs: true,
			borderRadius: 1,
			borderWidth: 1,
			valueSuffix: '',
			xDateFormat: '%A %e %b  %H:%M:%S',
		 },
		plotOptions: {
            series: {
                enableMouseTracking: true,
                animation: false,
				marker: {
					enabled: false
				},
            },
		},

		series: [{
			name: 'etat',
			color: '<?php echo $ph1_Main_Color; ?>',
			zIndex: 1,
			data: [<?php echo $liste0; ?>]
		}, {
			name: 'T chaud',
			color: '<?php echo $ph3_Main_Color; ?>',
			zIndex: 2,
			data: [<?php echo $liste1; ?>]
		}, {
			name: 'SZ',
			color: 'yellow',
			zIndex: 3,
			data: [<?php echo $liste2; ?>]
		}, {
			name: 'bois',
			zIndex: 4,
			color: 'grey',
			data: [<?php echo $liste3; ?>]
		}, {
			name: 'puiss',
			zIndex: 0,
			color: 'red',
			data: [<?php echo $liste4; ?>]
		}, {
			name: '12',
			zIndex: 0,
			color: 'lightblue',
			data: [<?php echo $liste5; ?>]
		}, {
			name: '13',
			zIndex: 0,
			color: 'blue',
			data: [<?php echo $liste6; ?>]
		}, {
			name: '15',
			zIndex: 0,
			color: 'grey',
			data: [<?php echo $liste7; ?>]
		}, {
			name: '18',
			zIndex: 0,
			color: 'maroon',
			data: [<?php echo $liste8; ?>]
		}, {
			name: '33',
			zIndex: 0,
			color: 'lightblue',
			data: [<?php echo $liste9; ?>]
		}, {
			name: '34',
			zIndex: 0,
			color: 'white',
			data: [<?php echo $liste10; ?>]
		}]
	});
//****************************************************************************************************
});
</script>



