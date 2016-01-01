<?php require("header_debut.php"); ?>
<script type="text/javascript" src="js/call_ajax_light.js">	</script>
<?php require("header_fin.php"); ?>
    
<?php
    $chart1_name = ['T° ext','T° ext moy','T° int','T depart est','T° depart doit'];
    $chart1_chan = "c6,c7,m138,c21,c23";
    $chart2_name = ['Etat','Puissance','T° chaudiere','T° fumée','O² lambda'];
    $chart2_chan = "chan0,m134,c3,c5,chan1";
    $chart3_name = ['Aspiration','-','-',toto,titi];
    $chart3_chan = "m169,m87,m87,m87,m87";
    $chart4_name = ['Etat','Puissance','T° chaudiere',toto,titi];
    $chart4_chan = "m87,m87,m87,m87,m87";
    
    $query = "SELECT dateB,$chart1_chan,$chart2_chan,$chart3_chan,$chart4_chan FROM nanoPK
              ORDER by id DESC LIMIT 1000";

	connectMaBase($hostname, $database, $username, $password);
    $req = mysql_query($query) ;
	mysql_close();
	
    while($data = mysql_fetch_row($req)){
        $dateD = strtotime($data[0]) * 1000;
        $chart1_data1[] = "[$dateD, $data[1]]";
        $chart1_data2[] = "[$dateD, $data[2]]";
        $chart1_data3[] = "[$dateD, $data[3]]";
        $chart1_data4[] = "[$dateD, $data[4]]";
        $chart1_data5[] = "[$dateD, $data[5]]";

        $chart2_data1[] = "[$dateD, $data[6]]";
        $chart2_data2[] = "[$dateD, $data[7]]";
        $chart2_data3[] = "[$dateD, $data[8]]";
        $chart2_data4[] = "[$dateD, $data[9]]";
        $chart2_data5[] = "[$dateD, $data[10]]";

        $chart3_data1[] = "[$dateD, $data[11]]";
        $chart3_data2[] = "[$dateD, $data[12]]";
        $chart3_data3[] = "[$dateD, $data[13]]";
        $chart3_data4[] = "[$dateD, $data[14]]";
        $chart3_data5[] = "[$dateD, $data[15]]";

        $chart4_data1[] = "[$dateD, $data[16]]";
        $chart4_data2[] = "[$dateD, $data[17]]";
        $chart4_data3[] = "[$dateD, $data[18]]";
        $chart4_data4[] = "[$dateD, $data[19]]";
        $chart4_data5[] = "[$dateD, $data[20]]";
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

    $chart4_data1 = join(',', array_reverse($chart4_data1));
    $chart4_data2 = join(',', array_reverse($chart4_data2));
    $chart4_data3 = join(',', array_reverse($chart4_data3));
    $chart4_data4 = join(',', array_reverse($chart4_data4));
    $chart4_data5 = join(',', array_reverse($chart4_data5));
    ?>

<div class="rel">
    <div id="test1" class="test2"></div>
    <div id="test2" class="test2"></div>
    <div id="test3" class="test2"></div>
    <div id="test4" class="test2"></div>
</div>

<div class="clear"></div>

<?php require("footer.php");?>

<script type="text/javascript">
$(document).ready(function(){
//$(function() {
    // *************set options for all charts ******************************
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
			zoomType: 'xy',
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
			backgroundColor: 'white',
			borderRadius: 14,
		},
		xAxis: {
			type: 'datetime',
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
    });

    // *************chart 1 ********************************************
	$('#test1').highcharts({
		chart: {
			events: {
				load: requestData // in header_debut.php
			}
        },
		series: [{
			name: '<?php echo $chart1_name[0]; ?>',
			color: '#01AEE3',
			data: [<?php echo $chart1_data1; ?>]
		}, {
			name: '<?php echo $chart1_name[1]; ?>',
			color: '#E662CC',
			data: [<?php echo $chart1_data2; ?>]
		}, {
			name: '<?php echo $chart1_name[2]; ?>',
			color: 'blue',
			data: [<?php echo $chart1_data3; ?>]
		}, {
			name: '<?php echo $chart1_name[3]; ?>',
			color: 'grey',
			data: [<?php echo $chart1_data4; ?>]
		}, {
			name: '<?php echo $chart1_name[4]; ?>',
			color: 'red',
			data: [<?php echo $chart1_data5; ?>]
		}] 
	});
    // *************chart 2 ********************************************
	$('#test2').highcharts({
		series: [{
			name: '<?php echo $chart2_name[0]; ?>',
			color: '#01AEE3',
			data: [<?php echo $chart2_data1; ?>]
		}, {
			name: '<?php echo $chart2_name[1]; ?>',
			color: 'red',
			data: [<?php echo $chart2_data2; ?>]
		}, {
			name: '<?php echo $chart2_name[2]; ?>',
			color: '#E662CC',
			data: [<?php echo $chart2_data3; ?>]
		}, {
			name: '<?php echo $chart2_name[3]; ?>',
			color: 'grey',
			data: [<?php echo $chart2_data4; ?>]
		}, {
			name: '<?php echo $chart2_name[4]; ?>',
			color: '#01DF01',
			data: [<?php echo $chart2_data5; ?>]
		}] 
	});
    // *************chart 3 ********************************************
	$('#test3').highcharts({
		series: [{
			name: '<?php echo $chart3_name[0]; ?>',
			color: '#01AEE3',
			data: [<?php echo $chart3_data1; ?>]
		}, {
			name: '<?php echo $chart3_name[1]; ?>',
			color: 'red',
			data: [<?php echo $chart3_data2; ?>]
		}, {
			name: '<?php echo $chart3_name[2]; ?>',
			color: '#E662CC',
			data: [<?php echo $chart3_data3; ?>]
		}, {
			name: '<?php echo $chart3_name[3]; ?>',
			color: 'grey',
			data: [<?php echo $chart3_data4; ?>]
		}, {
			name: '<?php echo $chart3_name[4]; ?>',
			color: '#01DF01',
			data: [<?php echo $chart3_data5; ?>]
		}] 
	});
    // *************chart 4 ********************************************
	chart4 = new Highcharts.Chart({
		chart: {
			renderTo: 'test4',
        },
	//$('#test4').highcharts({
		series: [{
			name: '<?php echo $chart4_name[0]; ?>',
			color: '#01AEE3',
			data: [<?php echo $chart4_data1; ?>]
		}, {
			name: '<?php echo $chart4_name[1]; ?>',
			color: 'red',
			data: [<?php echo $chart4_data2; ?>]
		}, {
			name: '<?php echo $chart4_name[2]; ?>',
			color: '#E662CC',
			data: [<?php echo $chart4_data3; ?>]
		}, {
			name: '<?php echo $chart4_name[3]; ?>',
			color: 'grey',
			data: [<?php echo $chart4_data4; ?>]
		}, {
			name: '<?php echo $chart4_name[4]; ?>',
			color: '#01DF01',
			data: [<?php echo $chart4_data5; ?>]
		}] 
	});
//****************************************************************************************************

chart4.showLoading('loading');


chart4.series[0].setData([<?php echo $chart4_data[0]; ?>]);




});
</script>



