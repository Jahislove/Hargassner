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
<div id="conso_mois" class="graphe_size"></div>
<div id="conso_annees" class="graphe_size"></div>

<?php
    $chart1_name = ['Consommation granulés par jour','T° extérieure moyenne'];
    $chart2_name = ['T° départ consigne','T° départ','T° chaudière','T° extérieure','T° intérieure','Puissance'];
    $chart3_name = ['Consommation granulés par mois','T° extérieure moyenne'];

    // requete
    $query0 = "SELECT dateB,conso,Tmoy FROM consommation 
            ORDER BY dateB DESC LIMIT 90";
    // recupere la 1ere mesure dans la base pour initialiser le calendrier
    $query1 = "SELECT YEAR(dateB),MONTH(dateB),FORMAT(AVG(conso),1) FROM consommation 
             LIMIT 1";

	connectMaBase($hostname, $database, $username, $password);
    $req0 = mysql_query($query0) ;
    $req1 = mysql_query($query1) ;
	mysql_close();

    while($data = mysql_fetch_row($req0)){
        $dateD = strtotime($data[0]) * 1000;
        $chart1_data1[] = "[$dateD, $data[1]]";
        $chart1_data2[] = "[$dateD, $data[2]]";
    }
    
    $chart1_data1 = join(',', array_reverse($chart1_data1));
    $chart1_data2 = join(',', array_reverse($chart1_data2));

    $data = mysql_fetch_row($req1);
    $dateMin = [$data[0],$data[1]];
    $consoMoy = $data[2];
?>

<?php require("footer.php");?>
<script type="text/javascript">
//*****************Calendrier pickup********************************************************
$(function() {
    $( ".input-group.date" ).datepicker({
        format: "MM yyyy",
        startDate: new Date(<?php echo $dateMin[0]; ?>,<?php echo $dateMin[1]; ?> - 1,1),
        endDate: "31/12/2099",
        minViewMode: 1,
        language: "fr",
        autoclose: true    
    })
    .on('changeDate', function(e){
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
			useUTC: false
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

//*****chart 1*****************************************************************************************
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
                        click: function () {
                            //alert('Category: ' + this.x );
                            chart2.showLoading('loading');
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
                    textShadow: false,
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
    
//******chart 2***************************************************************************************
	chart2 = new Highcharts.Chart({
		chart: {
			renderTo: 'courbe',
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
			dateTimeLabelFormats: { // don't display the dummy year
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
		}] 
	});

//******chart 3***************************************************************************************
	chart3 = new Highcharts.Chart({
		chart: {
			renderTo: 'conso_mois',
		},
		title: {
			text: 'Consommation par mois',
	        align: 'left',
	        x: 65,
			style:{
				color: '#4572A7',
			},
		},
		subtitle: {
	        align: 'left',
	        x: 65,
			text: ''
		},
		xAxis: {
			type: 'category',
            categories: ['Septembre', 'Octobre', 'Novembre', 'Decembre','Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin',  'Juillet', 'Aout'],
		 },
		yAxis: [{
			gridLineColor: '#CACACA', 
            endOnTick: false,
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
            endOnTick: false,
            max: 40,
			labels: {
				format: '{value} °C',
				style: {
					color: '#72EA01',
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
		}],            
		tooltip: {
	        shared: true,
			crosshairs: true,
			borderRadius: 26,
			borderWidth: 2,
		 },
		plotOptions: {
			series: {
				marker: {
					enabled: true,
				},
                connectNulls: false,
                grouping: false,
			}
		},

		series: [{
			name: '<?php echo $chart3_name[0]; ?>',
			type: 'column',
            pointPlacement: 0,
            pointPadding: 0.1,
			color: '<?php echo $color_gran; ?>',
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                rotation: 0,
                color: '#F0DB0B',
                align: 'center',
                y: 35,
            },
            tooltip: {
                valueSuffix: ' Kg',
             },
			zIndex: 1,
			data: []
		}, {
			name: '<?php echo $chart3_name[1]; ?>',
			type: 'spline',
            pointPlacement: 0,
            pointPadding: 0.3,
            yAxis: 1,
            color: '<?php echo $color_TextM; ?>',
            dataLabels: {
                enabled: true,
                style: {
                    textShadow: false,
                },
                rotation: 0,
                color: '<?php echo $color_TextM; ?>',
                align: 'center',
                y: 0,
            },
            tooltip: {
                valueSuffix: ' °C',
             },
			zIndex: 2,
			data: []
		}] 
	});
//*******chart 4************************************************************************************
	chart4 = new Highcharts.Chart({
		chart: {
			renderTo: 'conso_annees',
			type: 'column',
		},
		colors: ['#108BE0','#19AF09','#04E9A4','#D07705','#E900BB','#E662CC','#1F4AEA','#EA7C01','#11C4F0','#781BE1'],
		title: {
			text: 'Comparaison années précédentes',
	        align: 'left',
	        x: 65,
			style:{
				color: '#4572A7',
			},
		},
		subtitle: {
	        align: 'left',
	        x: 65,
			text: ''
		},
		xAxis: {
			type: 'category',
            categories: ['Septembre', 'Octobre', 'Novembre', 'Decembre','Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin',  'Juillet', 'Aout'],
		 },
		yAxis: {
			gridLineColor: '#CACACA', 
            endOnTick: false,
			labels: {
				format: '{value} Kg',
				style: {
					color: '<?php echo $color_gran; ?>',
				}
			},
		   title: {
				text: '',
			},
		},            
		tooltip: {
	        shared: true,
			crosshairs: true,
			borderRadius: 26,
			borderWidth: 2,
			valueSuffix: ' Kg',
		},
		plotOptions: {
			series: {
				marker: {
					enabled: true,
				},
                connectNulls: false,
                grouping: true,
                pointPadding: 0,
                groupPadding: 0.05,
                borderWidth: 0,
                maxPointWidth: 45,
			}
		},

		series: [] 
	});
//***************************************************************************************************
//***************************************************************************************************
//*************affichage bulle conso moyenne*********************************************************
    chart1.renderer.label('Moyenne : <?php echo $consoMoy; ?> kg/jour',100, 2, 'callout',0,0)
        .attr({
            fill: '#DBEDFF',
            stroke: '<?php echo $color_gran; ?>',
            zIndex: 10,
            r: 20,
            padding: 8,
            'stroke-width': 2,
        })
        .add()
        .shadow(true);
        
// ************* chargement asynchrone des graphes****************************************************
    chart2.showLoading('Cliquez sur le graphe du haut pour afficher le détail')
    chart3.showLoading('loading');
    chart4.showLoading('loading');

    $.ajax({
        dataType: "json",
        url: 'json_conso_saison.php',
        cache: false,
        success: function(data) {
            chart3.setTitle(null, {text: 'Saison ' + data[2]},false );
            chart3.series[0].setData(data[0],false);
            chart3.series[1].setData(data[1],false);
            chart3.redraw();
            chart3.hideLoading();
        }
    });

    $.ajax({
        dataType: "json",
        url: 'json_conso_annees.php',
        cache: false,
        success: function(data) {
            //for (var i = 0, len = data.length; i < len; i++){
            for (var i = 0; i < data.length; i++){
                chart4.addSeries(data[i],false);
            }
            chart4.redraw();
            chart4.hideLoading();
        }
    });
    
});
</script>



