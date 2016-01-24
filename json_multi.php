<?php

//    pas encore utilisé

require_once("conf/config.inc.php");
require_once("conf/connectBDD.inc.php");

	header("Content-type: text/json");

    $channel = $_GET["channel"];
 
    $query = "SELECT dateB,$channel FROM nanoPK
              ORDER by id DESC LIMIT 17280";
              
	connectMaBase($hostname, $database, $username, $password);
    $req = mysql_query($query) ;
	mysql_close();
    
    while($data = mysql_fetch_row($req)){
        $dateD = strtotime($data[0]) * 1000;
        $liste1[] = [$dateD, $data[1]];
        $liste2[] = [$dateD, $data[2]];
    }

    $liste1 = array_reverse($liste1);
    $liste2 = array_reverse($liste2);
    $tableau = [$liste1,$liste2];
    //echo json_encode(array_reverse($liste), JSON_NUMERIC_CHECK);
    echo json_encode($tableau, JSON_NUMERIC_CHECK);
    
    

?>
