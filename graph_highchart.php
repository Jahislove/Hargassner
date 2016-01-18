<?php require("header_debut.php"); ?>
<script type="text/javascript" src="js/call_ajax_light.js">	</script>
<?php require("header_fin.php"); ?>

<div id="last24"></div>

<?php
    $tab1 = 'c23';
    $nom1 = 'T depart doit';
    $tab2 = 'c3';
    $nom2 = 'T° chaud';
    $tab3 = 'c21';
    $nom3 = 'T° depart';
    $tab4 = 'c6';
    $nom4 = 'T° ext';
    $tab5 = 'm138';
    $nom5 = 'T° int';
    
    $query = "SELECT dateB,$tab1,$tab2,$tab3,$tab4,$tab5 FROM nanoPK
              ORDER by id DESC LIMIT 20000";

    //$query = "SELECT dateB,$tab0,$tab1,$tab2,$tab3,$tab4,$tab5,$tab6,$tab7,$tab8,$tab9,$tab10 FROM nanoPK
    //          WHERE dateB > '2015-12-12 04:55:00' and dateB < '2015-12-12 09:00:00'
    //          ";

    // $query = "SELECT dateB,$tab0,$tab1,$tab2,$tab3,$tab4 FROM nanoPK
             // WHERE dateB > '2015-12-24 13:55:00' and dateB < '2015-12-24 14:15:00'
             // ";

	connectMaBase($hostname, $database, $username, $password);
    $req = mysql_query($query) ;
	mysql_close();
	
    while($data = mysql_fetch_row($req))
    {
    $dateD = strtotime($data[0]) * 1000;
        $liste1[] = "[$dateD, $data[1]]";
        $liste2[] = "[$dateD, $data[2]]";
        $liste3[] = "[$dateD, $data[3]]";
        $liste4[] = "[$dateD, $data[4]]";
        $liste5[] = "[$dateD, $data[5]]";
    }
   $liste1 = join(',', array_reverse($liste1));
   $liste2 = join(',', array_reverse($liste2));
   $liste3 = join(',', array_reverse($liste3));
   $liste4 = join(',', array_reverse($liste4));
   $liste5 = join(',', array_reverse($liste5));
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

	last24 = new Highcharts.Chart({
		chart: {
            renderTo: 'last24',
			type: 'spline',
			zoomType: 'x',
			backgroundColor: null,
			events: {
				load: requestData // in header.php
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
			gridLineColor: '#EFEFEF', 
			labels: {
				format: '{value}',
				style: {
					color: '#4572A7',
				}
			},
		   title: {
				text: 'Température',
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
			valueSuffix: '',
			xDateFormat: '%e. %b %H:%M:%S',
		 },
		plotOptions: {
			series: {
				marker: {
					enabled: false,
				},
			}
		},

		series: [{
			name: '<?php echo $nom1; ?>',
			color: '#01AEE3',
            type: 'line',
			zIndex: 1,
			data: [<?php echo $liste1; ?>]
		}, {
			name: '<?php echo $nom2; ?>',
			color: '#E662CC',
			zIndex: 2,
			data: [<?php echo $liste2; ?>]
		}, {
			name: '<?php echo $nom3; ?>',
			color: 'green',
			zIndex: 3,
			data: [<?php echo $liste3; ?>]
		}, {
			name: '<?php echo $nom4; ?>',
			zIndex: 4,
			color: '#EA7C01',
			data: [<?php echo $liste4; ?>]
		}, {
			name: '<?php echo $nom5; ?>',
			zIndex: 4,
			color: 'black',
			data: [<?php echo $liste5; ?>]
		}] 
	});
//****************************************************************************************************
/* last24.showLoading('loading');

 $.ajax({
    dataType: "json",
    url: 'json_last24.php',
    data: 'channel=c6',
    cache: false,
    success: function(data) {
        
        last24.series[1].setData(data);
        //last24.redraw();
        //last24.hideLoading();
    }
});
$.ajax({
    dataType: "json",
    url: 'json_last24.php',
    data: 'channel=m134',
    cache: false,
    success: function(data) {
        
        last24.series[2].setData(data);
        //last24.redraw();
        last24.hideLoading();
    }
});
 */
 });
</script>



