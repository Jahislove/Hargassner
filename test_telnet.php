<?php
$IPchaudiere = "192.168.1.70"; 
$port = 23; 


    $fp = fsockopen ($IPchaudiere, $port, $errno, $errstr);
    if(!$fp){
        echo "$errstr";
    }
    else {
        $reponse=fgets ($fp,1024); //lecture reponse telnet
        fclose($fp);
		echo $reponse;
    }
?>