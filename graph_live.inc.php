<?php
// graphique temps reel de la page d'accueil
// pre-remplissage du chart avec des valeurs null
$listeInit = '';
$x = (time() * 1000);
for ($i = -$histo_live_X; $i < 0; $i++){  //la valeur de $i doit correspondre a celle de la variable histo dans index.php
    $listeInit .= "[($x + $i*1000),null]," ;
} 
?>

<div id="live"></div>

<script type="text/javascript">
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
for (var k=0;k<6;k++) {	
	etat[k] = Boolean(getCookie('hargassner-p0c1-serie'+k)); // transforme la string des cookies en booleen , pour chaque serie
}	

//*********************chart *************************************************		
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
	chart_live = new Highcharts.Chart({
		chart: {
			renderTo: 'live',
			backgroundColor: null,
			defaultSeriesType: 'line',
			zoomType: 'x',
			events: {
				load: requestData, // in header.php
			}
		},
		title: {
			text: 'Courbes temps réel',
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
			min: 0
		},
		tooltip: {
            shadow: false,
	        shared: true,
			crosshairs: true,
			borderRadius: 1,
			borderWidth: 1,
			valueSuffix: '',
			xDateFormat: '%A %e %b  %H:%M:%S',
		 },
		plotOptions: {
			series: {
				marker: {
                    radius: 0,
					enabled: false,
				},
                events: { //memorisation de l'etat visible des courbes
                    legendItemClick: function(event) {
                        var visibility = this.visible ? '' : true; // for boolean => true=true and ''=false
						setCookie('hargassner-p0c1-serie' + this.index, visibility);
                    }
                }
			}
		},

		series: [{
			name: 'etat',
			color: '#01AEE3',
            zIndex: 1,
            visible: etat[0],
			data: [<?php echo $listeInit; ?>],
		}, {
			name: 'T° eau',
			color: '#E662CC',
            tooltip: {
                valueSuffix: ' °',
            },
            visible: etat[1],
            zIndex: 2,
			data: [<?php echo $listeInit; ?>],
		}, {
			name: 'Extraction',
			color: 'yellow',
            visible: etat[2],
			zIndex: 3,
			data: [<?php echo $listeInit; ?>],
		}, {
			name: '% bois',
			zIndex: 4,
            visible: etat[3],
			color: 'grey',
			data: [<?php echo $listeInit; ?>],
		}, {
			name: 'puissance',
			zIndex: 0,
            visible: etat[4],
			color: 'red',
			data: [<?php echo $listeInit; ?>],
		}, {
			name: 'T° départ',
			zIndex: 0,
            visible: etat[5],
			color: 'lightblue',
			data: [<?php echo $listeInit; ?>],
		}]
	});
});
</script>



