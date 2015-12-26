<!DOCTYPE html>
<html>
<head>
    <title>My nanoPK</title>
    <link rel="icon" type="image/png" href="img/home.png" />
	<link type="text/css" rel="stylesheet" href="css/main.css" />
    <link href='http://fonts.googleapis.com/css?family=Cabin+Condensed' rel='stylesheet' type='text/css'>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="js/jquery-1.11.1.min.js"></script>
    
    <script src="https://code.highcharts.com/highcharts.js"></script>
    

</head>

<body>



<style type="text/css">
#phases3 {
	min-width: 400px;
	height: 800px;
	margin: 0 auto;
}
</style>

<div id="phases3"></div>



<script type="text/javascript">
$(function() {

	$('#phases3').highcharts({
		chart: {
			type: 'line',
			zoomType: 'x',
			backgroundColor: null,
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
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
		yAxis: {
		   title: {
				text: 'toto',
			},
		},
		tooltip: {
			valueSuffix: 'l',
		 },
		plotOptions: {
			series: {
				marker: {
					enabled: false
				},
			}
		},

		series: [{
			name: 'toto',
			data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
		}] 
	});
//****************************************************************************************************
});
</script>



    

	
	
</body>
</html>