<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>test</title>
    <link rel="icon" type="image/png" href="img/logo.png" />
	<script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
	<link rel="stylesheet" href="css/main.css" type="text/css"  />
</head>
<div class="rel">
    <div id="graphe1" class="graphe_size2"></div>
</div>
<?php
// MySQL config
$hostname = "192.168.0.222:3307"; //localhost si la BDD est sur la meme machine que le serveur web , sinon IP 3306 MySQL 5 , 3307 MySQL 10
$database = "hargassner"; // nom de la BDD
$username = "hargassner"; // utilisateur mysql
$password = "password";

//*****couleurs (code couleur HTML)************************************************	
$color_TdepD = '#781BE1'; 
$color_TdepE = '#EA7C01';
$color_Tchaud = '#E662CC';
$color_Tchauddoit = '#6F3263';
$color_Text = '#11C4F0';
$color_TextM = '#1930F0'; 
$color_Tint = '#19AF09';
$color_etat = '#01AEE3';
$color_puiss = 'red';
$color_fum = 'black';
$color_O2 = '#01DF01';
$color_O2doit = '#0C750C';
$color_gran = '#108BE0';
$color_aspi = '#1F4AEA';
$color_extrac = '#04E9A4';
$color_varF = '#1F4AEA';
$color_varK = '#E900BB';
$color_regul = '#0040A8';
$color_bois = '#E97E04';
$color_decend = '#AAFFAC';
$color_legend = '#DBEDFF'; 



//  test des valeur les plus interessantes
    $chart1_name = ['0','1','2','3','4','5','6','8','10','11','12','13','14','16','20','21','22','23','24','50','51','63','76','77','78','79']; 
    $chart1_chan = "c0,c1,c2,c3,c4,c5,c6,c8,c10,c11,c12,c13,c14,c16,c20,c21,c22,c23,c24,c50,c51,c63,c76,c77,c78,c79"; 



// requete qui affiche les 1440 dernieres mesures (24h si toutes les mesures sont presentes)
    $query = "SELECT dateB,$chart1_chan FROM data
            ORDER BY dateB DESC  LIMIT 1440";

// ou alors une journée précise 
    // $query = "SELECT dateB,$chart1_chan FROM data
            // WHERE dateB BETWEEN '2017-10-17 00:00:00' AND '2017-10-17  23:59:59'
            // ORDER BY dateB DESC ";
              
$conn = mysqli_connect ($hostname, $username, $password, $database); 
    $req = mysqli_query($conn, $query) ;
	mysqli_close($conn);
    
// pas toucher ci dessous

    while($data = mysqli_fetch_row($req)){
        $dateD = strtotime($data[0]) * 1000;
        $liste0 .= "[". $dateD . "," . $data[1] ."],";
        $liste1 .= "[". $dateD . "," . $data[2] ."],";
        $liste2 .= "[". $dateD . "," . $data[3] ."],";
        $liste3 .= "[". $dateD . "," . $data[4] ."],";
        $liste4 .= "[". $dateD . "," . $data[5] ."],";
        $liste5 .= "[". $dateD . "," . $data[6] ."],";
        $liste6 .= "[". $dateD . "," . $data[7] ."],";
        $liste7 .= "[". $dateD . "," . $data[8] ."],";
        $liste8 .= "[". $dateD . "," . $data[9] ."],";
        $liste9 .= "[". $dateD . "," . $data[10] ."],";
        $liste10 .= "[". $dateD . "," . $data[11] ."],";
        $liste11 .= "[". $dateD . "," . $data[12] ."],";
        $liste12 .= "[". $dateD . "," . $data[13] ."],";
        $liste13 .= "[". $dateD . "," . $data[14] ."],";
        $liste14 .= "[". $dateD . "," . $data[15] ."],";
        $liste15 .= "[". $dateD . "," . $data[16] ."],";
        $liste16 .= "[". $dateD . "," . $data[17] ."],";
        $liste17 .= "[". $dateD . "," . $data[18] ."],";
        $liste18 .= "[". $dateD . "," . $data[19] ."],";
        $liste19 .= "[". $dateD . "," . $data[20] ."],";
        $liste20 .= "[". $dateD . "," . $data[21] ."],";
        $liste21 .= "[". $dateD . "," . $data[22] ."],";
        $liste22 .= "[". $dateD . "," . $data[23] ."],";
        $liste23 .= "[". $dateD . "," . $data[24] ."],";
        $liste24 .= "[". $dateD . "," . $data[25] ."],";
        $liste25 .= "[". $dateD . "," . $data[26] ."],";
    }
?>




<script type="text/javascript">

// definition des graphiques
Highcharts.chart('graphe1', {
		chart: {
			type: 'line',
			renderTo: 'graphe1',
		},
		title: {
			text: 'test',
		},
		legend: {
            itemDistance: 30,
            itemMarginBottom: 5,
            itemMarginTop: 5,
		},
		xAxis: {
			type: 'datetime',
			dateTimeLabelFormats: { 
				day: '%e %b',
			},
		},
		tooltip: {
	        shared: true,
			crosshairs: true,
			borderRadius: 26,
			borderWidth: 1,
            pointFormat: '<span style="color:{point.color}">\u25CF</span> {series.name}: <b>{point.y}</b><br/>',		
			xDateFormat: '%A %d %b %H:%M:%S',
        },
		plotOptions: {
			series: {
                lineWidth: 1,
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
		series: [{
			name: '<?php echo $chart1_name[0]; ?>',
			color: '<?php echo $color_etat; ?>',
            legendIndex: 0,
			data: [<?php echo  $liste0; ?>]
		}, {
			name: '<?php echo $chart1_name[1]; ?>',
			color: '<?php echo $color_decend; ?>',
            zIndex: -1,
			data: [<?php echo  $liste1; ?>]
		}, {
			name: '<?php echo $chart1_name[2]; ?>',
			color: '<?php echo $color_puiss; ?>',
			data: [<?php echo  $liste2; ?>]
		}, {
			name: '<?php echo $chart1_name[3]; ?>',
			color: '<?php echo $color_Tchaud; ?>',
			data: [<?php echo  $liste3; ?>]
		}, {
			name: '<?php echo $chart1_name[4]; ?>',
			color: '<?php echo $color_Tchauddoit; ?>',
			data: [<?php echo  $liste4; ?>]
		}, {
			name: '<?php echo $chart1_name[5]; ?>',
			color: '<?php echo $color_fum; ?>',
			data: [<?php echo  $liste5; ?>]
		}, {
			name: '<?php echo $chart1_name[6]; ?>',
			color: '<?php echo $color_Text; ?>',
			data: [<?php echo  $liste6; ?>]
		}, {
			name: '<?php echo $chart1_name[7]; ?>',
			color: '<?php echo $color_O2; ?>',
			data: [<?php echo  $liste7; ?>]
		}, {
			name: '<?php echo $chart1_name[8]; ?>',
			color: '<?php echo $color_O2doit; ?>',
			data: [<?php echo  $liste8; ?>]
		}, {
			name: '<?php echo $chart1_name[9]; ?>',
			color: '<?php echo $color_extrac; ?>',
			data: [<?php echo  $liste9; ?>]
		}, {
			name: '<?php echo $chart1_name[10]; ?>',
			color: '<?php echo $color_ECS_T; ?>',
			data: [<?php echo  $liste10; ?>]
		}, {
			name: '<?php echo $chart1_name[11]; ?>',
			color: '<?php echo $color_bois; ?>',
			data: [<?php echo  $liste10; ?>]
		}, {
			name: '<?php echo $chart1_name[12]; ?>',
			color: '<?php echo $color_TextM; ?>',
			data: [<?php echo  $liste12; ?>]
		}, {
			name: '<?php echo $chart1_name[13]; ?>',
			color: '<?php echo $color_Tint; ?>',
			data: [<?php echo  $liste13; ?>]
		}, {
			name: '<?php echo $chart1_name[14]; ?>',
			color: '<?php echo $color_TdepE; ?>',
			data: [<?php echo  $liste14; ?>]
		}, {
			name: '<?php echo $chart1_name[15]; ?>',
			color: '<?php echo $color_TdepD; ?>',
			data: [<?php echo  $liste15; ?>]
		}, {
			name: '<?php echo $chart1_name[16]; ?>',
			color: '<?php echo $color_Tint; ?>',
			data: [<?php echo  $liste16; ?>]
		}, {
			name: '<?php echo $chart1_name[17]; ?>',
			color: '<?php echo $color_TdepE; ?>',
			data: [<?php echo  $liste17; ?>]
		}, {
			name: '<?php echo $chart1_name[18]; ?>',
			color: '<?php echo $color_TdepD; ?>',
			data: [<?php echo  $liste18; ?>]
		}, {
			name: '<?php echo $chart1_name[19]; ?>',
			color: '<?php echo $color_TextM; ?>',
			data: [<?php echo  $liste19; ?>]
		}, {
			name: '<?php echo $chart1_name[20]; ?>',
			color: '<?php echo $color_Tint; ?>',
			data: [<?php echo  $liste20; ?>]
		}, {
			name: '<?php echo $chart1_name[21]; ?>',
			color: '<?php echo $color_TdepE; ?>',
			data: [<?php echo  $liste21; ?>]
		}, {
			name: '<?php echo $chart1_name[22]; ?>',
			color: '<?php echo $color_TdepD; ?>',
			data: [<?php echo  $liste22; ?>]
		}, {
			name: '<?php echo $chart1_name[23]; ?>',
			color: '<?php echo $color_Tint; ?>',
			data: [<?php echo  $liste23; ?>]
		}, {
			name: '<?php echo $chart1_name[24]; ?>',
			color: '<?php echo $color_TdepE; ?>',
			data: [<?php echo  $liste24; ?>]
		}, {
			name: '<?php echo $chart1_name[25]; ?>',
			color: '<?php echo $color_TdepD; ?>',
			data: [<?php echo  $liste25; ?>]
		}] 
	});

</script>



