<?php require("header_debut.php"); ?>
<script type="text/javascript" src="js/call_ajax_light.js">	</script>
<?php require("header_fin.php"); ?>

<div class="calendar">
    <div class="input-group date">
        <input type="text" class="form-control" placeholder="90 derniers jours">
        <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
    </div>
</div>

<div id="conso" class="graphe_size"></div>
<div id="courbe" class="graphe_size"></div>
<div id="annees" class="graphe_size3"></div>
<div id="conso_annees" class="graphe_size4"></div>

<?php
// pense bete : 
// calcul correction consommation
// conso total / 2.2 = A
// conso reelle / A = X  nouveau facteur Kg/h
// 100 * (X/2.2) = % de correction a apporter en base

    $chart1_name = ['Consommation granulés par jour','T° extérieure moyenne'];
    $chart2_name = ['T° départ consigne','T° départ','T° chaudière','T° extérieure','T° intérieure','Puissance','% bois'];
    $chart3_name = ['Sur la Saison'];

    // requete
    $query0 = "SELECT dateB,conso,Tmoy FROM consommation 
            ORDER BY dateB DESC LIMIT 90";
    // recupere la 1ere mesure dans la base pour initialiser le calendrier
    $query1 = "SELECT YEAR(dateB),MONTH(dateB),FORMAT(AVG(conso),1) FROM consommation 
             LIMIT 1";
			 
    // recupere la conso moyenne des 3 derniers mois
    $query2 = "SELECT MONTH(dateB),FORMAT(AVG(conso),1) FROM consommation 
				GROUP BY YEAR(dateB), MONTH(dateB)           
				ORDER BY dateB DESC LIMIT 3 ";

	$conn = mysqli_connect ($hostname, $username, $password, $database); 
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
    $req0 = mysqli_query($conn, $query0) ;
    $req1 = mysqli_query($conn, $query1) ;
    $req2 = mysqli_query($conn, $query2) ;
	mysqli_close($conn);

    while($data = mysqli_fetch_row($req0)){
        $dateD = strtotime($data[0]) * 1000;
        $chart1_data1[] = "[$dateD, $data[1]]";
        $chart1_data2[] = "[$dateD, $data[2]]";
    }
    
    $chart1_data1 = join(',', array_reverse($chart1_data1));
    $chart1_data2 = join(',', array_reverse($chart1_data2));

    $data = mysqli_fetch_row($req1);
    $dateMin = [$data[0],$data[1]];

	$moisNom = ['','Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin',  'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'];
    while($data = mysqli_fetch_row($req2)){
		$mois[] = $moisNom[$data[0]]; // transformation mois numerique en nom long
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
			months: <?php echo $months; ?>,
			weekdays: <?php echo $weekdays; ?>,
			shortMonths: <?php echo $shortMonths; ?>,
			thousandsSep: <?php echo $thousandsSep; ?>,
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
				load: requestData // in header.php
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
                            chart2.setTitle('',{ text: 'Pour la journée du ' + jour.toLocaleDateString() });
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
			name: '<?php echo $chart1_name[0]; ?>',
			type: 'column',
			color: '<?php echo $color_gran; ?>',
            pointPadding: 0,
            groupPadding: 0.05,
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '8px',
					textOutline: false,
                },
                rotation: 0,
                color: '#F0DB0B',
                align: 'center',
                y: 25,
            },
            tooltip: {
                valueSuffix: ' Kg',
             },
			zIndex: 1,
			data: [<?php echo $chart1_data1; ?>]
		}, {
			name: '<?php echo $chart1_name[1]; ?>',
			type: 'line',
			color: '<?php echo $color_TextM; ?>',
            dataLabels: {
                enabled: true,
                style: {
                    textShadow: true,
                    fontSize: '8px',
					textOutline: false,
					// textOutline: "0px 0px contrast",
                },
                rotation: 0,
                color: '<?php echo $color_TextM; ?>',
                align: 'center',
                y: 25,
            },
            tooltip: {
                valueSuffix: ' °C',
             },
			zIndex: 2,
			data: [<?php echo $chart1_data2; ?>]
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
			text: 'Courbes des températures',
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
			name: '<?php echo $chart2_name[0]; ?>',
			type: 'line',
			color: '<?php echo $color_TdepD; ?>',
			zIndex: 1,
			data: []
		}, {
			name: '<?php echo $chart2_name[1]; ?>',
			type: 'line',
			color: '<?php echo $color_TdepE; ?>',
			zIndex: 2,
			data: []
		}, {
			name: '<?php echo $chart2_name[2]; ?>',
			type: 'line',
			color: '<?php echo $color_Tchaud; ?>',
			zIndex: 2,
			data: []
		}, {
			name: '<?php echo $chart2_name[3]; ?>',
			type: 'line',
			color: '<?php echo $color_Text; ?>',
			zIndex: 2,
			data: []
		}, {
			name: '<?php echo $chart2_name[4]; ?>',
			type: 'line',
			color: '<?php echo $color_Tint; ?>',
			zIndex: 2,
			data: []
		}, {
			name: '<?php echo $chart2_name[5]; ?>',
			type: 'line',
            lineWidth: 1,
			color: '<?php echo $color_puiss; ?>',
			zIndex: 2,
			data: []
		}, {
			name: '<?php echo $chart2_name[6]; ?>',
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
			renderTo: 'annees',
			type: 'column',
			alignThresholds: true,
		},
		legend: {
			enabled: false,
		},
		title: {
			text: 'Consommation annuelle',
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
				colors: ['rgba(230,126,34,1)','rgba(155,89,182,1)','rgba(41,128,185,1)','rgba(46,204,113,1)','rgba(241,196,15,1)','rgba(213,76,60,1)'],
                grouping: false,
                shadow: false,
                borderWidth: 0
            },
		},

		series: [{
			name: '<?php echo $chart3_name[0]; ?>',
			type: 'column',
			// color: '<?php echo $color_gran; ?>',
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
                valueSuffix: ' Kg',
             },
			zIndex: 1,
			//data: [0,10]
		}] 
	});
//*******chart 4 comparaison saison*************************************************************************
	chart4 = new Highcharts.Chart({
		chart: {
			renderTo: 'conso_annees',
			alignThresholds: true,
		},
		title: {
			text: 'Consommation et temperature moyenne par mois',
	        align: 'left',
	        x: 65,
			style:{
				color: '#4572A7',
			},
		},
		subtitle: {
	        align: 'left',
	        x: 65,
			text: 'Pour chaque saison',
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
            categories: ['Septembre', 'Octobre', 'Novembre', 'Decembre','Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin',  'Juillet', 'Aout'],
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
//***************************************************************************************************
//***************************************************************************************************
//*************affichage bulle conso moyenne*********************************************************
chart1.renderer.label('Moyenne <?php echo $mois[2];?><br> = <?php echo $consoMoy[2];?> kg / jour',100, 10)
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
	
chart1.renderer.label('Moyenne <?php echo $mois[1];?><br> = <?php echo $consoMoy[1];?> kg / jour',250, 10)
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
	
chart1.renderer.label('Moyenne <?php echo $mois[0];?><br> = <?php echo $consoMoy[0];?> kg / jour',400, 10)
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
	
chart1.renderer.image('img/help-icon.png', 50, 10, 40, 40)
	.add()
	.on('mouseover', function () {
		$('#courbe').slideDown();
	})
	.on('mouseout', function () {
		$('#courbe').slideUp();
	});
	
// ************* chargement asynchrone des graphes****************************************************
    chart2.showLoading('Cliquez sur une colonne ci dessus pour afficher le détail des courbes ici')
    chart3.showLoading('loading');
    chart4.showLoading('loading');

    $.ajax({
        dataType: "json",
        url: 'json_conso_annees.php',
        cache: false,
        success: function(objet) {
            // est un objet  , il est créé dans json_conso_annees.php
            //il contient des objet serie, les paires sont les temperatures et impaires les granulés
			for (var i = 0; i < objet.length; i=i+2){
				//console.log(objet[i].data);
				var x = objet[i].name;
				var y = objet[i].somme;
				chart3.series[0].addPoint([x,y]);
                chart4.addSeries(objet[i],false);
                chart4.addSeries(objet[i+1],false);
			}
			
			chart3.redraw();
            chart4.redraw();
			chart3.xAxis[0].update({ // affiche les category apres le graph sinon bug d'affichage
				visible: true
				});
            chart3.hideLoading();
            chart4.hideLoading();
        }
    });
});
</script>



