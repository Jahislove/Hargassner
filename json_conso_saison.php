<?php
require_once("conf/config.inc.php");
require_once("conf/connectBDD.inc.php");

	header("Content-type: text/json");

    $limit = abs(date('n') -8); // formule permettant de commencer en septembre
    $query = "SELECT YEAR(dateB), MONTH(dateB),SUM(conso),FORMAT(AVG(Tmoy),1) FROM consommation 
            GROUP BY YEAR(dateB), MONTH(dateB)
            ORDER BY dateB DESC LIMIT " . $limit;
              
	connectMaBase($hostname, $database, $username, $password);
    $req = mysql_query($query) ;
	mysql_close();

//pre-remplissage avec des null en cas d'année incomplete
$cons = [null,null,null,null,null,null,null,null,null,null,null,null]; // [0,0,0,0,0,0,0,0,0,0,0,0]
$Tmoy = [null,null,null,null,null,null,null,null,null,null,null,null]; // [0,0,0,0,0,0,0,0,0,0,0,0]

// decalage des mois pour debut saison en septembre    
// "Septembre", "Octobre", "Novembre", "Decembre", "Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout"
$mois = ['09' => 0, '10' => 1, '11' => 2, '12' => 3, '1' => 4, '2' => 5, '3' => 6, '4' => 7, '5' => 8, '6' => 9, '7' => 10, '8' => 11];

    while($data = mysql_fetch_row($req)){
        $annee[] = $data[0];
        $cons[$mois[$data[1]]] = $data[2];        
        $Tmoy[$mois[$data[1]]] = $data[3];        
    }
    $saison = $annee[0]." / ".($annee[0] + 1);
    $tableau = [$cons, $Tmoy, $saison];
    echo json_encode($tableau, JSON_NUMERIC_CHECK);
?>
