<?php
// appelé par ajax, specifique page-2-courbes.php / graphe 1

require_once("conf/config.inc.php");
require_once("conf/connectBDD.inc.php");

	header("Content-type: text/json");

    $channel = $_GET["channel"];
    $periode = $_GET["periode"];
 
    $query = "SELECT dateB,$channel FROM data
              ORDER by dateB DESC LIMIT $periode";
              
	connectMaBase($hostname, $database, $username, $password);
    $req = mysql_query($query) ;
	mysql_close();
    
    $dict = ['','arret','Allumage','Demarrage','Controle allumage','Allumeur','Demarrage combustion','Combustion','Veille','Arret pour decendrage','decendrage','Refroidissement','Nettoyage'];
//    $dict2= [
    while($data = mysql_fetch_row($req)){
        $dateD = strtotime($data[0]) * 1000;
        $liste0['data'][] = [x => $dateD, y => $data[1],valeur => $dict[$data[1]] ];
        if ($data[1] == 9 || $data[1] == 10 || $data[1] == 12){ // zone decendrage
            $liste1['data'][] = [x => $dateD, y => 100,valeur => 'en cours' ];
        }else {
            $liste1['data'][] = [x => $dateD, y => 0,valeur => 'Non' ];
        }
        $liste2[] = [$dateD, $data[2]];
        $liste3[] = [$dateD, $data[3]];
        $liste4[] = [$dateD, $data[4]];
        $liste5[] = [$dateD, $data[5]];
        $liste6[] = [$dateD, $data[6]];
        $liste7[] = [$dateD, $data[7]];
    }

//    $liste0['name'] = 'Etat';  // a utiliser avec un update() en plus du setdata()

    $liste0['data'] = array_reverse($liste0['data']);// est un objet
    $liste1['data'] = array_reverse($liste1['data']); 
    $liste2 = array_reverse($liste2);//liste2... sont des array
    $liste3 = array_reverse($liste3);
    $liste4 = array_reverse($liste4);
    $liste5 = array_reverse($liste5);
    $liste6 = array_reverse($liste6);
    $liste7 = array_reverse($liste7);
    $tableau = [$liste0,$liste1,$liste2,$liste3,$liste4,$liste5,$liste6,$liste7];
    echo json_encode($tableau, JSON_NUMERIC_CHECK);
?>
