

<script> 
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
//$(document).ready(function() {
	chart_silo = new Highcharts.Chart({
		chart: {
			renderTo: 'silo-texte',
			backgroundColor: null,
			type: 'column',
            animation: {
                duration: 2000
            },
            events: {
                // load:
                    // function() {
                    // this.renderer.image('./img/Silo-textile-GWTS-XXL2.png',0,0,200,200)
                    // .attr({zIndex: 0})
                    // .add();
                    
                // }
            },
		},
	    credits: {
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
//chart_silo.renderer.circle(50,50,20).attr({zIndex: 10}).add();	
});
</script>
