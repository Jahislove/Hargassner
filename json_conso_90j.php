<?php
// appelé par ajax, renvoi les series de data pour toutes les saisons
require_once("conf/config.inc.php");

header("Content-type: text/json");

    // recupere la conso des 90 derniers jours
    $query0 = "SELECT dateB,conso,Tmoy FROM consommation 
            ORDER BY dateB DESC LIMIT 90";
          
    // recupere le prix de la saison en cours
	$query1 = "SELECT * FROM tarif 
			ORDER BY saison DESC LIMIT 1" ;

	$conn = mysqli_connect ($hostname, $username, $password, $database); 
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	$req0 = mysqli_query($conn, $query0);
	$req1 = mysqli_query($conn, $query1);
	mysqli_close($conn);
	

// #########traitement query1######################################################################################
    $data = mysqli_fetch_row($req1);
    $prix = $data[1];

    while($data = mysqli_fetch_row($req0)){
        $dateD = strtotime($data[0]) * 1000;
        // $chart1_data1[] = "[$dateD, $data[1]]";//kg
        // $chart1_data2[] = "[$dateD, $data[2]]";//temperature
		// $cout = round($data[1]*$prix,1,PHP_ROUND_HALF_EVEN);
        // $chart1_data3[] = "[$dateD, $cout]";//cout
        $chart1_data1[] = [$dateD, $data[1]];//kg
        $chart1_data2[] = [$dateD, $data[2]];//temperature
		$cout = round($data[1]*$prix,1,PHP_ROUND_HALF_EVEN);
        $chart1_data3[] = [$dateD, $cout];//cout
    }
    
    // $chart1_data1 = join(',', array_reverse($chart1_data1));
    // $chart1_data2 = join(',', array_reverse($chart1_data2));
    // $chart1_data3 = join(',', array_reverse($chart1_data3));
    $chart1_data1 = array_reverse($chart1_data1);
    $chart1_data2 = array_reverse($chart1_data2);
    $chart1_data3 = array_reverse($chart1_data3);

    $tableau = [$chart1_data1,$chart1_data2,$chart1_data3];
	

	echo json_encode($tableau, JSON_NUMERIC_CHECK);

?>
