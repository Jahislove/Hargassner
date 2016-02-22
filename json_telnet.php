
<?php 
// appelé par ajax, permet d'interroger la chaudiere par telnet et retourne la reponse en JSON 
	header("Content-type: text/json");
    require_once("conf/config.inc.php");
    
    //ouverture socket telnet
    $fp = fsockopen ($IPchaudiere, $port, $errno, $errstr);
    if(!$fp){
        echo "$errstr";
    }
    else {
        $reponse=fgets ($fp,1024); //lecture reponse telnet
        fclose($fp);
    }

    $data = explode(" ",$reponse); //transforme la reponse telnet (separateur espace) en array
    
    // verifie le bon format de la reponse
    // pm 0 0 0 0 0 0 ....
    if($data[0] == "pm"){
        $data[0] = time() * 1000; // remplace pm par la date au format javascript (unix *1000)
        echo json_encode($data, JSON_NUMERIC_CHECK);  //numeric_check : remove ""  
    }
?>
