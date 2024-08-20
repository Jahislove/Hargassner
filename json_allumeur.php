<?php
//appelé par ajax, 

	require_once("load_cfg.php");
 

	header("Content-type: text/json");
                // select DATE(dateB), SUM(c0) FROM(
                // select dateB,c0/5 as c0 from data

    $query = "
                select DATE(dateB), count(c0) FROM(
                select dateB,c0 from data
                where dateB > DATE_SUB(NOW(), INTERVAL 30 DAY) AND c0 = '5'
                GROUP by DATE(dateB),HOUR(dateB)  
                ) as tmp
                GROUP BY DATE(dateB)";

	$conn = mysqli_connect ($hostname, $username, $password, $database); 
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	$req = mysqli_query($conn, $query);
	mysqli_close($conn);
    
    while($data = mysqli_fetch_row($req)){
        $dateD = strtotime($data[0]) * 1000;
        // $dateD = (strtotime($data[0])+ 10000) * 1000;
        $liste1[] = [$dateD, $data[1]];
    }

   echo json_encode($liste1, JSON_NUMERIC_CHECK);
   
    

?>
