<?php
// appelé par ajax, reçoit  7 channels en parametre et renvoi les series de data

	require_once("load_cfg.php");

	header("Content-type: text/json");

    $channel = $_GET["channel"];
    $periode = $_GET["periode"];
 
    $query = "SELECT dateB,$channel FROM data
              ORDER by dateB DESC LIMIT $periode";
              
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
        $liste3[] = [$dateD, $data[3]];
        $liste4[] = [$dateD, $data[4]];
        $liste5[] = [$dateD, $data[5]];
        $liste6[] = [$dateD, $data[6]];
        $liste7[] = [$dateD, $data[7]];
    }

    $liste1 = array_reverse($liste1);
    $liste2 = array_reverse($liste2);
    $liste3 = array_reverse($liste3);
    $liste4 = array_reverse($liste4);
    $liste5 = array_reverse($liste5);
    $liste6 = array_reverse($liste6);
    $liste7 = array_reverse($liste7);
    $tableau = [$liste1,$liste2,$liste3,$liste4,$liste5,$liste6,$liste7];
    echo json_encode($tableau, JSON_NUMERIC_CHECK);
	
?>
