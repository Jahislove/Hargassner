<?php

// appelé par ajax, reçoit le mois sélectionné dans datepicker en parametre et renvoi les series de data

	require_once("load_cfg.php");
 

	header("Content-type: text/json");
    $mois =  $_GET["mois"];
    $annee =  $_GET["annee"];
    $query = "SELECT dateB,conso,Tmoy FROM consommation 
            WHERE dateB BETWEEN '".$annee."-".$mois."-01' AND '".$annee."-".$mois."-31'
            ORDER BY dateB DESC LIMIT 31";
              
	$conn = mysqli_connect ($hostname, $username, $password, $database); 
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	$req = mysqli_query($conn, $query);
	mysqli_close($conn);
    
    while($data = mysqli_fetch_row($req)){
        $dateD = strtotime($data[0]) * 1000;
        $liste1[] = [$dateD, $data[1]];
        $liste2[] = [$dateD, $data[2]];
    }

    $tableau = [array_reverse($liste1),array_reverse($liste2)];
    echo json_encode($tableau, JSON_NUMERIC_CHECK);
?>
