<?php
// appelé par ajax, specifique page-2-courbes.php / graphe 1

require_once("conf/config.inc.php");
 

	header("Content-type: text/json");

    $channel = $_GET["channel"];
    $mois =  $_GET["mois"];
    $annee =  $_GET["annee"];
    $jour =  $_GET["jour"];
    $periode = $_GET["periode"];
 
    // $query = "SELECT dateB,$channel FROM data
              // ORDER by dateB DESC LIMIT $periode";
    $query = "SELECT dateB,$channel FROM data
            WHERE dateB BETWEEN '".$annee."-".$mois."-".$jour." 00:00:00' AND '".$annee."-".$mois."-".$jour." 23:59:59'
            ORDER BY dateB DESC LIMIT ".$periode;
              
	connectMaBase($hostname, $database, $username, $password);
    $req = mysql_query($query) ;
	mysql_close();
    
    $dict = ['','arret','Allumage','Demarrage','Controle allumage','Allumeur','Demarrage combustion','Combustion','Veille','Arret pour decendrage','decendrage','Refroidissement','Nettoyage'];
    $dict2= ['','0','0','0','0','0','0','0','0','100','100','0','100'];
    $dict3= ['','Non','Non','Non','Non','Non','Non','Non','Non','En attente arrêt','Décendrage','Non','Nettoyage'];
    while($data = mysql_fetch_row($req)){
        $dateD = strtotime($data[0]) * 1000;
        $liste0['data'][] = [x => $dateD, y => $data[1],valeur => $dict[$data[1]] ];
        $liste1['data'][] = [x => $dateD, y => $dict2[$data[2]],valeur => $dict3[$data[2]] ];
        $liste2[] = [$dateD, $data[3]];
        $liste3[] = [$dateD, $data[4]];
        $liste4[] = [$dateD, $data[5]];
        $liste5[] = [$dateD, $data[6]];
        $liste6[] = [$dateD, $data[7]];
        $liste7[] = [$dateD, $data[8]];
        $liste8[] = [$dateD, $data[9]];
        $liste9[] = [$dateD, $data[10]];
        $liste10[] = [$dateD, $data[11]];
        $liste11[] = [$dateD, $data[12]];
        $liste12[] = [$dateD, $data[13]];
        $liste13[] = [$dateD, $data[14]];
        $liste14[] = [$dateD, $data[15]];
        $liste15[] = [$dateD, $data[16]];
        $liste16[] = [$dateD, $data[17]];
    }

	// calcul consommation journaliere a partir de la conso globale
	// valeur de depart
	$init = end($liste16)[1];
	// modifie la liste avec les valeurs calculées
	foreach($liste16 as &$valeur) {  //le & permet de lire puis reecrire la nouvelle valeur
		$valeur = [$valeur[0] , $valeur[1] - $init] ;
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
    $liste8 = array_reverse($liste8);
    $liste9 = array_reverse($liste9);
    $liste10 = array_reverse($liste10);
    $liste11 = array_reverse($liste11);
    $liste12 = array_reverse($liste12);
    $liste13 = array_reverse($liste13);
    $liste14 = array_reverse($liste14);
    $liste15 = array_reverse($liste15);
    $liste16 = array_reverse($liste16);
    $tableau = [$liste0,$liste1,$liste2,$liste3,$liste4,$liste5,$liste6,$liste7,$liste8,$liste9,$liste10,$liste11,$liste12,$liste13,$liste14,$liste15,$liste16];
    echo json_encode($tableau, JSON_NUMERIC_CHECK);
?>
