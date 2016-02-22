<?php require("header_debut.php"); ?>
<script type="text/javascript" src="js/call_ajax_light.js">	</script>
<?php require("header_fin.php"); ?>

<div id="chart_last24"></div>

<?php
    $chart_last24_name = ['T° depart consigne','T° depart','T° chaudière','T° extérieur','T° intérieur','Puissance'];
    $chart_last24_chan = 'c23,c21,c3,c6,c138,c134';
?>


<?php require("footer.php");?>

<script type="text/javascript">
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
				load: requestData // in header.php
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
			},
		},

		series: [{
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
		}, {
			name: '<?php echo $chart_last24_name[5]; ?>',
			color: '<?php echo $color_puiss; ?>',
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
            chart_last24.redraw();
            chart_last24.hideLoading();
            //requestData();
        }
    });

});
</script>



