
<?php
require("headertest.php");

    $liste1 = "";
    $liste2 = "";
    $liste3 = "";
    $liste4 = "";
    
    $tab0 = 'chan0';
    $nom0 = 'etat';
    $tab1 = 'c3';
    $nom1 = 'T° chaud';
    $tab2 = 'c53';
    $nom2 = 'extr';
    $tab3 = 'm56';
    $nom3 = 'bois';
    $tab4 = 'm134';
    $nom4 = 'Puissance';
    
    $tab5 = 'c21';
    $nom5 = 'T° depart';
    $tab6 = 'c6';
    $nom6 = 'T° ext';
    $tab7 = 'm112';
    $nom7 = 'temps pour aspi';
    $tab8 = 'm166';
    $nom8 = '166';
    $tab9 = 'm169';
    $nom9 = '169';
    $tab10 = 'm170';
    $nom10 = 'm170';

    // $query = "SELECT dateB,$tab0,$tab1,$tab2,$tab3,$tab4,$tab5,$tab6,$tab7,$tab8,$tab9,$tab10 FROM nanoPK
              // ORDER by id DESC LIMIT 1000";

    $query = "SELECT dateB,$tab0,$tab1,$tab2,$tab3,$tab4,$tab5,$tab6,$tab7,$tab8,$tab9,$tab10 FROM nanoPK
             WHERE dateB > '2015-12-23 13:55:00' and dateB < '2015-12-23 14:15:00'
             ";


	connectMaBase($hostname, $database, $username, $password);
    $req = mysql_query($query) ;
	mysql_close();
	
    while($data = mysql_fetch_array($req))
    {
    $dateD = strtotime($data[0]) * 1000;
    $liste0 = "[" . $dateD . "," . $data[1] ."]," . $liste0;
    $liste1 = "[" . $dateD . "," . $data[2] ."]," . $liste1;
    $liste2 = "[" . $dateD . "," . $data[3] ."]," . $liste2;
    $liste3 = "[" . $dateD . "," . $data[4] ."]," . $liste3;
    $liste4 = "[" . $dateD . "," . $data[5] ."]," . $liste4;
    $liste5 = "[" . $dateD . "," . $data[6] ."]," . $liste5; 
    $liste6 = "[" . $dateD . "," . $data[7] ."]," . $liste6;
    $liste7 = "[" . $dateD . "," . $data[8] ."]," . $liste7;
    $liste8 = "[" . $dateD . "," . $data[9] ."]," . $liste8;
    $liste9 = "[" . $dateD . "," . $data[10] ."]," . $liste9;
    $liste10 = "[" . $dateD . "," . $data[11] ."]," . $liste10;


    
    // while($data = mysql_fetch_assoc($req))
    // {
    // $dateD = strtotime($data['dateB']) * 1000;
    // $liste0 = "[" . $dateD . "," . $data['chan0'] ."]," . $liste0;
    // $liste1 = "[" . $dateD . "," . $data['c3'] ."]," . $liste1;
    // $liste2 = "[" . $dateD . "," . $data['c53'] ."]," . $liste2;
    // $liste3 = "[" . $dateD . "," . $data['m56'] ."]," . $liste3;
    // $liste4 = "[" . $dateD . "," . $data['m134'] ."]," . $liste4;
    // $liste5 = "[" . $dateD . "," . $data['c12'] ."]," . $liste5;
    // $liste6 = "[" . $dateD . "," . $data['c13'] ."]," . $liste6;
    // $liste7 = "[" . $dateD . "," . $data['c15'] ."]," . $liste7;
    // $liste8 = "[" . $dateD . "," . $data['c18'] ."]," . $liste8;
    // $liste9 = "[" . $dateD . "," . $data['c33'] ."]," . $liste9;
    // $liste10 = "[" . $dateD . "," . $data['c34'] ."]," . $liste10;
    }
?>
<style type="text/css">
#phases3 {
	min-width: 400px;
	height: 800px;
	margin: 0 auto;
}
</style>

<div id="phases3"></div>


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

	$('#phases3').highcharts({
		chart: {
			type: 'line',
			zoomType: 'x',
			backgroundColor: null,
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
				text: '',
			},
			//min: -20
		},
		tooltip: {
	        shared: true,
			crosshairs: true,
			borderRadius: 6,
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

		series: [{
			name: '<?php echo $nom0; ?>',
			color: '<?php echo $ph1_Main_Color; ?>',
			zIndex: 1,
			data: [<?php echo $liste0; ?>]
		}, {
			name: '<?php echo $nom1; ?>',
			color: '<?php echo $ph3_Main_Color; ?>',
			zIndex: 2,
			data: [<?php echo $liste1; ?>]
		}, {
			name: '<?php echo $nom2; ?>',
			color: 'yellow',
			zIndex: 3,
			data: [<?php echo $liste2; ?>]
		}, {
			name: '<?php echo $nom3; ?>',
			zIndex: 4,
			color: 'grey',
			data: [<?php echo $liste3; ?>]
		}, {
			name: '<?php echo $nom4; ?>',
			zIndex: 0,
			color: 'red',
			data: [<?php echo $liste4; ?>]
		}, {
			name: '<?php echo $nom5; ?>',
			zIndex: 0,
			color: 'lightblue',
			data: [<?php echo $liste5; ?>]
		}, {
			name: '<?php echo $nom6; ?>',
			zIndex: 0,
			color: 'blue',
			data: [<?php echo $liste6; ?>]
		}, {
			name: '<?php echo $nom7; ?>',
			zIndex: 0,
			color: 'grey',
			data: [<?php echo $liste7; ?>]
		}, {
			name: '<?php echo $nom8; ?>',
			zIndex: 0,
			color: 'maroon',
			data: [<?php echo $liste8; ?>]
		}, {
			name: '<?php echo $nom9; ?>',
			zIndex: 0,
			color: 'green',
			data: [<?php echo $liste9; ?>]
		}, {
			name: '<?php echo $nom10; ?>',
			zIndex: 0,
			color: 'black',
			data: [<?php echo $liste10; ?>]
		}] 
	});
//****************************************************************************************************
});
</script>



