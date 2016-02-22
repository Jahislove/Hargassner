<?php
// appelé par ajax, reçoit jusque 6 channels en parametre et renvoi les series de data

require_once("conf/config.inc.php");
require_once("conf/connectBDD.inc.php");

	header("Content-type: text/json");

    $channel = $_GET["channel"];
    $periode = $_GET["periode"];
 
    $query = "SELECT dateB,$channel FROM nanoPK
              ORDER by dateB DESC LIMIT $periode";
              
	connectMaBase($hostname, $database, $username, $password);
    $req = mysql_query($query) ;
	mysql_close();
    
    while($data = mysql_fetch_row($req)){
        $dateD = strtotime($data[0]) * 1000;
        $liste1[] = [$dateD, $data[1]];
        $liste2[] = [$dateD, $data[2]];
        $liste3[] = [$dateD, $data[3]];
        $liste4[] = [$dateD, $data[4]];
        $liste5[] = [$dateD, $data[5]];
        $liste6[] = [$dateD, $data[6]];
    }

    $liste1 = array_reverse($liste1);
    $liste2 = array_reverse($liste2);
    $liste3 = array_reverse($liste3);
    $liste4 = array_reverse($liste4);
    $liste5 = array_reverse($liste5);
    $liste6 = array_reverse($liste6);
    $tableau = [$liste1,$liste2,$liste3,$liste4,$liste5,$liste6];
    echo json_encode($tableau, JSON_NUMERIC_CHECK);
?>
