<?php
// appelé par ajax, renvoi les series de data pour toutes les saisons
require_once("conf/config.inc.php");

header("Content-type: text/json");

$query = "SELECT YEAR(dateB), MONTH(dateB),SUM(conso),FORMAT(AVG(Tmoy),1) FROM consommation 
        GROUP BY YEAR(dateB), MONTH(dateB)
        ORDER BY dateB " ;
          
connectMaBase($hostname, $database, $username, $password);
$req = mysql_query($query) ;
mysql_close();

// decalage des mois pour debut saison en septembre    
$saison = ['9' => 0, '10' => 1, '11' => 2, '12' => 3, '1' => 4, '2' => 5, '3' => 6, '4' => 7, '5' => 8, '6' => 9, '7' => 10, '8' => 11];

while($data = mysql_fetch_row($req)){
    $annee = $data[0];
    $mois = $data[1];
	
    if ($mois > 8 ){
        if ($serie[$annee] == false){ //pre-remplissage avec des null en cas d'année incomplete
            $serie[$annee] = [null,null,null,null,null,null,null,null,null,null,null,null]; 
            $serieTmoy[$annee] = [null,null,null,null,null,null,null,null,null,null,null,null]; 
        }
        $serie[$annee][$saison[$mois]] = $data[2];
        $serieTmoy[$annee][$saison[$mois]] = $data[3];
    } else{
        if ($serie[$annee-1] == false){ //pre-remplissage avec des null en cas d'année incomplete
            $serie[$annee-1] = [null,null,null,null,null,null,null,null,null,null,null,null]; 
            $serieTmoy[$annee-1] = [null,null,null,null,null,null,null,null,null,null,null,null]; 
        }
        $serie[$annee-1][$saison[$mois]] = $data[2];
        $serieTmoy[$annee-1][$saison[$mois]] = $data[3];
    }
}
$nbre_saison = count($serie);

//preparation des options des series qui sont des sous-objets
$label_gran = ['enabled' => 'True',
			// 'useHTML' => 'True' ,
			'rotation'=> 0,
			// 'color' => '#F0DB0B',
			// 'color' => 'chart4.series[0].color',
			'align' => 'center',
			'y' => 0,
		];
$tooltip_gran = ['valueSuffix' => ' Kg',
				 'pointFormat' => '<span style="color:{point.color}">¤ {series.name}</span>: <span align="right"><b>{point.y}</b></span> / ',
				];
$tooltip_temp = ['valueSuffix' => ' °C',
				 'pointFormat' => '<span style="color:{point.color}">T° moy </span>: <span align="right"><b>{point.y}</b></span><br/>',
				];

//creation des objets serie
// formule pour calculer la position des colonnes (le pointPlacement) en fonction du nombre de saison
$y = -($nbre_saison - 1)*(1/($nbre_saison*2));

$colors_gran = ['rgba(230,126,34,1)','rgba(155,89,182,1)','rgba(41,128,185,1)','rgba(46,204,113,1)','rgba(241,196,15,1)','rgba(213,76,60,1)'];
//$colors_temp = ['rgba(230,126,34,0.5)','rgba(155,89,182,0.5)','rgba(41,128,185,0.5)','rgba(46,204,113,0.5)','rgba(241,196,15,0.5)','rgba(213,76,60,0.5)'];
$j = 0;
foreach($serie as $annee=>$value){
// pointFormat: '<span style="color:{point.color}">\u25CF</span> {series.name}: <span align="right"><b>{point.y}</b></span><br/>',		
	// serie granulés
    $obj[$annee] = ['name'=> ($annee) ."/". ($annee+1) ,
					'type'=> 'column',
					'data'=> $serie[$annee],
					'color' => $colors_gran[$j],
					'dataLabels' => $label_gran,
					'tooltip' => $tooltip_gran,
					// 'pointPadding' => $nbre_saison*0.05+0.1,
					// 'pointPadding' => 0.05,
					// 'pointPlacement' => $y,
					'borderRadius' => 0,
					'somme' => array_sum($serie[$annee]),
					];
    $tableau[] = $obj[$annee];

	// serie temperatures		
    $obj[$annee] = [//'name'=> ($annee) ."/". ($annee+1) ." T° Moy",
					'name'=> ' ',
					'type'=> 'spline',
					'data'=> $serieTmoy[$annee],
					'color' => $colors_gran[$j],
					'dataLabels' => $label_gran,
					'linkedTo' => ':previous',
					'yAxis' => 1,
					'zIndex' => 2,
					'tooltip' => $tooltip_temp,
					// 'pointPadding' => 0.46,
					// 'pointPlacement' => $y,
					];
    $tableau[] = $obj[$annee];
	$j = $j + 1;
	$y = $y + (1 / $nbre_saison);
}

echo json_encode($tableau, JSON_NUMERIC_CHECK);
?>
