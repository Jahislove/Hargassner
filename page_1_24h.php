<?php 
	require("header.php"); 
	require_once("conf/settings.inc.php");
	require_once("conf/firmware.inc.php");
?>
<div id="chart_last24"></div>

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
for (var k=0;k<7;k++) {	
	etat[k] = Boolean(getCookie('hargassner-p1c1-serie'+k)); // transforme la string des cookies en booleen , pour chaque serie
}	

$(document).ready(function(){
//*** definition du graphe ******************************
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
			type: 'line',
			zoomType: 'x',
			backgroundColor: null,
			events: {
				load: requestData('call_ajax_regul') // in header.php
			},
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
                day: '%e %B',
			}
		 },
		yAxis: { //axe 0
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
            plotBands: [{
                color: '#E7FFFF',
                from: 0,
                to: -30,
            }],
            height: 450,
            // top: 160,
		},
		tooltip: {
	        shared: true,
			
			crosshairs: true,
			borderRadius: 6,
			borderWidth: 1,
			// valueSuffix: ' °C',
			xDateFormat: '%e %B %H:%M:%S',
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
                events: { //memorisation de l'etat visible des courbes
                    legendItemClick: function(event) {
                        var visibility = this.visible ? '' : true; // for boolean => true=true and ''=false
						setCookie('hargassner-p1c1-serie' + this.index, visibility);
                    }
                }
			},
		},
	});
//****************************************************************************************************
//*** chargement des données en asynchrone *****************************
	var msg = '\
		Le tableau représente le contenu des données provenant de la chaudière par telnet.\
		En cliquant par exemple sur la première case , cela affiche la courbe correspondant au parametre 0 du telnet (T0) et , normalement, a la colonne 0 de la BDD (c0).\
		Cependant au fil des firmwares , Hargassner a modifier l\'ordre des parametres\
		et la colonne réelle de la BDD ne correspond plus au parametre, donc le nom de la courbe indique le numero du paramètre Telnet et la colonne correspondante en BDD\
		';
    chart_last24.showLoading(msg);

//****************************************************************************************************
//*** clic sur tableau *****************************
    $(".telnetTable").on('click','tbody.id>tr>td',function(){
		if (document.getElementById(this.id).className != 'inactif' ){
			if (document.getElementById(this.id).className == 'select'){
				document.getElementById(this.id).className = '';
				chart_last24.get('t'+this.id).remove();
				if (chart_last24.series.length == 0){
					chart_last24.showLoading(msg);
				};
			} else {
				chart_last24.hideLoading();
				document.getElementById(this.id).className = 'select';
				console.log(this.id);
				$.ajax({
					dataType: "json",
					url: 'json_table_telnet.php',
					data: 'id=' + this.id + '&periode=1440',
					cache: false,
					success: function(object) {
						chart_last24.addSeries(object);
					}
				});
			} 
		}
    });
});
</script>

<div id="telnet_center">
	<table class="telnetTable">
	<tbody class="id">
		<?php
			for($y=0;$y<10;$y++){ // 10 lignes
				echo '<tr>';
				for($i=0;$i<10;$i++){ // 10 colonnes par ligne
					$id = $i+$y*10;
					if ($dict[$id]) {	//recuperation colonne valide dans le dictionnaire firmware				
						echo '<td id="'.$id.'">&nbsp;</td>';
					}else {
						echo '<td id="'.$id.'" class="inactif">&nbsp;</td>';
					}					
				}
				echo '</tr>';
			}
		?>
	</tbody>
	</table>
	<table class="telnetTable">
	<tbody class="id">
		<?php
			for($y=0;$y<10;$y++){
				echo '<tr>';
				for($i=0;$i<10;$i++){
					$id = 100+$i+$y*10;
					if ($dict[$id]) {					
						echo '<td id="'.$id.'">&nbsp;</td>';
					}else {
						echo '<td id="'.$id.'" class="inactif">&nbsp;</td>';
					}					
				}
				echo '</tr>';
			}
		?>
	</tbody>
	</table>
</div>
<?php require("footer.php");?>
