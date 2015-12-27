
<?php
//require("header.php");

// pre-remplissage du chart avec des valeurs null
$x = (time() * 1000);
for ($i = -$histo_live_X; $i < 0; $i++){  //la valeur de $i doit correspondre a celle de la variable histo dans index.php
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
			dateTimeLabelFormats: { 
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
			series: {
				marker: {
                    radius: 0,
					enabled: false,
				},
			}
		},

		series: [{
			name: 'etat',
			color: '#01AEE3',
            zIndex: 1,
			data: [<?php echo $listeInit; ?>],
		}, {
			name: 'T° eau',
			color: '#E662CC',
            tooltip: {
                valueSuffix: ' °',
            },
            zIndex: 2,
			data: [<?php echo $listeInit; ?>],
		}, {
			name: 'Extraction',
			color: 'yellow',
			zIndex: 3,
			data: [<?php echo $listeInit; ?>],
		}, {
			name: '% bois',
			zIndex: 4,
			color: 'grey',
			data: [<?php echo $listeInit; ?>],
		}, {
			name: 'puissance',
			zIndex: 0,
			color: 'red',
			data: [<?php echo $listeInit; ?>],
		}, {
			name: 'T° départ',
			zIndex: 0,
			color: 'lightblue',
			data: [<?php echo $listeInit; ?>],
		}, {
			name: 'F',
			zIndex: 0,
			color: 'blue',
			data: [<?php echo $listeInit; ?>],
		}, {
			name: 'K',
			zIndex: 0,
			color: 'grey',
			data: [<?php echo $listeInit; ?>],
		}]
	});
});
</script>



