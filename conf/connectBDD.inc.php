<?php
// MySQL config
    $hostname = "localhost"; //localhost si la BDD est sur la meme machine que le serveur web , sinon IP
    $database = "Hargassner"; // nom de la BDD
    $username = "hargassner"; // utilisateur mysql
    $password = "ttp2570";

	
// *****************************do not modify below***************************************
// ************* connection to MySQL, **********************************************
    function connectMaBase($hostname, $database, $username, $password){
		$Conn = mysql_connect ($hostname, $username, $password) or trigger_error(mysql_error(),E_USER_ERROR);  
		mysql_select_db($database, $Conn);
    }
?>