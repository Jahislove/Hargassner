    <?php require_once("conf/config.inc.php");?>
    <?php require_once("conf/connectBDD.inc.php");?>
<?php
	header("Content-type: text/json");

    $channel = $_GET["channel"];
 
    $query = "SELECT dateB,$channel FROM nanoPK
              ORDER by id DESC LIMIT 17280";
              
	connectMaBase($hostname, $database, $username, $password);
    $req = mysql_query($query) ;
	mysql_close();
    
    while($data = mysql_fetch_row($req)){
        $dateD = strtotime($data[0]) * 1000;
        $liste[] = [$dateD, $data[1]];
    }

    echo json_encode(array_reverse($liste), JSON_NUMERIC_CHECK);
    
    

?>
