<?php
//appelé par ajax, 

require_once("conf/config.inc.php");
 

	header("Content-type: text/json");

    $query1 = "
                select DATE(dateB), SUM(c0) FROM(
                select dateB,c0/5 as c0 from data
                where dateB > DATE_SUB(NOW(), INTERVAL 30 DAY) AND c0 = '5'
                GROUP by DATE(dateB),HOUR(dateB)  
                ) as tmp
                GROUP BY DATE(dateB)";
                

    connectMaBase($hostname, $database, $username, $password);
    $req1 = mysql_query($query1) ;
	mysql_close();
    
    while($data = mysql_fetch_row($req1)){
        $dateD = strtotime($data[0]) * 1000;
        // $dateD = (strtotime($data[0])+ 10000) * 1000;
        $liste1[] = [$dateD, $data[1]];
    }

   echo json_encode($liste1, JSON_NUMERIC_CHECK);
   
    

?>
