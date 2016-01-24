<?php require("header_debut.php"); ?>
<script type="text/javascript" src="js/call_ajax_light.js">	</script>
<?php require("header_fin.php"); ?>

<div id="chart_last24"></div>

<?php
    $chart_last24_name = ['T° depart doit','T° depart','T° chaud','T° ext','T° int'];
    $chart_last24_chan = 'c23,c21,c3,c6,m138';
    
    // $tab1 = 'c23';
    // $nom1 = 'T depart doit';
    // $tab2 = 'c3';
    // $nom2 = 'T° chaud';
    // $tab3 = 'c21';
    // $nom3 = 'T° depart';
    // $tab4 = 'c6';
    // $nom4 = 'T° ext';
    // $tab5 = 'm138';
    // $nom5 = 'T° int';
    
    // $query = "SELECT dateB,$tab1,$tab2,$tab3,$tab4,$tab5 FROM nanoPK
              // ORDER by id DESC LIMIT 20000";


	// connectMaBase($hostname, $database, $username, $password);
    // $req = mysql_query($query) ;
	// mysql_close();
	
    // while($data = mysql_fetch_row($req))
    // {
        // $dateD = strtotime($data[0]) * 1000;
        // $liste1[] = "[$dateD, $data[1]]";
        // $liste2[] = "[$dateD, $data[2]]";
        // $liste3[] = "[$dateD, $data[3]]";
        // $liste4[] = "[$dateD, $data[4]]";
        // $liste5[] = "[$dateD, $data[5]]";
    // }
   // $liste1 = join(',', array_reverse($liste1));
   // $liste2 = join(',', array_reverse($liste2));
   // $liste3 = join(',', array_reverse($liste3));
   // $liste4 = join(',', array_reverse($liste4));
   // $liste5 = join(',', array_reverse($liste5));
?>


<?php require("footer.php");?>

<script type="text/javascript">
$(document).ready(function(){
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
			name: '<?php echo $chart_last24_name[0]; ?>',
			color: '#F62B07',
            type: 'line',
			zIndex: 5,
			data: []
		}, {
			name: '<?php echo $chart_last24_name[1]; ?>',
			color: '#781BE1',
			zIndex: 3,
			data: []
		}, {
			name: '<?php echo $chart_last24_name[2]; ?>',
			color: '#E662CC',
			zIndex: 2,
			data: []
		}, {
			name: '<?php echo $chart_last24_name[3]; ?>',
			zIndex: 4,
			color: '#EA7C01',
			data: []
		}, {
			name: '<?php echo $chart_last24_name[4]; ?>',
			zIndex: 4,
			color: 'black',
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
            requestData();
        }
    });

});
</script>



