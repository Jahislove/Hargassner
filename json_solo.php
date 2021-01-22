<?php
//appelé par ajax, recoit 1 seul channel en parametre et renvoi la serie de data

require_once("conf/config.inc.php");
 

	header("Content-type: text/json");

    $channel = $_GET["channel"];
 
    $query = "SELECT dateB,$channel FROM data
              ORDER by dateB DESC LIMIT 2880";
              
	$conn = mysqli_connect ($hostname, $username, $password, $database); 
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	$req = mysqli_query($conn, $query);
	mysqli_close($conn);
    
    while($data = mysqli_fetch_row($req)){
        $dateD = strtotime($data[0]) * 1000;
        $liste[] = [$dateD, $data[1]];
    }

    echo json_encode(array_reverse($liste), JSON_NUMERIC_CHECK);
    
    

?>
