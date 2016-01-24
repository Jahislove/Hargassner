<?php require("header_debut.php"); ?>
<script type="text/javascript" src="js/call_ajax_light.js">	</script>
<?php require("header_fin.php"); ?>
    
<div id="conso" class="chart3_duo"></div>
<div id="courbe" class="chart3_duo"></div>

<?php
    $chart1_name = ['Conso','T° ext moy'];
    //$chart1_chan = "m99,c6";

    $query1 = "SELECT dateB,conso,Tmoy FROM consommation ";

	connectMaBase($hostname, $database, $username, $password);
    $req = mysql_query($query1) ;
	mysql_close();

    while($data = mysql_fetch_row($req)){
        $dateD = strtotime($data[0]) * 1000;
        $chart1_data1[] = "[$dateD, $data[1]]";
        $chart1_data2[] = "[$dateD, $data[2]]";
    }

    $chart1_data1 = join(',', $chart1_data1);
    $chart1_data2 = join(',', $chart1_data2);
?>



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

	chart1 = new Highcharts.Chart({
		chart: {
			renderTo: 'conso',
			zoomType: 'xy',
			backgroundColor: null,
			events: {
				//load: requestData // in header.php
			}
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
			//xDateFormat: '',
		 },
        plotOptions: {
            series: {
				marker: {
					enabled: false
				},
                cursor: 'pointer',
                point: {
                    events: {
                        click: function () {
                            //alert('Category: ' + this.x + ', value: ' + this.y);
                            chart2.showLoading('loading');
                            $.ajax({
                                dataType: "json",
                                url: 'json_choix_jour.php',
                                data: 'channel=' + Date(this.y*1000),
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

                        }
                    }
                }
            }
        },

		series: [{
			name: '<?php echo $chart1_name[0]; ?>',
			type: 'column',
			color: '#01AEE3',
			zIndex: 1,
			data: [<?php echo $chart1_data1; ?>]
		}, {
			name: '<?php echo $chart1_name[1]; ?>',
			type: 'line',
			color: '#E662CC',
			zIndex: 2,
			data: [<?php echo $chart1_data2; ?>]
		}] 
	});
//****************************************************************************************************
	chart2 = new Highcharts.Chart({
		chart: {
			renderTo: 'courbe',
			zoomType: 'xy',
			backgroundColor: null,
			events: {
				//load: requestData // in header.php
			}
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
			name: '<?php echo $chart1_name[0]; ?>',
			type: 'line',
			color: '#01AEE3',
			zIndex: 1,
			data: []
		}, {
			name: '<?php echo $chart1_name[1]; ?>',
			type: 'line',
			color: '#E662CC',
			zIndex: 2,
			data: []
		}, {
			name: '<?php echo $chart1_name[1]; ?>',
			type: 'line',
			color: 'red',
			zIndex: 2,
			data: []
		}, {
			name: '<?php echo $chart1_name[1]; ?>',
			type: 'line',
			color: 'green',
			zIndex: 2,
			data: []
		}, {
			name: '<?php echo $chart1_name[1]; ?>',
			type: 'line',
			color: 'black',
			zIndex: 2,
			data: []
		}] 
	});

    
});
</script>



