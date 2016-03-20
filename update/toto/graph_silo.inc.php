<script type="text/javascript">
// graphique du silo de la page d'accueil 
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
	chart_silo = new Highcharts.Chart({
		chart: {
			renderTo: 'silo-texte',
			backgroundColor: null,
			type: 'column',
            animation: {
                duration: 2000
            },
		},
	    credits: {
			enabled: false,
		},
        exporting: {
            enabled: false,
        },
	    title: {
	        text: null,
	    },
	    legend: {
	        enabled: false,
	    },
		plotOptions: {
			series: {
                enableMouseTracking: false,
                borderWidth: 0,
                pointWidth: 120,
                dataLabels: {
                    enabled: true,
                    color: 'black',
                    inside: true,
                    formatter: function() {
                        return  this.y  + ' kg'  ;
                    },
                }
			},
            
		},
		xAxis: {
			labels: {
				enabled: false,
			},
		},
		yAxis: {
			min: 0,
            max: <?php echo $taille_silo; ?>,
			gridLineColor: null, 
			labels: {
				enabled: false,
			},
			title: {
				text: null,
			},
		},
	    tooltip: {
            enabled: false,
	    },
		series: [{
			name: '',
			color: 'yellow',
			data: [[0]],
		}]
	});	
});
</script>
