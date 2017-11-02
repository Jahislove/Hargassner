
<?php 
// appelé par ajax, permet d'interroger la chaudiere par telnet et retourne la reponse en JSON 
// pour les anciennes chaudiere ne disposant que du port serie , on remplace le telnet par une interrogation mysql
	header("Content-type: text/json");
    require_once("conf/config.inc.php");

if ($mode_conn == 'serial'){
	$query = "SELECT * FROM data 
			ORDER by id DESC
			LIMIT 1" ;
			  
	connectMaBase($hostname, $database, $username, $password);
	$req = mysql_query($query) ;
	mysql_close();
	
    $data = mysql_fetch_row($req);
    $data[1] = strtotime($data[1]) * 1000;
	array_shift ($data); // supprime le champ id
	
    echo json_encode($data, JSON_NUMERIC_CHECK);  //numeric_check : remove ""  

} else {
    
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
}
	
?>
