<?php
// appelé par ajax, renvoi les series de data pour toutes les saisons

require_once("conf/config.inc.php");
require_once("conf/connectBDD.inc.php");

header("Content-type: text/json");

$query = "SELECT YEAR(dateB), MONTH(dateB),SUM(conso),FORMAT(AVG(Tmoy),1) FROM consommation 
        GROUP BY YEAR(dateB), MONTH(dateB)
        ORDER BY dateB " ;
          
connectMaBase($hostname, $database, $username, $password);
$req = mysql_query($query) ;
mysql_close();

// decalage des mois pour debut saison en septembre    
$saison = ['9' => 0, '10' => 1, '11' => 2, '12' => 3, '1' => 4, '2' => 5, '3' => 6, '4' => 7, '5' => 8, '6' => 9, '7' => 10, '8' => 11];

while($data = mysql_fetch_row($req)){
    $annee = $data[0];
    $mois = $data[1];
    if ($mois > 8 ){
        if ($serie[$annee] == false){ //pre-remplissage avec des null en cas d'année incomplete
            $serie[$annee] = [null,null,null,null,null,null,null,null,null,null,null,null]; 
        }
        $serie[$annee][$saison[$mois]] = $data[2];
    } else{
        if ($serie[$annee-1] == false){ //pre-remplissage avec des null en cas d'année incomplete
            $serie[$annee-1] = [null,null,null,null,null,null,null,null,null,null,null,null]; 
        }
        $serie[$annee-1][$saison[$mois]] = $data[2];
    }
}

foreach($serie as $annee=>$value){
    $obj[$annee] = ['name'=> "Saison $annee/".($annee+1), 'data'=> $serie[$annee]];
    $tableau[] = $obj[$annee];
}

echo json_encode($tableau, JSON_NUMERIC_CHECK);
?>
