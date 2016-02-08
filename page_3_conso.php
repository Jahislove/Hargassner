<?php require("header_debut.php"); ?>
<script type="text/javascript" src="js/call_ajax_light.js">	</script>
<?php require("header_fin.php"); ?>

<p>Date: <input type="text" id="datepicker"></p>
    
<div id="conso" class="page3_duo"></div>
<div id="courbe" class="page3_duo"></div>
<div id="conso_mois" class="page3_duo"></div>

<?php
    $chart1_name = ['Consommation granulés par jour','T° extérieure moyenne'];
    $chart2_name = ['T° départ consigne','T° départ','T° chaudière','T° extérieure','T° intérieure'];
    $chart3_name = ['Consommation granulés par mois','T° extérieure moyenne'];

    // requete
    $query0 = "SELECT dateB,conso,Tmoy FROM consommation 
            ORDER BY dateB DESC LIMIT 60";
    // recupere la 1ere mesure dans la base pour initialiser le calendrier
    $query1 = "SELECT YEAR(dateB),MONTH(dateB) FROM consommation 
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

    $dateMin = mysql_fetch_row($req1);
?>



<?php require("footer.php");?>

<script type="text/javascript">
$(function() {
    $( "#datepicker" ).datepicker({
        monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
        monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
        closeText: 'Fermer',
        prevText: 'Précédent',
        nextText: 'Suivant',
        currentText: 'Aujourd\'hui',
        changeYear: true,
        changeMonth: true,
        dateFormat: 'MM yy',
        showButtonPanel: false,
        maxDate: 0,
        minDate: new Date(<?php echo $dateMin[0]; ?>,<?php echo $dateMin[1]; ?> - 1,1),
        
        // onClose: function() {
            // var iMonth = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            // var iYear = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            // $(this).datepicker('setDate', new Date(iYear, iMonth, 1));
        // },
        onClose: function(dateText, choix) { 
            $(this).datepicker('setDate', new Date(choix.selectedYear, choix.selectedMonth, 1));
            annee = choix.selectedYear;
            mois = choix.selectedMonth + 1;
            // console.log(mois);
            // console.log(annee);
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
        }
       
    });
});

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

//****************************************************************************************************
	chart1 = new Highcharts.Chart({
		chart: {
			renderTo: 'conso',
			zoomType: 'x',
			backgroundColor: '#FBF8EF',
            animation: {
                duration: 1000
            },
			events: {
				//load: requestData // in header.php
			}
		},
	    credits: {
			enabled: false,
		},
		title: {
			text: 'Consommation de granulés par jour',
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
            tooltip: {
                valueSuffix: ' Kg',
             },
			zIndex: 1,
			data: [<?php echo $chart1_data1; ?>]
		}, {
			name: '<?php echo $chart1_name[1]; ?>',
			type: 'line',
			color: '<?php echo $color_TextM; ?>',
            tooltip: {
                valueSuffix: ' °C',
             },
			zIndex: 2,
			data: [<?php echo $chart1_data2; ?>]
		}] 
	});
//****************************************************************************************************
	chart2 = new Highcharts.Chart({
		chart: {
			renderTo: 'courbe',
			zoomType: 'x',
			backgroundColor: '#FBF8EF',
			events: {
				//load: requestData // in header.php
			}
		},
	    credits: {
			enabled: false,
		},
		title: {
			text: 'Courbes des températures',
			style:{
				color: '#4572A7',
			},
		},
		subtitle: {
			text: '',
			style:{
				color: '#4572A7',
			},
		},
		legend: {
			enabled: true,
			backgroundColor: '<?php echo $color_legend; ?>',
			borderRadius: 14,
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
			//min: -20
		},
		tooltip: {
	        shared: true,
			crosshairs: true,
			borderRadius: 6,
			borderWidth: 1,
			valueSuffix: '',
			xDateFormat: '%d %B %H:%M',
		 },
		plotOptions: {
			series: {
				marker: {
					enabled: false
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
		}] 
	});
chart2.showLoading('Cliquez sur le graphe du haut pour afficher le détail')

//****************************************************************************************************
	chart3 = new Highcharts.Chart({
		chart: {
			renderTo: 'conso_mois',
			zoomType: 'x',
			backgroundColor: '#FBF8EF',
			events: {
				//load: requestData // in header.php
			}
		},
	    credits: {
			enabled: false,
		},
		title: {
			text: 'Consommation par mois',
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
			type: 'category',
            categories: ['Septembre', 'Octobre', 'Novembre', 'Decembre','Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin',  'Juillet', 'Aout'],
            //categories: [],
			dateTimeLabelFormats: { // don't display the dummy year
				month: '%d. %b',
				year: '%b'
			}
		 },
		yAxis: [{
			gridLineColor: '#CACACA', 
            endOnTick: false,
			labels: {
				format: '{value} Kg',
				style: {
					color: '#B8AD0E',
				}
			},
		   title: {
				text: '',
			},
		},{
			opposite: true,
            endOnTick: false,
			//min: -20,
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
			//valueSuffix: '',
			//xDateFormat: '%d %B %H:%M',
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
            tooltip: {
                valueSuffix: ' °C',
             },
			zIndex: 2,
			data: []
		}] 
	});
// ************* chargement asynchrone des graphes****************************************************
    chart3.showLoading('loading');

    $.ajax({
        dataType: "json",
        url: 'json_conso_saison.php',
        cache: false,
        success: function(data) {
            //chart3.xAxis[0].setCategories(data[0]);
            chart3.setTitle(null, {text: 'Saison ' + data[2]},false );
            chart3.series[0].setData(data[0],false);
            chart3.series[1].setData(data[1],false);
            chart3.redraw();
            chart3.hideLoading();
        }
    });
    
});
</script>



