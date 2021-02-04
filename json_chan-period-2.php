<?php
// appelé par ajax, specifique page-2-courbes.php / graphe 1

//echo '<script>console.log('.$variable.')</script>';
// print_r($monarray); affichage array

require_once("conf/config.inc.php");

	header("Content-type: text/json");

    $channel = $_GET["channel"];
    $mois =  $_GET["mois"];
    $annee =  $_GET["annee"];
    $jour =  $_GET["jour"];
    $periode = $_GET["periode"];
 
    // $channel = "c0,c0,c134,c3,c4,c5,c6,c1,c2,c53,c27,c56,c7,c138,c21,c23,c22,c24,c99,c92,c112,c12";
    // $mois =  "10";
    // $annee =  "2020";
    // $jour =  "2";
    // $periode = "2";

    $query = "SELECT dateB,$channel FROM data
            WHERE dateB BETWEEN '".$annee."-".$mois."-".$jour." 00:00:00' AND '".$annee."-".$mois."-".$jour." 23:59:59'
            ORDER BY dateB DESC LIMIT ".$periode;
              
	$conn = mysqli_connect ($hostname, $username, $password, $database); 
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	$req = mysqli_query($conn, $query);
	mysqli_close($conn);
    
    // $dict = ['','arret','Allumage','Demarrage','Controle allumage','Allumeur','Demarrage combustion','Combustion','Veille','Arret pour decendrage','decendrage','Refroidissement','Nettoyage'];
    // $dict2= ['','0','0','0','0','0','0','0','0','100','100','0','100'];
    // $dict3= ['','Non','Non','Non','Non','Non','Non','Non','Non','En attente arrêt','Décendrage','Non','Nettoyage'];
    $dict = ['null','Arrêt','Allumage','Démarrage','Contrôle allumage','Allumeur','Démarrage combustion','Combustion','Veille','Arrêt pour décendrage','décendrage','Refroidissement','Nettoyage','inconnu','inconnu','inconnu','inconnu','Assistant de combustion'];
    $dict2= ['0','0','0','0','0','0','0','0','0','100','100','0','100'];
    $dict3= ['null','Non','Non','Non','Non','Non','Non','Non','Non','En attente arrêt','Décendrage','Non','Nettoyage'];
	$dict4= ['0','100','50']; // ballon ECS off/on/recyclage
	$dict5= ['Arrêt','En chauffe','Recyclage']; // ballon ECS on/off
	
	
	$prev = 1;
    $listePmoyFonc[]= '';
	while($data = mysqli_fetch_row($req)){
		$dateD = strtotime($data[0]) * 1000;
        $liste0['data'][] = ["x" => $dateD, "y" => $data[1],"valeur" => $dict[$data[1]] ];
        $liste1['data'][] = ["x" => $dateD, "y" => $dict2[$data[2]],"valeur" => $dict3[$data[2]] ];
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
        $liste17[] = [$dateD, $data[18]];// conso
        $liste18[] = [$dateD, $data[19]];
        $liste19['data'][] = ["x" => $dateD, "y" => $dict4[intval($data[20])],"valeur" => $dict5[intval($data[20])] ];
		// $liste20
		// il n'existe pas de parametre pour detecter l'aspiration
		// mais il existe un compteur de tour de vis qui repasse a zero lors d'une aspi
		// le but est detecter cette remise a zero
        // calcul changement d'etat quand le compteur c112 passe a zero
		// les valeurs etant lu en SENS INVERSE :
		if ( $data[21] > 0 and $prev == 0) { // quand le compteur est superieur a zero et que la valeur precedente etait zero alors on detecte un changement d'etat
			$liste20['data'][] = ["x" => $dateD, "y" => 100,"valeur" => 'Marche' ];
			$prev = $data[21];
			$pointeur = 1;
		}elseif ( $pointeur == 1){ // une pointe de courbe de 1mn etant trop fine pour le graphique, on ajoute une 2 eme minute
			$liste20['data'][] = ["x" => $dateD, "y" => 100,"valeur" => 'Marche' ];
			$prev = $data[21];
			$pointeur = 0;
		}else { // dans tous les autres cas : pas d'aspi
			$liste20['data'][] = ["x" => $dateD, "y" => 0,"valeur" => 'Arrêt' ]; 
			$prev = $data[21];
		}
		$liste21[] = [$dateD, $data[22]];
		$liste22[] = [$dateD, $data[23]/4];
		
		//pour calcul puissance moyenne on n'utilise que la periode ou "chaudiere doit" est > 0 
		if ( $data[5] > 0 ) {  
			$listePmoyFonc[] = $data[3];
		}
    }
	
	
	// calcul consommation journaliere a partir de la conso globale
	// valeur de depart
	$init = end($liste18)[1];
	// modifie la liste avec les valeurs calculées
	foreach($liste18 as &$valeur) {  //le & permet de lire puis reecrire la nouvelle valeur
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
    $liste17 = array_reverse($liste17);
    $liste18 = array_reverse($liste18);
    $liste19['data'] = array_reverse($liste19['data']);// est un objet
    $liste20['data'] = array_reverse($liste20['data']);// est un objet
	$liste21 = array_reverse($liste21);
	$liste22 = array_reverse($liste22);

	//calcul puissance moyenne sur la journee
	$Pmoy2 = array_sum(array_column($liste2, 1))/count(array_column($liste2, 1));
	$PmoyJour = round($Pmoy2, 0);
	//calcul puissance moyenne en fonctionnement (chaudiere doit)
	$Pmoy3 = array_sum($listePmoyFonc)/count($listePmoyFonc);
	$PmoyFonc = round($Pmoy3, 0);
	
	
    $tableau = [$liste0,$liste1,$liste2,$liste3,$liste4,$liste5,$liste6,$liste7,$liste8,$liste9,$liste10,$liste11,$liste12,$liste13,$liste14,$liste15,$liste16,$liste17,$liste18,$liste19,$liste20,$liste21,$liste22,$PmoyJour,$PmoyFonc];
    echo json_encode($tableau, JSON_NUMERIC_CHECK);
?>
