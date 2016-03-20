<?php
// appelé par ajax, reçoit 1 journée en parametre et renvoi les series de data
require_once("conf/config.inc.php");
 

	header("Content-type: text/json");

    $param =  $_GET["channel"];
    $jour = date('Y-m-d', $param/1000); # /1000 car le timestamp php est en seconde et javascript en ms
    

$query = "SELECT dateB,c23,c21,c3,c6,c138,c134 FROM data
          WHERE dateB BETWEEN '".$jour."' AND '".$jour."' + INTERVAL 1 DAY";

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

    $tableau = [$liste1,$liste2,$liste3,$liste4,$liste5,$liste6];
    echo json_encode($tableau, JSON_NUMERIC_CHECK);
?>
