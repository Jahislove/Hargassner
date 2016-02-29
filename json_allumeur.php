<?php
//appelé par ajax, recoit 1 seul channel en parametre et renvoi la serie de data

require_once("conf/config.inc.php");
require_once("conf/connectBDD.inc.php");

	header("Content-type: text/json");

    // $channel = $_GET["channel"];
 
    // $query = "SELECT dateB,c0 FROM data
              // WHERE c0 = '5'
              // GROUP BY DATE(dateB),HOUR(dateB),MINUTE(dateB)
              // ";
    $query1 = "
                select DATE(dateB), SUM(c0) FROM(
                select dateB,c0/5 as c0 from data
                where dateB > DATE_SUB(NOW(), INTERVAL 30 DAY) AND c0 = '5'
                GROUP by DATE(dateB),HOUR(dateB)  
                ) as tmp
                GROUP BY DATE(dateB)";
                
               // WHERE dateB > DATE_SUB(now(), INTERVAL 7 DAY) AND c0 = '5'
              // WHERE dateB > '2016-02-20' AND c0 = '5'
              
    // $query2 = "SELECT dateB,c169/2000 FROM data
               // WHERE dateB > DATE_SUB(now(), INTERVAL 7 DAY) ";

    connectMaBase($hostname, $database, $username, $password);
    $req1 = mysql_query($query1) ;
    // $req2 = mysql_query($query2) ;
	mysql_close();
    
    while($data = mysql_fetch_row($req1)){
        $dateD = strtotime($data[0]) * 1000;
        $liste1[] = [$dateD, $data[1]];
    }
    // while($data = mysql_fetch_row($req2)){
        // $dateD = strtotime($data[0]) * 1000;
        // $liste2[] = [$dateD, $data[1]];
    // }

   echo json_encode($liste1, JSON_NUMERIC_CHECK);
    // $tableau = [$liste1,$liste2];
    // echo json_encode($tableau, JSON_NUMERIC_CHECK);
   
    

?>
