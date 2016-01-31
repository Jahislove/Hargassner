<?php
require_once("conf/config.inc.php");
require_once("conf/connectBDD.inc.php");

	header("Content-type: text/json");

    $query = "SELECT dateB,conso,Tmoy FROM consommation ";
              
	connectMaBase($hostname, $database, $username, $password);
    $req = mysql_query($query) ;
	mysql_close();
    
    while($data = mysql_fetch_row($req)){
        $dateD = strtotime($data[0]) * 1000;
        $liste1[] = [$dateD, $data[1]];
        $liste2[] = [$dateD, $data[2]];
    }

    $tableau = [$liste1,$liste2];
    echo json_encode($tableau, JSON_NUMERIC_CHECK);
?>
