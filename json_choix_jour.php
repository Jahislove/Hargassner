<?php
require_once("conf/config.inc.php");
require_once("conf/connectBDD.inc.php");

	header("Content-type: text/json");

    $param =  $_GET["channel"];
    $jour = date('Y-m-d', $param/1000); # /1000 car le timestamp php est en seconde et javascript en ms
    

$query = "SELECT dateB,c23,c21,c3,c6,m138 FROM nanoPK2
          WHERE dateB BETWEEN '".$jour."' AND '".$jour."' + INTERVAL 1 DAY";

          //WHERE dateB BETWEEN '".$jour." 00:00:00' AND '".$jour." 23:59:59'";


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
    }

    // $liste1 = array_reverse($liste1);
    // $liste2 = array_reverse($liste2);
    // $liste3 = array_reverse($liste3);
    // $liste4 = array_reverse($liste4);
    // $liste5 = array_reverse($liste5);

    $tableau = [$liste1,$liste2,$liste3,$liste4,$liste5];
    echo json_encode($tableau, JSON_NUMERIC_CHECK);
?>
