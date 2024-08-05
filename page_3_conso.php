<?php require("header.php"); ?>

<div class="calendar">
    <div class="input-group date">
        <input type="text" class="form-control" placeholder="<?php echo calendar_consum_title; ?>">
        <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
    </div>
</div>

<div id="conso" class="graphe_size"></div> 
<div id="courbe" class="graphe_size"></div> 

<div id="conso_par_mois" class="graphe_size4"></div> 

<div id="cumul_saison" class="graphe_size3"></div> 
<div id="tarif_histo" class="graphe_size3"></div> 

<div class="graphe_size3">
	<span id="prix_moyen_histo" class="graphe_size5"></span> 
	<div id="info_histo" class="graphe_size5" > 
		<table id="stat" class="TableTarif">  
			<tr></tr>    
		</table>
	</div>
</div>



<?php
// pense bete : 
// calcul correction consommation
// conso total / 2.2 = A
// conso reelle / A = X  nouveau facteur Kg/h
// 100 * (X/2.2) = % de correction a apporter en base

    // $chart1_name = ['kilo granulés par jour','cout granulés par jour','T° extérieure moyenne'];
    // $chart2_name = ['T° départ consigne','T° départ','T° chaudière','T° extérieure','T° intérieure','Puissance','% bois'];
    // $chart3_name = ['Sur la Saison'];

    // recupere la conso des 90 derniers jours
    // $query0 = "SELECT dateB,conso,Tmoy FROM consommation 
            // ORDER BY dateB DESC LIMIT 90";
    // recupere la 1ere mesure dans la base pour initialiser le calendrier
    $query1 = "SELECT YEAR(dateB),MONTH(dateB) FROM consommation 
             LIMIT 1";
			 
    // recupere la conso moyenne des 3 derniers mois
    $query2 = "SELECT MONTH(dateB),FORMAT(AVG(conso),1) FROM consommation 
				GROUP BY YEAR(dateB), MONTH(dateB)           
				ORDER BY dateB DESC LIMIT 3 ";

    // recupere le prix de la saison en cours
	$query3 = "SELECT * FROM tarif 
			ORDER BY saison DESC LIMIT 1" ;

	$conn = mysqli_connect ($hostname, $username, $password, $database); 
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
    // $req0 = mysqli_query($conn, $query0) ;
    $req1 = mysqli_query($conn, $query1) ;
    $req2 = mysqli_query($conn, $query2) ;
    $req3 = mysqli_query($conn, $query3) ;
	mysqli_close($conn);

    $data = mysqli_fetch_row($req3);
    $prix = $data[1];

    $data = mysqli_fetch_row($req1);
    $dateMin = [$data[0],$data[1]];

	// pour decaler les mois d'une saison
	$season = explode(',',months);	
	for ($i=1;$i<9;$i++) { // decale de 9 mois
		array_push($season, array_shift($season));
	}
	// echo implode(',', $season);	// affiche le contenu d'un array
	
	//pour les 3 bulles de moyenne
	$moisNom = explode(',',months);
    while($data = mysqli_fetch_row($req2)){
		$mois[] = $moisNom[$data[0]-1]; // transformation mois numerique en nom long
        $consoMoy[] = $data[1];
    }
?>

<?php require("footer.php");?>
<script type="text/javascript">
//*****************Calendrier pickup********************************************************
var val_precedente = 0;
$(function() {
	$('#courbe').hide();
    $( ".input-group.date" ).datepicker({
        format: "MM yyyy",
        startDate: new Date(<?php echo $dateMin[0]; ?>,<?php echo $dateMin[1]; ?> - 1,1),
        endDate: new Date(),
        minViewMode: 1,
        language: "fr",
        autoclose: true    
    })
    .on('changeDate', function(e){
		$('#courbe').slideUp(1000);
		chart1.showLoading('loading');
		annee = e.format('yyyy');
		mois = e.format('mm');
		$.ajax({
			dataType: "json",
			url: 'json_conso_mois.php',
			data: 'mois=' + mois + '&annee=' + annee,
			cache: false,
			success: function(data) {
				chart1.series[0].setData(data[0],false);
				chart1.series[1].setData(data[1],false);
				chart1.redraw();
				chart1.hideLoading();
			}
		});
    });
});

//*****************chart options communes********************************************************
$(function() {
    Highcharts.setOptions({
		lang: {
			months: [<?php echo months; ?>],
			weekdays: [<?php echo weekdays; ?>],
			shortMonths: [<?php echo shortMonths; ?>],
			thousandsSep: "",
		},
		chart: {
			zoomType: 'x',
			backgroundColor: null,
            animation: {
                duration: 1000
            },
        },
		global: {
			useUTC: false,
			//timezoneOffset: -1 * 60
		},
	    credits: {
			enabled: false,
		},
		legend: {
			enabled: true,
			backgroundColor: '<?php echo $color_legend; ?>',
			borderRadius: 14,
            align: 'right',
            x: -30,
			verticalAlign: 'top',
            shadow: true,
			itemStyle: {
				color: 'black',
                fontWeight: 'light',
			},
		},
    });

//*****chart 1  conso+temp*********************************************************************************
	chart1 = new Highcharts.Chart({
		chart: {
			renderTo: 'conso',
			events: {
				load: requestData('call_ajax_light') // in header.php
			},
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
		xAxis: {
			type: 'datetime',
            labels: {
                style: {
					color: 'black',
				},
			},
            tickInterval: 24*3600*1000,
			dateTimeLabelFormats: { 
				day: '%d/%m',
			},
		 },
		yAxis: {
			gridLineColor: '#CACACA', 
			labels: {
				format: '{value}',
				style: {
					color: '#4572A7',
				}
			},
			title: {
				text: '',
			},
			// max: 60,
            plotBands: {
                color: '#E7FFFF',
                from: 0,
                to: -30,
            },
		},
		tooltip: {
	        shared: true,
			crosshairs: true,
			borderRadius: 6,
			borderWidth: 1,
			valueSuffix: '',
			xDateFormat: '%A %d %B %Y',
		 },
        plotOptions: {
            series: {
				marker: {
					enabled: true
				},
                cursor: 'pointer',
                point: {
                    events: {
                        // affiche le detail des courbes quand on clic sur une valeur
						click: function () {
                            chart2.showLoading('loading');
							// garde le graphe affiché si on clic sur une autre journée , cache le graphe si on clic sur la meme journée
							if (this.x != val_precedente) {
								$('#courbe').slideDown(1000);
							} else {
								$('#courbe').slideUp(1000);
							}
							val_precedente = this.x;

                            var jour = new Date(this.x);
                            chart2.setTitle('',{ text: jour.toLocaleDateString() });
                            $.ajax({
                                dataType: "json",
                                url: 'json_choix_jour.php',
                                data: 'channel=' + this.x,
                                cache: false,
                                success: function(data) {
                                    chart2.series[0].setData(data[0],false);
                                    chart2.series[1].setData(data[1],false);
                                    chart2.series[2].setData(data[2],false);
                                    chart2.series[3].setData(data[3],false);
                                    chart2.series[4].setData(data[4],false);
                                    chart2.series[5].setData(data[5],false);
                                    chart2.series[6].setData(data[6],false);
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
			name: '<?php echo chart1_consum_kilo; ?>',
			type: 'column',
			color: '<?php echo $color_gran; ?>',
            pointPadding: 0,
            groupPadding: 0.05,
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '10px',
                },
                y: 7,
            },
            tooltip: {
                valueSuffix: ' Kg',
             },
			zIndex: 1,
		}, {
			name: '<?php echo chart1_consum_outT; ?>',
			type: 'line',
			color: '<?php echo $color_TextM; ?>',
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '10px',
					textOutline: false,
                },
                color: '<?php echo $color_TextM; ?>',
                y: 25,
            },
            tooltip: {
                valueSuffix: ' °C',
             },
			zIndex: 2,
		},{
			name: '<?php echo chart1_consum_cost; ?>',
			type: 'column',
			color: '#ff9900',
            pointPadding: 0,
            groupPadding: 0.05,
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '10px',
                },
                y: 7,
            },
            tooltip: {
                valueSuffix: ' €',
             },
			zIndex: 1,
		}] 
	});
    
//******chart 2 detail apres clic******************************************************************************
	chart2 = new Highcharts.Chart({
		chart: {
			renderTo: 'courbe',
			events: {
				click: function() {
					$('#courbe').slideUp(1000);
				}
			},
		},
		title: {
			text: '<?php echo chart2_consum_title; ?>',
	        align: 'left',
	        x: 65,
			style:{
				color: '#4572A7',
			},
		},
		subtitle: {
			text: '',
	        align: 'left',
	        x: 65,
			style:{
				color: '#4572A7',
			},
		},
		xAxis: {
			type: 'datetime',
			dateTimeLabelFormats: { 
				month: '%d. %b',
				year: '%b'
			}
		 },
		yAxis: {
			gridLineColor: '#CACACA', 
			labels: {
				format: '{value}',
				style: {
					color: '#4572A7',
				}
			},
		   title: {
				text: '',
			},
            plotBands: {
                color: '#E7FFFF',
                from: 0,
                to: -30,
            },
			max: 100,
		},
		tooltip: {
	        shared: true,
			crosshairs: true,
			borderRadius: 6,
			borderWidth: 1,
			valueSuffix: '',
			xDateFormat: '%A %d %B %H:%M',
		 },
		plotOptions: {
			series: {
                lineWidth: 1.5,
				marker: {
					enabled: false
				},
                states: {
                    hover: {
                        enabled: false,
                    }
                },
                connectNulls: false,
			}
		},

		series: [{
			name: '<?php echo text_tempZ1_toHeaterMust; ?>',
			type: 'line',
			color: '<?php echo $color_TdepD; ?>',
			zIndex: 1,
			data: []
		}, {
			name: '<?php echo text_tempZ2_toHeaterIs; ?>',
			type: 'line',
			color: '<?php echo $color_TdepE; ?>',
			zIndex: 2,
			data: []
		}, {
			name: '<?php echo text_temp_waterIs; ?>',
			type: 'line',
			color: '<?php echo $color_Tchaud; ?>',
			zIndex: 2,
			data: []
		}, {
			name: '<?php echo text_temp_outdoor; ?>',
			type: 'line',
			color: '<?php echo $color_Text; ?>',
			zIndex: 2,
			data: []
		}, {
			name: '<?php echo text_temp_indoor; ?>',
			type: 'line',
			color: '<?php echo $color_Tint; ?>',
			zIndex: 2,
			data: []
		}, {
			name: '<?php echo text_power; ?>',
			type: 'line',
            lineWidth: 1,
			color: '<?php echo $color_puiss; ?>',
			zIndex: 2,
			data: []
		}, {
			name: '<?php echo text_wood; ?>',
			type: 'line',
            lineWidth: 1,
            visible: false,
			color: '<?php echo $color_bois; ?>',
			zIndex: 2,
			data: []
		}] 
	});

//*******chart 3 conso annuelle**************************************************************************
	chart3 = new Highcharts.Chart({
		chart: {
			renderTo: 'cumul_saison',
			type: 'column',
			alignThresholds: true,
		},
		legend: {
			enabled: true,
		},
		title: {
			text: '<?php echo chart3_consum_Title; ?>',
	        align: 'left',
	        x: 65,
			style:{
				color: '#4572A7',
			},
		},
		xAxis: {
			type: 'category',
			crosshair: false,
			visible: false,
		 },
		yAxis: [{
			gridLineColor: '#CACACA', 
            //softMax: 1000,
			min: 0,
			labels: {
				format: '{value} Kg',
				// style: {
					// color: '<?php echo $color_gran; ?>',
				// }
			},
		   title: {
				text: '',
			},
		},{
			opposite:true,
			gridLineColor: '#CACACA', 
            //softMax: 1000,
			min: 0,
			labels: {
				format: '{value} €',
				// style: {
					// color: '<?php echo $color_gran; ?>',
				// }
			},
		   title: {
				text: '',
			},
		}],            
		tooltip: {
	        shared: true,
			distance: 30,
			padding: 5,
			crosshairs: true,
			borderRadius: 26,
			borderWidth: 2,
		},
		plotOptions: {
			series: {
				colorByPoint: true,
				marker: {
					enabled: true,
				},
				dataLabels: {
					useHTML: false,
					formatter: function () {
							return '<span style="color:' + this.point.color + '">' + this.point.y + '</span>';
					},
				},
			},
            column: {
				// colors a synchro avec json_conso_annees.php
                grouping: true,
                shadow: false,
                borderWidth: 0,
				dataLabels: {
					enabled: true,
					style: {
						fontSize: '12px',
						textOutline: true,
					},
					rotation: 0,
					// color: '#F0DB0B',
					align: 'center',
					y: 0,
				},
            },
		},
		series: [{
			name: '<?php echo chart3_consum_kilo; ?>',
			type: 'column',
			// colors a synchro avec json_conso_annees.php
			colors: ['rgba(230,126,34,1)','rgba(155,89,182,1)','rgba(41,128,185,1)','rgba(46,204,113,1)','rgba(241,196,15,1)','rgba(213,76,60,1)','rgba(230,126,255,1)','rgba(10,126,255,1)','rgba(150,150,150,1)','rgba(0,150,150,1)','rgba(150,150,10,1)'],
            borderWidth: 0,
            dataLabels: {
                formatter: function() {
                    return '<span style="color: ' + this.point.color + '">' + this.point.y + ' Kg</span>';   
                },
				// x: -10,
			},
            tooltip: {
                valueSuffix: ' Kg',
             },
			zIndex: 1,
		},{
			name: '<?php echo chart3_consum_cost; ?>',
			type: 'column',
			// colors a synchro avec json_conso_annees.php
			colors: ['rgba(230,126,34,0.6)','rgba(155,89,182,0.6)','rgba(41,128,185,0.6)','rgba(46,204,113,0.6)','rgba(241,196,15,0.6)','rgba(213,76,60,0.6)','rgba(230,126,255,0.6)','rgba(10,126,255,0.6)','rgba(150,150,150,0.6)','rgba(0,150,150,0.7)','rgba(150,150,10,0.7)'],
            dataLabels: {
                formatter: function() {
                    return '<span style="color: ' + this.point.color + '">' + this.point.y + '€</span>';   
                },
				// align: 'left',
				x: 8,
			},
            tooltip: {
                valueSuffix: ' €',
             },
			zIndex: 0,
			yAxis: 1,
		}] 
	});
//*******chart 4 conso par mois*************************************************************************
	chart4 = new Highcharts.Chart({
		chart: {
			renderTo: 'conso_par_mois',
			alignThresholds: true,
		},
		title: {
			text: '<?php echo chart4_consum_Title; ?>',
	        align: 'left',
	        x: 65,
			style:{
				color: '#4572A7',
			},
		},
		subtitle: {
	        align: 'left',
	        x: 65,
			text: '<?php echo chart4_consum_subT; ?>',
			style:{
				color: '#4572A7',
			},
		},
		xAxis: {
			type: 'category',
			crosshair: true,
			crosshair: {
				snap: true,
				// width: 30,
			},
            categories: [<?php echo implode(',', $season); ?>], // afiche le contenu d'un array
		 },
		yAxis: [{
			gridLineColor: '#CACACA', 
            softMax: 1000,
			//min: -250,
            top: 250,
            height: 300,
			labels: {
				format: '{value} Kg',
				style: {
					color: '<?php echo $color_gran; ?>',
				}
			},
		   title: {
				text: '',
			},
		},{
			opposite: true,
            // softMax: 40,
			// min: -10,
			Min: -10,
            top: 50,
            height: 200,
			labels: {
				format: '{value} °C',
				style: {
					color: '#72EA01',
				}
			},
            title: {
				text: '',
			},
		}],            
		legend: {
            x: -30,
			y: 0,
            align: 'right',
			verticalAlign: 'top',
			floating: true
		},
		tooltip: {
	        shared: true,
			followPointer: true,
			distance: 30,
			padding: 5,
			crosshairs: true,
			borderRadius: 26,
			borderWidth: 2,
			headerFormat: '<span style="font-size: 15px">{point.key}</span><br/>',
			// pointFormat: '<span style="color:{point.color}">\u25CF</span> {series.name}: <span align="right"><b>{point.y}</b></span><br/>',		
			useHTML: true,
			// formatter: function () {
				// var s = '<b>' + this.x + '</b>';
                // $.each(this.points, function () {
                    // s += '<br/>\u25CF' + this.series.name + this.x +': ' +
                        // this.y + ' Kg';
                // });
                // return s;
            // },
		},
		plotOptions: {
			series: {
				lineWidth: 1,
				marker: {
					enabled: true,
					symbol: 'circle',
				},
				dataLabels: {
					useHTML: false,
					formatter: function () {
							return '<span style="color:' + this.point.color + '">' + this.point.y + '</span>';
					},
				},
			},
            column: {
                grouping: true,
				groupPadding: 0.05,
				pointPadding: 0.05,
                shadow: false,
                borderWidth: 0
            },
		},

		series: [] 
	});
//*******chart 5 tarif historique saison**************************************************************************
	chart5 = new Highcharts.Chart({
		chart: {
			renderTo: 'tarif_histo',
			type: 'column',
			alignThresholds: true,
		},
		legend: {
			enabled: false,
		},
		title: {
			text: 'historique tarif achat',
	        align: 'left',
	        x: 65,
			style:{
				color: '#4572A7',
			},
		},
		xAxis: {
			type: 'category',
			crosshair: false,
			visible: false,
		 },
		yAxis: [{
			gridLineColor: '#CACACA', 
            //softMax: 1000,
			min: 0,
			labels: {
				format: '{value} €/tonne',
				// style: {
					// color: '<?php echo $color_gran; ?>',
				// }
			},
		   title: {
				text: '',
			},
		}],            
		tooltip: {
	        shared: true,
			distance: 30,
			padding: 5,
			crosshairs: true,
			borderRadius: 26,
			borderWidth: 2,
		},
		plotOptions: {
			series: {
				colorByPoint: true,
				marker: {
					enabled: true,
				},
				dataLabels: {
					useHTML: false,
					formatter: function () {
							return '<span style="color:' + this.point.color + '">' + this.point.y + '</span>';
					},
				},
			},
            column: {
				// colors a synchro avec json_conso_annees.php
				colors: ['rgba(230,126,34,1)','rgba(155,89,182,1)','rgba(41,128,185,1)','rgba(46,204,113,1)','rgba(241,196,15,1)','rgba(213,76,60,1)','rgba(230,126,255,1)','rgba(10,126,255,1)','rgba(150,150,150,1)','rgba(0,150,150,1)','rgba(150,150,10,1)'],
                grouping: false,
                shadow: false,
                borderWidth: 0
            },
		},

		series: [{
			name: 'par tonne',
			type: 'column',
            pointPadding: 0.3,
            groupPadding: 0.05,
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '12px',
					textOutline: false,
                },
                rotation: 0,
                color: '#F0DB0B',
                align: 'center',
                y: 0,
            },
            tooltip: {
                valueSuffix: ' €',
				pointFormat: '<span style="color:{point.color}">■ par tonne </span>: <b>{point.y}</b></span><br/>',
             },
			zIndex: 1,
			//data: [0,10]
		}] 
	});
//******chart 6 prix moyen******************************************************************************
	chart6 = new Highcharts.Chart({
		chart: {
			renderTo: 'prix_moyen_histo',
		},
		title: {
			text: 'Historique prix moyen en France',
	        align: 'left',
	        x: 65,
			style:{
				color: '#4572A7',
			},
		},
		legend: {
			enabled: false,
		},
		xAxis: {
			type: 'datetime',
			  labels: {
				formatter: function() {
				  return Highcharts.dateFormat('%d/%m/%Y', this.value);
				}
			  }
			// dateTimeLabelFormats: { 
				// month: '%d. %b',
				// year: '%b'
			// }
		 },
		yAxis: {
			gridLineColor: '#CACACA', 
			labels: {
				format: '{value}€',
				style: {
					color: '#4572A7',
				}
			},
		   title: {
				text: '',
			},
		},
		tooltip: {
	        shared: true,
			crosshairs: true,
			borderRadius: 6,
			borderWidth: 1,
			valueSuffix: '',
			xDateFormat: '%A %d %B %Y',
			valueSuffix: ' €',
		 },
		plotOptions: {
			series: {
                lineWidth: 1.5,
				marker: {
					enabled: false
				},
                states: {
                    hover: {
                        enabled: false,
                    }
                },
                connectNulls: false,
			}
		},

		series: [{
			name: 'prix à la tonne',
			type: 'line',
			color: '<?php echo $color_TdepD; ?>',
			zIndex: 1,
			data: []
			// data: []
		}] 
	});
//***************************************************************************************************
//***************************************************************************************************
//*************affichage bulle conso moyenne*********************************************************
chart1.renderer.label("<?php echo chart4_consum_avg; ?> <?php echo $mois[2];?><br> = <?php echo $consoMoy[2];?> kg/<?php echo text_consum_day;?>",150, 10)
	.attr({
		fill: '#DBEDFF',
		stroke: '<?php echo $color_gran; ?>',
		zIndex: 10,
		r: 20,
		padding: 8,
		width: 120,
		'stroke-width': 2,
	})
	.add()
	.shadow(true);
chart1.renderer.label("<?php echo chart4_consum_avg; ?> <?php echo $mois[1];?><br> = <?php echo $consoMoy[1];?> kg/<?php echo text_consum_day;?>",300, 10)
	.attr({
		fill: '#DBEDFF',
		stroke: '<?php echo $color_gran; ?>',
		zIndex: 10,
		r: 20,
		width: 120,
		padding: 8,
		'stroke-width': 2,
	})
	.add()
	.shadow(true);
	
chart1.renderer.label("<?php echo chart4_consum_avg; ?> <?php echo $mois[0];?><br> = <?php echo $consoMoy[0];?> kg/<?php echo text_consum_day;?>",450, 10)
	.attr({
		fill: '#DBEDFF',
		stroke: '<?php echo $color_gran; ?>',
		zIndex: 10,
		r: 20,
		width: 120,
		padding: 8,
		'stroke-width': 2,
	})
	.add()
	.shadow(true);
	
// **** affichage point information*****
chart1.renderer.image('img/help-icon.png', 50, 10, 40, 40)
	.attr('id','info')
	.add()
	.on('mouseover', function () {
		$('#courbe').slideDown();
	})
	.on('mouseout', function () {
		$('#courbe').slideUp();
	});
	
// **** affichage icone euro*****
var mode = 'Kg';
chart1.renderer.image('img/kilo-icon.png', 100, 10, 40, 40)
	.attr('id','euroKilo')
	.on('click', function () {
		if ( mode == 'Kg'){
			chart1.series[0].setVisible(false); //kilo
			chart1.series[2].setVisible(true); //euro
			$('#euroKilo').attr('href', 'img/euro-icon.png');
			mode = '€';
		} else {
			chart1.series[0].setVisible(true); //kilo
			chart1.series[2].setVisible(false); //euro
			$('#euroKilo').attr('href', 'img/kilo-icon.png');
			mode = 'Kg';
		}			
	})
	.on('mouseover', function () {
		$('#euroKilo').attr({cursor: 'pointer'});
	})
	.add();
	
//***************************************************************************************************
// ************* chargement asynchrone des graphes****************************************************
    chart1.showLoading('loading');
    chart2.showLoading('Cliquez sur une colonne ci dessus pour afficher le détail des courbes ici')
    chart3.showLoading('loading');
    chart4.showLoading('loading');
    chart5.showLoading('loading');
    chart6.showLoading('loading');

// *******graphique conso 90jours*********************
    $.ajax({
        dataType: "json",
        url: 'json_conso_90j.php',
        cache: false,
        success: function(data) {
				 // console.log(data[0]);
			chart1.series[0].setData(data[0],false); //kg
			chart1.series[1].setData(data[1],false); //temp
			chart1.series[2].setData(data[2],false); //euro
			chart1.series[2].setVisible(false); //euro

			chart1.redraw();
            chart1.hideLoading();
        }
    });

// *******graphique conso annuelle*********************
    $.ajax({
        dataType: "json",
        url: 'json_conso_annees.php',
        cache: false,
        success: function(objet) {
            // est un objet  , il est créé dans json_conso_annees.php
            //il contient des objet serie, les paires sont les temperatures et impaires les granulés
			var CumulMois = [0,0,0,0,0,0,0,0,0,0,0,0];
			var MoyMois = [0,0,0,0,0,0,0,0,0,0,0,0];
			for (var i = 0; i < objet.length; i=i+2){
				//console.log(objet[i].data);
				var saison = objet[i].name;
				var quantite = objet[i].somme;
				var cout = Math.round(objet[i].prix*quantite);
				chart3.series[0].addPoint([saison,quantite]);
				chart3.series[1].addPoint([saison,cout]);
                chart4.addSeries(objet[i],false);
                chart4.addSeries(objet[i+1],false);
				chart5.series[0].addPoint([saison,objet[i].prix*1000]);
				for (var j = 0; j < 12; j=j+1){ // on cumul la conso par mois( tous les mois de janvier ...)
					CumulMois[j] = CumulMois[j] + objet[i].data[j];
				}
			}
			for (var j = 0; j < 12; j=j+1){ // calcul de la moyenne de chaque mois de toutes les saisons
				MoyMois[j] = Math.round(CumulMois[j] / ((objet.length+1)/2));// nombre saison
			console.log(MoyMois[j]);
			}
            chart4.addSeries({ // serie moyenne
				type: 'line',
				step: 'center',
				name: '<?php echo chart4_consum_avg; ?>',
				lineWidth: 2,
				lineColor: 'black',
				color: 'black',
				data: MoyMois,
				marker: {
					enabled: false,
					lineWidth: 2,
					lineColor: 'black',
					fillColor: 'black'
				}
			},false);
			
			
			chart3.redraw();
            chart4.redraw();
			chart3.xAxis[0].update({ // affiche les category apres le graph sinon bug d'affichage
				visible: true
				});
			chart5.xAxis[0].update({ // affiche les category apres le graph sinon bug d'affichage
				visible: true
				});
            chart3.hideLoading();
            chart4.hideLoading();
            chart5.hideLoading();
        }
    });

// *******graphique prix moyen en France*********************
    $.ajax({
		method: 'POST',
        dataType: "json",
        url: 'json_stat.php',
		data: {request:"prix_moyen"},
        cache: false,
        success: function(objet) {
			for (var i = 0; i < objet.length; i=i+1){
				var date = objet[i].Date;
				var prix = objet[i].Data;
				var dateT = new Date(date).getTime();//convert to timestamp
				chart6.series[0].addPoint([dateT,prix]);
			}
            chart6.hideLoading();
        }
    });

// *******tableau Température mini enregistrée***************
    $.ajax({
		method: 'POST',
		data: {request:"Tmin"},
        dataType: "json",
        url: 'json_stat.php',
        cache: false,
        success: function(objet) {
            // est un objet  , il est créé dans json_stat.php
			compteur = Object.keys(objet).length;
			for (i=0;i<compteur;i++){
				var date1 = new Date(objet[i].Date).toLocaleDateString("fr"); // transforme YYYY-MM-DD hh:mm:ss en DD/MM/YYYY
				var date2 = date1.split("/");
				var date = date2[0] +'-'+ date2[1] +'-'+ date2[2];// transforme DD/MM/YYYY en DD-MM-YYYY
				document.getElementById('stat').innerHTML +='\
					<tr>\
						<th>Température minimale enregistrée</th> \
						<th>' + date + '</th> \
						<td>' + objet[i].Data + '°</td>\
					</tr>' ; 
                document.getElementById('loading_temp').className = 'hidden';
			}
        }
    });
// *******tableau Température maxi enregistrée***************
    $.ajax({
		method: 'POST',
		data: {request:"Tmax"},
        dataType: "json",
        url: 'json_stat.php',
        cache: false,
        success: function(objet) {
            // est un objet  , il est créé dans json_stat.php
			compteur = Object.keys(objet).length;
			for (i=0;i<compteur;i++){
				var date1 = new Date(objet[i].Date).toLocaleDateString("fr"); // transforme YYYY-MM-DD hh:mm:ss en DD/MM/YYYY
				var date2 = date1.split("/");
				var date = date2[0] +'-'+ date2[1] +'-'+ date2[2];// transforme DD/MM/YYYY en DD-MM-YYYY
				document.getElementById('stat').innerHTML +='\
					<tr>\
						<th>Température maximale enregistrée</th> \
						<th>' + date + '</th> \
						<td>' + objet[i].Data + '°</td>\
					</tr>' ; 
                document.getElementById('loading_temp').className = 'hidden';
			}
        }
    });
// *******tableau conso granulés max sur une journée***************
    $.ajax({
		method: 'POST',
		data: {request:"Gmax"},
        dataType: "json",
        url: 'json_stat.php',
        cache: false,
        success: function(objet) {
            // est un objet  , il est créé dans json_stat.php
			compteur = Object.keys(objet).length;
			for (i=0;i<compteur;i++){
				var dateM = objet[i].Date;
				var date = dateM.split("-");
				var dateF = date[2] +'-'+ date[1] +'-'+ date[0];// transforme YYYY-MM-DD en DD-MM-YYYY
				document.getElementById('stat').innerHTML +='\
					<tr>\
						<th>Conso maximale granulés par jour</th> \
						<th>' + dateF + '</th> \
						<td>' + objet[i].Data + ' Kg</td>\
					</tr>' ; 
			}
        }
    });
// *******tableau cout moyen ECS***************
    $.ajax({
		method: 'POST',
		data: {request:"ecs"},
        dataType: "json",
        url: 'json_stat.php',
        cache: false,
        success: function(objet) {
            // est un objet  , il est créé dans json_stat.php
			compteur = Object.keys(objet).length;
			for (i=0;i<compteur;i++){
				document.getElementById('stat').innerHTML +='\
					<tr>\
						<th class ="tooltipContainer">\
							<span class="tooltipStatEcs">calculée a partir des mois juin-juillet-aout</span>\
							Consommation ECS moyenne\
						</th> \
						<th>par mois</th> \
						<td>' + objet[i].Data + ' Kg</td>\
					</tr>\
					<tr id="loading_temp">\
						<th class ="tooltipContainer">\
							Recherche  températures...\
						</th> \
						<th>Patientez</th> \
						<td>...</td>\
					</tr>' ; 
			}
        }
    });
});
</script>



