<?php require("header_debut.php"); ?>
<script type="text/javascript" src="js/call_ajax_light.js">	</script>
<?php require("header_fin.php"); ?>

<div id="chart_last24"></div>

<?php
    $chart_last24_name = ['T° depart doit','T° depart','T° chaud','T° ext','T° int'];
    $chart_last24_chan = 'c23,c21,c3,c6,c138';
?>


<?php require("footer.php");?>

<script type="text/javascript">
$(document).ready(function(){
//*** definition du graphe *****************************
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
			dateTimeLabelFormats: { // don't display the dummy year
				month: '%e. %b',
				year: '%b'
			}
		 },
		yAxis: {
			gridLineColor: '#EFEFEF', 
			labels: {
				format: '{value}',
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
			//min: -20
		},
		tooltip: {
	        shared: true,
			crosshairs: true,
			borderRadius: 6,
			borderWidth: 1,
			valueSuffix: '°C',
			xDateFormat: '%e. %b %H:%M:%S',
		 },
		plotOptions: {
			series: {
                //lineWidth: 1,
				marker: {
					enabled: false,
				},
			}
		},

		series: [{
            type: 'line',
			name: '<?php echo $chart_last24_name[0]; ?>',
			color: '<?php echo $color_TdepD; ?>',
			zIndex: 5,
			data: []
		}, {
			name: '<?php echo $chart_last24_name[1]; ?>',
			color: '<?php echo $color_TdepE; ?>',
			zIndex: 3,
			data: []
		}, {
			name: '<?php echo $chart_last24_name[2]; ?>',
			color: '<?php echo $color_Tchaud; ?>',
			zIndex: 2,
			data: []
		}, {
			name: '<?php echo $chart_last24_name[3]; ?>',
			color: '<?php echo $color_Text; ?>',
			zIndex: 4,
			data: []
		}, {
			name: '<?php echo $chart_last24_name[4]; ?>',
			color: '<?php echo $color_Tint; ?>',
			zIndex: 4,
			data: []
		}] 
	});
//****************************************************************************************************
//*** chargement des données en asynchrone *****************************
    chart_last24.showLoading('loading');

    $.ajax({
        dataType: "json",
        url: 'json_last24.php',
        data: 'channel=<?php echo $chart_last24_chan; ?>',
        cache: false,
        success: function(data) {
            chart_last24.series[0].setData(data[0],false);
            chart_last24.series[1].setData(data[1],false);
            chart_last24.series[2].setData(data[2],false);
            chart_last24.series[3].setData(data[3],false);
            chart_last24.series[4].setData(data[4],false);
            chart_last24.redraw();
            chart_last24.hideLoading();
            //requestData();
        }
    });

});
</script>



