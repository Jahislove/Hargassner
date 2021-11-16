<?php require("header_debut.php"); ?>
<script type="text/javascript" src="js/codes_erreurs.js">	</script>
<script type="text/javascript" src="js/call_ajax_light.js">	</script>
<?php require("header_fin.php"); ?>
    
<div class="calendar">
    <div class="input-group date">
        <input type="text" class="form-control" placeholder="Aujourd'hui">
        <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
    </div>
</div>

<?php
	require_once("conf/settings.inc.php");

	// utilise json_chan-period-2.php
    $chart1_name = ['Etat','Décendrage','Puissance','T° chaudiere est','T° chaudiere doit','T° fumée','T° exterieur','O² est','O² doit','Vitesse Extracteur','T° Ballon ECS','% bois','T° exterieur Moy','T° interieur','T° Départ z1 est','T° Départ z1 doit','T° Départ z2 est','T° Départ z2 doit','Conso du jour','Ballon ECS Etat','Aspiration','T° Retour','Temps décendrage']; // etat et decendrage obligatoire , ne pas modifier ces 2 valeurs
	// $chart1_chan = "c0,c0,c134,c3,c4,c5,c6,c1,c2,c53,c27,c56,c7,c138,c21,c23,c22,c24,c99,c92,c112,c12,c111"; // la 2 eme valeur (decendrage) est calculé d'apres c0
    // => remplacé par conf/settings.inc.php
	$chart2_name = ['allumage electrique'];
    
    // requete pour initialiser la date
	$query = "SELECT YEAR(dateB),MONTH(dateB),DAY(dateB) FROM consommation  
             LIMIT 1";
			 
	$conn = mysqli_connect ($hostname, $username, $password, $database); 
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	if ($req = mysqli_query($conn, $query)) {
	   
	} else {
		echo "Error: " . $requete . "<br>" . mysqli_error($conn);
	}
	mysqli_close($conn);

    $data = mysqli_fetch_row($req);
    $dateMin = [$data[0],$data[1],$data[2]];
	
	if (empty($data[0])){
		$dateMin = ['2017','01','01']; 
	}
?>

<div class="rel">
	<div id="graphe_gauge1" class="graphe_gauge graphe_gaugePos1"></div>
	<div id="graphe_gauge2" class="graphe_gauge graphe_gaugePos2"></div>
    <div id="graphe1" class="graphe_size2"></div>
    <div id="graphe2" class="graphe_size"></div>
</div>

<div class="clear"></div>

<?php require("footer.php");?>

<script type="text/javascript">
//*****************fonction tracage graphe pour loading et pickup calendar********************************************************
function parse_data(data) {
	//tracage du graphique
	chart1.series[0].setData(data[0].data,false); //objet : etat
	chart1.series[1].setData(data[1].data,false); //objet : decendrage
	chart1.series[2].setData(data[2],false);// array : puissance
	chart1.series[3].setData(data[3],false);
	chart1.series[4].setData(data[4],false);
	chart1.series[5].setData(data[5],false);
	chart1.series[6].setData(data[6],false);
	chart1.series[7].setData(data[7],false);
	chart1.series[8].setData(data[8],false);
	chart1.series[9].setData(data[9],false);
	chart1.series[10].setData(data[10],false);
	chart1.series[11].setData(data[11],false);
	chart1.series[12].setData(data[12],false);
	chart1.series[13].setData(data[13],false);
	chart1.series[14].setData(data[14],false); // temp Z1 est 
	chart1.series[15].setData(data[15],false); // temp Z1 doit
	chart1.series[16].setData(data[16],false); // temp Z2 est
	chart1.series[17].setData(data[17],false); // temp Z2 doit
	chart1.series[18].setData(data[18],false);
	chart1.series[19].setData(data[19].data,false); //objet
	chart1.series[20].setData(data[20].data,false); //objet
	chart1.series[21].setData(data[21],false);
	chart1.series[22].setData(data[22],false); //temps decendrage
	PuissMoyJour = data[23];
	PuissMoyFonc = data[24];
	// en cas d'ajout penser a incrementer k pour les cookies plus bas

	chart1.redraw();
	chart1.hideLoading();
	
	// tracage des gauges
	document.getElementById('graphe_gauge1').style.visibility="visible";
	document.getElementById('graphe_gauge2').style.visibility="visible";
	graphe_gauge1.series[0].points[0].update(PuissMoyJour);
	graphe_gauge2.series[0].points[0].update(PuissMoyFonc);
	
	dataPuiss = data[2];
};
//********* déclaration des cookies pour stockage visibilité des courbes****************************
//*** creation cookie******
function setCookie(sName, sValue) {
	var today = new Date(), expires = new Date();
	expires.setTime(today.getTime() + (365*24*60*60*1000));
	document.cookie = sName + "=" + encodeURIComponent(sValue) + ";expires=" + expires.toGMTString();
}
//*** lecture cookie******
function getCookie(sName) {
	var cookContent = document.cookie, cookEnd, i, j;
	var sName = sName + "=";
	for(var i=0,c=cookContent.length;i<c;i++) {
	j = i + sName.length;
		if(cookContent.substring(i, j) == sName) {
			cookEnd = cookContent.indexOf(";", j);
			if(cookEnd == -1) {
				cookEnd = cookContent.length;
			}
			return decodeURIComponent(cookContent.substring(j, cookEnd));
		}
	}
	return true;
}
//*** lecture des cookies pour chaque serie et affectation dans une variable*******
var etat = [];
for (var k=0;k<=22;k++) {	
	etat[k] = Boolean(getCookie('hargassner-p2c1-serie'+k)); // transforme la string des cookies en booleen , pour chaque serie
}	


//*****************Calendrier pickup********************************************************
$(function() {
    $( ".input-group.date" ).datepicker({
        format: "DD dd MM yyyy",
        startDate: new Date(<?php echo $dateMin[0]; ?>,<?php echo $dateMin[1]; ?> - 1,<?php echo $dateMin[2]; ?>),
        endDate: new Date(),
        minViewMode: 0,
        daysOfWeekHighlighted: "6,0",
        todayBtn: 'linked',
        language: "fr",
        autoclose: true    
    })
    .on('changeDate', function(e){
			graphe_gauge1.series[0].points[0].update(0);
			graphe_gauge2.series[0].points[0].update(0);
            chart1.showLoading('loading');
            annee = e.format('yyyy');
            mois = e.format('mm');
            jour = e.format('dd');
            $.ajax({
                dataType: "json",
                url: 'json_chan-period-2.php',
                data: 'channel=<?php echo $chart1_chan; ?>' + '&annee=' + annee + '&mois=' + mois + '&jour=' + jour + '&periode=1440',
                cache: false,
                success: function(data) {
					parse_data(data);
                }
            });
    });
});

// definition des graphiques
$(function() {
    // ************* options communes a tous les charts ******************************
    Highcharts.setOptions({
		lang: {
			months: <?php echo $months; ?>,
			weekdays: <?php echo $weekdays; ?>,
			shortMonths: <?php echo $shortMonths; ?>,
			thousandsSep: <?php echo $thousandsSep; ?>,
		},
		global: {
			useUTC: false,
		},
		chart: {
			type: 'line',
			zoomType: 'x',
			backgroundColor: null,
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
				day: '%e %b',
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
			borderRadius: 26,
			borderWidth: 1,
			xDateFormat: '%A %d %b %H:%M:%S',
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
			}
		},
    });

    // *************chart 1 ********************************************
	chart1 = new Highcharts.Chart({
		chart: {
			renderTo: 'graphe1',
			events: {
				load: requestData // in header.php
			},
		},
		title: {
			text: 'Fonctionnement',
		},
		legend: {
            itemDistance: 30,
            itemMarginBottom: 5,
            itemMarginTop: 5,
            //itemWidth: 150,
            //width: 1100,
		},
		xAxis: {
            tickInterval: 15*60*1000,
			events: {
				afterSetExtremes: function(event){ // declenchement en cas de zoom
					// calcul de la puissance moyenne dans le zoom
					var start = Math.ceil(event.min); // valeur mini du zoom
					var end = Math.floor(event.max);  // valeur maxi du zoom
					var cumul = 0;
					var nombre = 0;

					if (this.getExtremes().dataMin < event.min){ // si zoom in
						// parcoure le tableau dataPuiss et fait la moyenne des valeurs uniquement entre les extremes du zoom
						for(var i= 0; i < dataPuiss.length; i++){
							if ((dataPuiss[i][0] > start) && (dataPuiss[i][0] < end)) {
								//console.log(dataPuiss[i][0]);
								cumul = cumul + dataPuiss[i][1];
								nombre++;
							}
						}
						moyenne = Math.round(cumul / nombre);
						graphe_gauge2.setTitle({ text: 'Puissance moyenne zoom'});
						graphe_gauge2.series[0].points[0].update(moyenne);
					}else{ 										//si zoom out
						graphe_gauge2.setTitle({ text: 'Puissance Moy. en Chauffe'});
						graphe_gauge2.series[0].points[0].update(PuissMoyFonc); // on restaure la valeur initiale
					}
				}
			},		
		 },
        plotOptions: {
            series: {
                events: { //memorisation de l'etat visible des courbes
                    legendItemClick: function(event) {
                        var visibility = this.visible ? '' : true; // for boolean => true=true and ''=false
						setCookie('hargassner-p2c1-serie' + this.index, visibility);
                    }
                }
            }
        },
		tooltip: {
			useHTML: true,
			headerFormat: '<small>{point.key}</small><br/><table>',
			pointFormatter: function () {
				 return '<tr><td> <span style="color:' + this.series.color +'">\u25CF </span>' + this.series.name + ' :</td> <td style="text-align: right"><b>' + this.y + '</b></td></tr>';
			},				
			footerFormat: '</table>',
			
			// pointFormatter: function () {
				// if ( this.y == 0){
					// return '';
				// }	
				 // return '<span style="color:' + this.series.color + '">\u25CF </span>' + this.series.name +' : <b>' + this.y + '</b><br/>';
			// },				
			// pointFormatter: function () {
				// if ((this.series.name == 'Aspiration' || this.series.name == 'Décendrage'|| this.series.name == 'Ballon ECS Etat')  && this.y == 0){
					// return '';
				// }else {
					// return '<span style="color:' + this.series.color + '">\u25CF </span>' + this.series.name +' : <b>' + this.y + '</b><br/>';
				// }	
			// },
			
		},

		series: [{
			name: '<?php echo $chart1_name[0]; ?>',
			color: '<?php echo $color_etat; ?>',
            legendIndex: 0,
            visible: etat[0],
            turboThreshold: 1500, // necessaire car serie 1 et 2 sont des objets et pas des array
            tooltip: {
				pointFormatter: function () {
					puce = '<span style=\"color:' + this.series.color +'\">\u25CF </span>';
					return '<tr><td>' + puce + this.series.name + '</td> <td style="text-align: right"><b>' + this.valeur + '</b> ' + puce + '</td></tr>'
				},				
            },
			data: []
		}, {
			name: '<?php echo $chart1_name[1]; ?>',
			color: '<?php echo $color_decend; ?>',
            legendIndex: 17,
            visible: etat[1],
            turboThreshold: 1500,
            type: 'area',
            zIndex: -1,
            tooltip: {
				pointFormatter: function () {
					if ( this.y == 0){
						return '';
					}	
					puce = '<span style=\"color:' + this.series.color +'\">\u25CF </span>';
					return '<tr><td>' + puce + this.series.name + '</td> <td style="text-align: right"><b>' + this.valeur + '</b> ' + puce + '</td></tr>'
				},				
            },
			data: []
		}, {
			name: '<?php echo $chart1_name[2]; ?>',
			color: '<?php echo $color_puiss; ?>',
            lineWidth: 1,
            legendIndex: 1,
            visible: etat[2],
            tooltip: {
				pointFormatter: function () {
					puce = '<span style=\"color:' + this.series.color +'\">\u25CF </span>';
					return '<tr><td>' + puce + this.series.name + '</td> <td style="text-align: right"><b>' + this.y + '</b>&nbsp&nbsp % ' + puce + '</td></tr>'
				},				
             },
			data: []
		}, {
			name: '<?php echo $chart1_name[3]; ?>',
			color: '<?php echo $color_Tchaud; ?>',
            legendIndex: 2,
            visible: etat[3],
            tooltip: {
				pointFormatter: function () {
					puce = '<span style=\"color:' + this.series.color +'\">\u25CF </span>';
					return '<tr><td>' + puce + this.series.name + '</td> <td style="text-align: right"><b>' + this.y + '</b>&nbsp&nbsp °C ' + puce + '</td></tr>'
				},				
             },
			data: []
		}, {
			name: '<?php echo $chart1_name[4]; ?>',
			color: '<?php echo $color_Tchauddoit; ?>',
            legendIndex: 3,
            visible: etat[4],
            tooltip: {
				pointFormatter: function () {
					puce = '<span style=\"color:' + this.series.color +'\">\u25CF </span>';
					return '<tr><td>' + puce + this.series.name + '</td> <td style="text-align: right"><b>' + this.y + '</b>&nbsp&nbsp °C ' + puce + '</td></tr>'
				},				
             },
			data: [],
		}, {
			name: '<?php echo $chart1_name[5]; ?>',
			color: '<?php echo $color_fum; ?>',
            legendIndex: 12,
            visible: etat[5],
            tooltip: {
				pointFormatter: function () {
					puce = '<span style=\"color:' + this.series.color +'\">\u25CF </span>';
					return '<tr><td>' + puce + this.series.name + '</td> <td style="text-align: right"><b>' + this.y + '</b>&nbsp&nbsp °C ' + puce + '</td></tr>'
				},				
             },
			data: [],
		}, {
			name: '<?php echo $chart1_name[6]; ?>',
			color: '<?php echo $color_Text; ?>',
            legendIndex: 10,
            visible: etat[6],
            tooltip: {
				pointFormatter: function () {
					puce = '<span style=\"color:' + this.series.color +'\">\u25CF </span>';
					return '<tr><td>' + puce + this.series.name + '</td> <td style="text-align: right"><b>' + this.y + '</b>&nbsp&nbsp °C ' + puce + '</td></tr>'
				},				
             },
			data: []
		}, {
			name: '<?php echo $chart1_name[7]; ?>',
			color: '<?php echo $color_O2; ?>',
            legendIndex: 13,
            visible: etat[7],
            tooltip: {
				pointFormatter: function () {
					puce = '<span style=\"color:' + this.series.color +'\">\u25CF </span>';
					return '<tr><td>' + puce + this.series.name + '</td> <td style="text-align: right"><b>' + this.y + '</b>&nbsp&nbsp % ' + puce + '</td></tr>'
				},				
            },
			data: []
		}, {
			name: '<?php echo $chart1_name[8]; ?>',
			color: '<?php echo $color_O2doit; ?>',
            legendIndex: 14,
            visible: etat[8],
            tooltip: {
				pointFormatter: function () {
					puce = '<span style=\"color:' + this.series.color +'\">\u25CF </span>';
					return '<tr><td>' + puce + this.series.name + '</td> <td style="text-align: right"><b>' + this.y + '</b>&nbsp&nbsp % ' + puce + '</td></tr>'
				},				
            },
			data: [],
		}, {
			name: '<?php echo $chart1_name[9]; ?>',
			color: '<?php echo $color_extrac; ?>',
            legendIndex: 9,
            visible: etat[9],
            tooltip: {
				pointFormatter: function () {
					puce = '<span style=\"color:' + this.series.color +'\">\u25CF </span>';
					return '<tr><td>' + puce + this.series.name + '</td> <td style="text-align: right"><b>' + this.y + '</b>&nbsp&nbsp % ' + puce + '</td></tr>'
				},				
            },
			data: []
		}, {
			name: '<?php echo $chart1_name[10]; ?>',
			color: '<?php echo $color_ECS_T; ?>',// ECS
            legendIndex: 15,
            visible: etat[10],
            tooltip: {
				pointFormatter: function () {
					puce = '<span style=\"color:' + this.series.color +'\">\u25CF </span>';
					return '<tr><td>' + puce + this.series.name + '</td> <td style="text-align: right"><b>' + this.y + '</b>&nbsp&nbsp °C ' + puce + '</td></tr>'
				},				
             },
			data: []
		}, {
			name: '<?php echo $chart1_name[11]; ?>',
			color: '<?php echo $color_bois; ?>',
            legendIndex: 10,
            visible: etat[11],
            tooltip: {
				pointFormatter: function () {
					puce = '<span style=\"color:' + this.series.color +'\">\u25CF </span>';
					return '<tr><td>' + puce + this.series.name + '</td> <td style="text-align: right"><b>' + this.y + '</b>&nbsp&nbsp % ' + puce + '</td></tr>'
				},				
            },
			data: []
		}, {
			name: '<?php echo $chart1_name[12]; ?>',
			color: '<?php echo $color_TextM; ?>',
            legendIndex: 9,
            visible: etat[12],
            tooltip: {
				pointFormatter: function () {
					puce = '<span style=\"color:' + this.series.color +'\">\u25CF </span>';
					return '<tr><td>' + puce + this.series.name + '</td> <td style="text-align: right"><b>' + this.y + '</b>&nbsp&nbsp °C ' + puce + '</td></tr>'
				},				
             },
			data: []
		}, {
			name: '<?php echo $chart1_name[13]; ?>',
			color: '<?php echo $color_Tint; ?>',
            legendIndex: 10,
            visible: etat[13],
            tooltip: {
				pointFormatter: function () {
					puce = '<span style=\"color:' + this.series.color +'\">\u25CF </span>';
					return '<tr><td>' + puce + this.series.name + '</td> <td style="text-align: right"><b>' + this.y + '</b>&nbsp&nbsp °C ' + puce + '</td></tr>'
				},				
             },
			data: [],
		}, {
			name: '<?php echo $chart1_name[14]; ?>',
			color: '<?php echo $color_TdepE; ?>',
            legendIndex: 4,
            visible: etat[14],
            tooltip: {
				pointFormatter: function () {
					puce = '<span style=\"color:' + this.series.color +'\">\u25CF </span>';
					return '<tr><td>' + puce + this.series.name + '</td> <td style="text-align: right"><b>' + this.y + '</b>&nbsp&nbsp °C ' + puce + '</td></tr>'
				},				
             },
			data: []
		}, {
			name: '<?php echo $chart1_name[15]; ?>',
			color: '<?php echo $color_TdepD; ?>',
            legendIndex: 5,
            visible: etat[15],
            tooltip: {
				pointFormatter: function () {
					puce = '<span style=\"color:' + this.series.color +'\">\u25CF </span>';
					return '<tr><td>' + puce + this.series.name + '</td> <td style="text-align: right"><b>' + this.y + '</b>&nbsp&nbsp °C ' + puce + '</td></tr>'
				},				
             },
			data: [],
		}, {
			name: '<?php echo $chart1_name[16]; ?>',// temp depart Z2 est
			color: '<?php echo $color_varF; ?>',
            legendIndex: 6,
            visible: etat[16],
            tooltip: {
				pointFormatter: function () {
					puce = '<span style=\"color:' + this.series.color +'\">\u25CF </span>';
					return '<tr><td>' + puce + this.series.name + '</td> <td style="text-align: right"><b>' + this.y + '</b>&nbsp&nbsp °C ' + puce + '</td></tr>'
				},				
             },
			data: []
		}, {
			name: '<?php echo $chart1_name[17]; ?>',// temp depart Z2 doit
			color: '<?php echo $color_varK; ?>',
            legendIndex: 7,
            visible: etat[17],
            tooltip: {
				pointFormatter: function () {
					puce = '<span style=\"color:' + this.series.color +'\">\u25CF </span>';
					return '<tr><td>' + puce + this.series.name + '</td> <td style="text-align: right"><b>' + this.y + '</b>&nbsp&nbsp °C ' + puce + '</td></tr>'
				},				
             },
			data: [],
		}, {
			name: '<?php echo $chart1_name[18]; ?>',
			color: '<?php echo $color_gran; ?>',
            legendIndex: 14,
            visible: etat[18],
            tooltip: {
				pointFormatter: function () {
					puce = '<span style=\"color:' + this.series.color +'\">\u25CF </span>';
					return '<tr><td>' + puce + this.series.name + '</td> <td style="text-align: right"><b>' + this.y + '</b>&nbsp&nbsp Kg ' + puce + '</td></tr>'
				},				
             },
			data: [],
		}, {
			name: '<?php echo $chart1_name[19]; ?>',
			color: '<?php echo $color_ECS_etat; ?>',
            legendIndex: 16,
            visible: etat[19],
            turboThreshold: 1500,
            type: 'area',
            zIndex: -1,
            tooltip: {
				pointFormatter: function () {
					if ( this.y == 0){
						return '';
					}	
					puce = '<span style=\"color:' + this.series.color +'\">\u25CF </span>';
					return '<tr><td>' + puce + this.series.name + '</td> <td style="text-align: right"><b>' + this.valeur + ' </b>' + puce + '</td></tr>'
				},				
            },
			data: []
		}, {
			name: '<?php echo $chart1_name[20]; ?>',
			color: '<?php echo $color_aspi; ?>',
            legendIndex: 18,
            visible: etat[20],
            turboThreshold: 1500,
            type: 'area',
            zIndex: -1,
            tooltip: {
				pointFormatter: function () {
					if ( this.y == 0){
						return '';
					}	
					puce = '<span style=\"color:' + this.series.color +'\">\u25CF </span>';
					return '<tr><td>' + puce + this.series.name + '</td> <td style="text-align: right"><b>' + this.valeur + ' </b>' + puce + '</td></tr>'
				},				
			},
			data: []
		}, {
			name: '<?php echo $chart1_name[21]; ?>',
			color: '<?php echo $color_gran; ?>',
            legendIndex: 11,
            visible: etat[21],
            tooltip: {
				pointFormatter: function () {
					puce = '<span style=\"color:' + this.series.color +'\">\u25CF </span>';
					return '<tr><td>' + puce + this.series.name + '</td> <td style="text-align: right"><b>' + this.y + '</b>&nbsp&nbsp °C ' + puce + '</td></tr>'
				},				
             },
			data: [],
		}, {
			name: '<?php echo $chart1_name[22]; ?>',
			color: 'purple',
            legendIndex: 22,
            visible: etat[22],
            tooltip: {
				pointFormatter: function () {
					puce = '<span style=\"color:' + this.series.color +'\">\u25CF </span>';
					return '<tr><td>' + puce + this.series.name + '</td> <td style="text-align: right"><b>' + this.y*4 + '</b>&nbsp&nbsp mn ' + puce + '</td></tr>'
				},				
             },
			data: [],
		}] 
	});
	// *************chart 2 ********************************************
	chart2 = new Highcharts.Chart({
	// $('#graphe2').highcharts({
		chart: {
			renderTo: 'graphe2',
		},
		title: {
			text: 'allumeur electrique',
		},
		xAxis: {
            tickInterval: 24*3600*1000,
		 },
		series: [{
			name: '<?php echo $chart2_name[0]; ?>',
			color: '<?php echo $color_extrac; ?>',
            type: 'column',
            tooltip: {
                shared: true,
                crosshairs: true,
                borderRadius: 26,
                borderWidth: 1,
                valueSuffix: '',
                xDateFormat: '%d %B',
            },
			data: []
		}] 
	});
	
    // *************chart gauge 1 ********************************************
	graphe_gauge1 = new Highcharts.Chart({
	    chart: {
			renderTo: 'graphe_gauge1',
			backgroundColor: null,
			borderWidth: 0,
			borderRadius: 10,
			type: 'gauge',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false,
			animation: {
				duration: 2000,
			},
	    },
		exporting: {
			enabled: false
		},
	    title: {
	        text: 'Puissance Moyenne journée',
			style:{
				fontSize: '10px'
			},
			y: 30,
	    },
	    
	    pane: {
	        startAngle: -120,
	        endAngle: 120,
	        background: [{
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#FFF'],
	                    [1, '#333']
	                ]
	            },
	            borderWidth: 0,
	            outerRadius: '109%'
	        }, {
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#333'],
	                    [1, '#FFF']
	                ]
	            },
	            borderWidth: 1,
	            outerRadius: '107%'
	        }, {
	            // default background
	        }, {
	            backgroundColor: '#DDD',
	            borderWidth: 0,
	            outerRadius: '105%',
	            innerRadius: '103%'
	        }]
	    },
	       
	    // the value axis
	    yAxis: {
	        min: 0,
	        max: 100,
	        
	        minorTickInterval: 'auto',
	        minorTickWidth: 1,
	        minorTickLength: 10,
	        minorTickPosition: 'inside',
	        minorTickColor: '#666',
	
	        tickPixelInterval: 30,
	        tickWidth: 1,
	        tickPosition: 'inside',
	        tickLength: 14,
	        tickColor: '#666',
	        labels: {
                enabled: true,
	            step: 1,
	            rotation: 'auto',
	        	style:{
					fontSize: '8px'
				}
			},
	        title: {
	            text: '%',
				y: 50,
				//align: 'low',
				style:{
					color: '#666',
					fontWeight: 'light',
					fontSize: '12px'
				}
	        },
	        plotBands: [{
	            from: 0,
	            to: 30,
	            color: '#DDDF0D' 
	        }, {
	            from: 30,
	            to: 90,
	            color: '#55BF3B' 
	        }, {
	            from: 90,
	            to: 100,
	            color: 'orange' 
	        }]        
	    },
		tooltip: {
			enabled: false,
		},
		plotOptions: {
			series: {
				dial: {
					// radius: '100%',
					// backgroundColor: 'silver',
					// borderColor: 'black',
					borderWidth: 1,
					baseWidth: 5,
					topWidth: 1,
					baseLength: '20%', // of radius
					// rearLength: '50%'
				},
				dataLabels: {
					enabled: true,
					useHTML: true,
					 // formatter: function(){
						 // return this.y + '<center><img src="./img/battery.jpg"/></br></center>' ;
					 // },
					
					//align: 'left',
					x: 0,
					y: 20,
					//zIndex: 0,
					borderWidth: 0,
					style: {
						fontSize: '12px'
					},
				}
			}
		},			
	    series: [{
	        name: 'PmoyJour',
	        data: [0], 
	    }],
	
	});

    // *************chart gauge 2 ********************************************
	graphe_gauge2 = new Highcharts.Chart({
	    chart: {
			renderTo: 'graphe_gauge2',
			backgroundColor: null,
			borderWidth: 0,
			borderRadius: 10,
			type: 'gauge',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false,
			//width: 180,
			animation: {
				duration: 2000,
			},
	    },
		exporting: {
			enabled: false
		},
	    title: {
	        text: 'Puissance Moy. en Chauffe',
			style:{
				fontSize: '10px'
			},
			y: 30,
	    },
	    
	    pane: {
	        startAngle: -120,
	        endAngle: 120,
	        background: [{
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#FFF'],
	                    [1, '#333']
	                ]
	            },
	            borderWidth: 0,
	            outerRadius: '109%'
	        }, {
	            backgroundColor: {
	                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
	                stops: [
	                    [0, '#333'],
	                    [1, '#FFF']
	                ]
	            },
	            borderWidth: 1,
	            outerRadius: '107%'
	        }, {
	            // default background
	        }, {
	            backgroundColor: '#DDD',
	            borderWidth: 0,
	            outerRadius: '105%',
	            innerRadius: '103%'
	        }]
	    },
	       
	    // the value axis
	    yAxis: {
	        min: 0,
	        max: 100,
	        
	        minorTickInterval: 'auto',
	        minorTickWidth: 1,
	        minorTickLength: 10,
	        minorTickPosition: 'inside',
	        minorTickColor: '#666',
	
	        tickPixelInterval: 30,
	        tickWidth: 1,
	        tickPosition: 'inside',
	        tickLength: 14,
	        tickColor: '#666',
	        labels: {
                enabled: true,
	            step: 1,
	            rotation: 'auto',
	        	style:{
					fontSize: '8px'
				}
			},
	        title: {
	            text: '%',
				y: 50,
				//align: 'low',
				style:{
					color: '#666',
					fontWeight: 'light',
					fontSize: '12px'
				}
	        },
	        plotBands: [{
	            from: 0,
	            to: 30,
	            color: '#DDDF0D' 
	        }, {
	            from: 30,
	            to: 90,
	            color: '#55BF3B' 
	        }, {
	            from: 90,
	            to: 100,
	            color: 'orange' 
	        }]        
	    },
		tooltip: {
			enabled: false,
	        // valueSuffix: ' %',
		},
		plotOptions: {
			series: {
				events: {
					mouseOver: function () {
					bulle = chart1.renderer.label('Faites un zoom sur le <br>graphe pour afficher <br>la puissance moyenne <br>dans le zoom'  ,350, 50);
					bulle.attr({
						fill: '#DBEDFF',
						stroke: '<?php echo $color_gran; ?>',
						zIndex: 15,
						r: 20,
						padding: 8,
						width: 140,
						'stroke-width': 2,
					});
					bulle.add();
					bulle.shadow(true);
					},
					mouseOut: function () {
						bulle.destroy();
					},
				},
				dial: {
					// radius: '100%',
					// backgroundColor: 'silver',
					// borderColor: 'black',
					borderWidth: 1,
					baseWidth: 5,
					topWidth: 1,
					baseLength: '20%', // of radius
					// rearLength: '50%'
				},
				dataLabels: {
					enabled: true,
					useHTML: true,
					 // formatter: function(){
						 // return this.y + '<center><img src="./img/battery.jpg"/></br></center>' ;
					 // },
					
					//align: 'left',
					x: 0,
					y: 20,
					//zIndex: 0,
					borderWidth: 0,
					style: {
						fontSize: '12px'
					},
				}
			}
		},			
	    series: [{
	        name: 'PmoyFonc',
	        data: [0], 
	    }],
	
	});


//****************************************************************************************************
// ************* chargement asynchrone des graphes****************************************************
    // var chart2 = $('#graphe2').highcharts();
    chart1.showLoading('loading');
    chart2.showLoading('loading');
    var d = new Date();
	
    $.ajax({
        dataType: "json",
        url: 'json_chan-period-2.php',
        data: 'channel=<?php echo $chart1_chan; ?>' + '&annee=' + d.getFullYear() + '&mois=' + (d.getMonth()+1) + '&jour=' + d.getDate() + '&periode=1440',
        cache: false,
        success: function(data) {
			parse_data(data);
        }
    });
    
    $.ajax({
        dataType: "json",
        url: 'json_allumeur.php',
        cache: false,
        success: function(data) {
            chart2.series[0].setData(data,false);
            chart2.redraw();
            chart2.hideLoading();
        }
    });
//***************************************************************************************************

});
	
	


</script>



