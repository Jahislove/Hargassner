<?php
// MySQL config : a remplacer par vos parametres
    $hostname = "localhost";
    $database = "Hargassner";
    $username = "hargassner";
    $password = "**********";

	
// *****************************do not modify below***************************************
// ************* connection to MySQL, **********************************************
    function connectMaBase($hostname, $database, $username, $password){
		$Conn = mysql_connect ($hostname, $username, $password) or trigger_error(mysql_error(),E_USER_ERROR);  
		mysql_select_db($database, $Conn);
    }
?>