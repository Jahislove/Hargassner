<?php
require_once("conf/config.inc.php");
require_once("conf/connectBDD.inc.php");

	header("Content-type: text/json");

    //conso granulés par jour et temp ext moyenne
    // $query = "SELECT DATE(dateB),MAX(m99)-MIN(m99),FORMAT(AVG(c6), 1) FROM nanoPK
              // GROUP BY DATE(dateB)
              // ORDER by dateB DESC LIMIT 30";
    $query = "SELECT dateB,conso,Tmoy FROM consommation ";
              
	connectMaBase($hostname, $database, $username, $password);
    $req = mysql_query($query) ;
	mysql_close();
    
    while($data = mysql_fetch_row($req)){
        $dateD = strtotime($data[0]) * 1000;
        $liste1[] = [$dateD, $data[1]];
        $liste2[] = [$dateD, $data[2]];
    }

    // $liste1 = array_reverse($liste1);
    // $liste2 = array_reverse($liste2);
    $tableau = [$liste1,$liste2];
    echo json_encode($tableau, JSON_NUMERIC_CHECK);
?>
