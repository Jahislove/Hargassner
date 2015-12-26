
<?php
//require("header.php");

// pre-remplissage du chart avec des valeurs null
$x = (time() * 1000);
for ($i = -2500; $i < 0; $i++){  //la valeur de $i doit correspondre a celle de shift2 dans header.php
    $listeInit .= "[($x + $i*1000),null]," ;
} 
?>

<div id="live"></div>

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
	chart_live = new Highcharts.Chart({
		chart: {
			renderTo: 'live',
			backgroundColor: null,
			defaultSeriesType: 'line',
			zoomType: 'x',
			events: {
				load: requestData // in header.php
			}
		},
		title: {
			text: 'Courbes',
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
             // minRange:1000*60*2,
             // maxRange:0,
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
			min: 0
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
			// line: {
				// marker: {
                    // radius: 0,
					// enabled: false,
				// },
			// },
			series: {
				marker: {
                    radius: 0,
					enabled: false,
				},
			}
		},

		series: [{
			name: 'etat',
			color: '<?php echo $ph1_Main_Color; ?>',
            zIndex: 1,
			data: [<?php echo $listeInit; ?>],
		}, {
			name: 'T chaud',
			color: '<?php echo $ph3_Main_Color; ?>',
            tooltip: {
                valueSuffix: ' %',
            },
            zIndex: 2,
			data: [<?php echo $listeInit; ?>],
		}, {
			name: 'SZ',
			color: 'yellow',
			zIndex: 3,
			data: [<?php echo $listeInit; ?>],
		}, {
			name: 'bois',
			zIndex: 4,
			color: 'grey',
			data: [<?php echo $listeInit; ?>],
		}, {
			name: 'puiss',
			zIndex: 0,
			color: 'red',
			data: [<?php echo $listeInit; ?>],
		}, {
			name: '160 K',
			zIndex: 0,
			color: 'lightblue',
			data: [<?php echo $listeInit; ?>],
		}, {
			name: '55 K',
			zIndex: 0,
			color: 'blue',
			data: [<?php echo $listeInit; ?>],
		}, {
			name: '54',
			zIndex: 0,
			color: 'grey',
			data: [<?php echo $listeInit; ?>],
		}/*, {
			name: '--',
			zIndex: 0,
			color: 'maroon',
			data: []
		}, {
			name: '--',
			zIndex: 0,
			color: 'lightblue',
			data: []
		}, {
			name: '--',
			zIndex: 0,
			color: 'white',
			data: []
		} */ ]
	});
//****************************************************************************************************
});
</script>



