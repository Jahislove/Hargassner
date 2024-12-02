
<?php 
// licence GPL-3.0-or-later

// appelé par ajax, permet d'interroger la chaudiere par telnet et retourne la reponse en JSON 
// utilisé par la page d'accueil pour mettre a jour l'affichage
// la page d'accueil utilise uniquement le telnet et pas la BDD

// call by ajax , connect to telnet and return a json
// used by home page to update picture
// home page only use telnet  (no mySQL)

// pour les anciennes chaudiere ne disposant que du port serie , on remplace le telnet par une interrogation mysql
//very old boiler use serial port instead of ethernet, so we use mysql instead
	header("Content-type: text/json");
	require_once("load_cfg.php");
	require_once("conf/BDD_description_chanel.php");

if ($mode_conn == 'serial'){ 
    //ouverture port serie , opening serial port
	$query = "SELECT * FROM data 
			ORDER by id DESC
			LIMIT 1" ;
	$conn = mysqli_connect ($hostname, $username, $password, $database); 
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	$req = mysqli_query($conn, $query);
	mysqli_close($conn);
	
    $data = mysqli_fetch_row($req);
    $data[1] = strtotime($data[1]) * 1000;
	array_shift ($data); // remove id
	
} else {
    //ouverture socket telnet , opening socket
    $fp = fsockopen ($IPchaudiere, $port, $errno, $errstr);
    if(!$fp){
        echo "$errstr";
    }
    else {
        $reponse=fgets ($fp,1024); //lecture reponse telnet, read answer
        fclose($fp);
    }
    $data = explode(" ",$reponse); //transforme la reponse telnet (separateur espace) en array, convert answer in array
}

					// remove first useless parameter (pm) so chanel number are same as in database
array_shift($data); // supprime le 1er parametre inutile(pm) pour aligner les numeros de chanels avec la colonne BDD

// le tableau data contient tous les parametres recu par telnet numéroté de 0 à 188+, cet ordre change au fil des firmwares
// le tableau output contient les parametres utilisés par la page d'accueil(fixe)
// on associe un parametre de la page d'acceuil avec le numero du parametre telnet correspondant
// ex ci dessous avec le firmware 10.2h : le parametre puissance correspond au 26eme parametre du telnet

// the array data contain all parameters from the telnet from 0 to 188+, the order change with each firmwares
// the array output contain all parameters used by home page
// so we can say which telnet parameter goes where

//exemple de cheminement pour le 4.3d
//call_ajax.js appelle ce fichier json_telnet.php
//json_telnet.php inverse les parametres en fonction du firmware et il renvoi le resultat dans un tableau $output à call_ajax.js
//call_ajax se sert du tableau pour mofifier les valerus de la page d'acceuil
//par exemple le 20 eme parametre du telnet ($data[20]) est stocké dans l'index 'puissance' du tableau $output
// si les affichages de la page d'acceuil sont erronés c'est donc ici qu'il faut corriger

switch ($firmware) {
    case '4.3d':
		$etat_desc = $ETAT[$data[0]];
		if (!$etat_desc){
			$etat_desc = 'Unknown Status '.$data[0];
		}
		$output = array(
			'heure' 		=> time() * 1000,
			'etat_num' 		=> $data[0],
			'etat_desc' 	=> $etat_desc,
			'lambda'		=> null, 		//O2 sonde lambda
			'puissance' 	=> $data[20],	//puissance
			'extract'		=> $data[12], 	// extracteur de fumée, ou 13 ?
			'Fumee'			=> $data[3],	// temperature fumée
			'chaudiereEst'	=> $data[2],	// temp chaudiere est
			'chaudiereDoit'	=> null,
			'Tint'			=> $data[14]-4,	//temperature interieur , me souvient plus pourquoi il faut retirer 4°C 
			'Text'			=> $data[4],	//temperature exterieur
			'TextMoy'		=> $data[5],	//temperature ext moyenne
			'departEst'		=> $data[6],	//temp depart radiateur est
			'departDoit'	=> $data[8],	//temp depart radiateur doit
			'retourEst' 	=> null,
			'retourDoit'	=> null,
			'bois'			=> $data[16],	// % vis amené granulés ,  ou 56 ?
			'TempECS'		=> $data[10],
			'pompe-ECS'		=> $data[13],
			'tempsDecend'	=> $data[111], 	// temps depuis dernier decendrage auto
			'tempsVis'		=> null,		// temps rotation vis amené
			'mvtGrille' 	=> $data[52],	// nombre mouvement grille
			'PelletConso'	=> null,
			'PelletRest' 	=> $data[115],
			'variableK' 	=> null,
			'variableF' 	=> null,
			'modeChauff'	=> null,  // mode chauffage ( confort, réduit, arret)
			'modeCommand'	=> null,  	//mode de commande => 1:  programmé, 2 reduit forcé, 3 confort forcé, 4 soirée , 5 absence brève
			'consoHeure'	=> $consoHeure, // conso granulé par heure
			'integral'		=> $data,
		);
        break;
    case '10.2h': //chaudiere buche
		$etat_desc = $ETAT[$data[22]];
		if (!$etat_desc){
			$etat_desc = 'Unknown Status '.$data[22];
		}
		$output = array(
			'heure' 	=> time() * 1000,
			'etat_num' 		=> $data[22],
			'etat_desc' 	=> $etat_desc,
			'lambda'	=> $data[2], 	//O2 sonde lambda
			'puissance' => $data[26],
			'extract'	=> $data[46], 	// extracteur de fumée
			'Fumee'		=> $data[1],	// temperature fumée
			'chaudiereEst'=> $data[0],
			'chaudiereDoit'=> $data[27],
			'Tint'		=> $data[80],	//temperature interieur
			'Text'		=> $data[6],	//temperature exterieur
			'TextMoy'	=> $data[59],	//temperature ext moyenne
			'departEst'	=> $data[7],
			'departDoit'=> $data[12],
			'retourEst' => $data[48],
			'retourDoit'=> $data[58],
			'bois'		=> null,		// % vis amené granulés
			'TempECS'	=> $data[11],
			'pompe-ECS'	=> $data[148],
			'tempsDecend'=> $data[120], // temps depuis dernier decendrage auto
			'tempsVis'	=> null,		// temps rotation vis amené
			'mvtGrille' => $data[123],	// nombre mouvement grille
			'PelletConso'=> null,
			'PelletRest' => null,
			'variableK' => null,
			'variableF' => null,
			'modeChauff'=> $data[142],  // mode chauffage ( confort, réduit, arret)
			'modeCommand'=> $data[85],  //mode de commande => 1:  programmé, 2 reduit forcé, 3 confort forcé, 4 soirée , 5 absence brève
			'consoHeure'=> $consoHeure, // conso granulé par heure
			'integral'	=> $data,
		);
        break;
    case '14d': //pellet boiler
    case '14e':
    case '14f':
    case '14g':
		$depart_chauffage = array( 
			'zone1' => ['est' => 21,'doit' => 23], // est = is , doit = must be
			'zone2' => ['est' => 22,'doit' => 24],
			'zone3' => ['est' => 29,'doit' => 31],
		);
		$ballon_ECS = array( 
			'ballon1' => ['est' => 27],
			'ballon2' => ['est' => 35],
			'ballon3' => ['est' => 43],
		);
		$etat_desc = $ETAT[$data[0]];
		if (!$etat_desc){
			$etat_desc = 'Unknown Status '.$data[0];
		}
		$output = array( 
			'heure' 	=> time() * 1000,	//hour
			'etat_num' 		=> $data[0], 	//status
			'etat_desc' 	=> $etat_desc,
			'lambda'	=> $data[1],		//Lambda
			'puissance' => $data[134],		//power
			'extract'	=> $data[53],		//extraction fan
			'Fumee'		=> $data[5],		//smoke temperature
			'chaudiereEst'=> $data[3],		//water boiler temperature is
			'chaudiereDoit'=> $data[4],		//water boiler temperature must be
			'Tint'		=> $data[138],		//inside temperature	
			'Text'		=> $data[6],		//outside temperature
			'TextMoy'	=> $data[7],		//average outside temperature 
			'departEst' => $data[$depart_chauffage[$zone_chauffage]['est']], //start temperature is (to heaters)
			'departDoit'=> $data[$depart_chauffage[$zone_chauffage]['doit']],//start temperature must be
			'retourEst' => $data[15], //return temperature is
			'retourDoit'=> $data[13], //return temperature must be
			'bois'		=> $data[56],		//wood percent
			'TempECS'	=> $data[$ballon_ECS[$zone_ecs]['est']], //domestic hot water temperature
			'pompe-ECS'	=> $data[92], // domestic hot water pump
			'tempsDecend'=> $data[111], // time ash removing
			'tempsVis'	=> $data[112], // time wood screw
			'mvtGrille' => $data[114], // number ash door opening
			'PelletConso'=> $data[99], // kg pellet burned
			'PelletRest' => $data[115], // kg pellet left
			'variableK' => $data[160],
			'variableF' => $data[54],
			'modeChauff'=> $data[85], // heating mode (comfort, reduced,stop)
			'modeCommand'=> $data[101], // heating command (scheduled, reduced forced , comfort forced, short absence)
			'consoHeure'=> $consoHeure, // pellets/hour
			'erreur' 	=> '0', //n'existe pas en 14g => on renvoi 0
			'aspiration'=> $data[185], //mode aspiration pneumatique
			'integral'	=> $data,
		);
        break;
    case '14i':
	case '14j':
	case '14k':
	case '14l':
	case '14m':
		$depart_chauffage = array( 
			'zone1' => ['est' => 56, 'doit' => 57, 'modeChauff' => 60, 'Tint' => 58],
			'zone2' => ['est' => 62, 'doit' => 63, 'modeChauff' => 66, 'Tint' => 64],
			'zone3' => ['est' => 68, 'doit' => 69, 'modeChauff' => 72, 'Tint' => 70],
		);
		$ballon_ECS = array( 
			'ballon1' => ['est' => 95],
			'ballon2' => ['est' => 98],
			'ballon3' => ['est' => 101],
		);
		$mode_chauff = array( 
			'modeChauffageA' => ['modeChauff' => 54],
			'modeChauffage1' => ['modeChauff' => 60],
			'modeChauffage2' => ['modeChauff' => 66],
			'modeChauffage3' => ['modeChauff' => 72],
			'modeChauffage4' => ['modeChauff' => 78],
			'modeChauffage5' => ['modeChauff' => 84],
			'modeChauffage6' => ['modeChauff' => 90],
		);
		
		$etat_desc = $ETAT[$data[0]];
		if (!$etat_desc){
			$etat_desc = 'Unknown Status '.$data[0];
		}

		$output = array(
			'heure' 	=> time() * 1000,
			'etat_num' 		=> $data[0],
			'etat_desc' 	=> $etat_desc,
			'lambda'	=> $data[1],
			'chaudiereEst'=> $data[3],
			'chaudiereDoit'=> $data[4],
			'Fumee'		=> $data[5],
			'extract'	=> $data[6],
			'puissance' => $data[8],
			'bois'		=> $data[9],
			'Tint'		=> $data[$depart_chauffage[$zone_chauffage]['Tint']],
			'Text'		=> $data[15],
			'TextMoy'	=> $data[16],
			'departEst' => $data[$depart_chauffage[$zone_chauffage]['est']],
			'departDoit'=> $data[$depart_chauffage[$zone_chauffage]['doit']],
			'retourEst' => $data[23],
			'retourDoit'=> $data[24],
			'TempECS'	=> $data[$ballon_ECS[$zone_ecs]['est']], 
			'pompe-ECS'	=> $data[97],
			'tempsDecend'=> $data[33],
			'tempsVis'	=> $data[32],
			'mvtGrille' => $data[35],
			'PelletConso'=> $data[47],
			'PelletRest' => $data[46],
			'variableK' => $data[27],
			'variableF' => $data[28],
			'modeChauff'=> $data[$mode_chauff[$zone_mode_chauffage]['modeChauff']],
			'modeCommand'=> $data[61],
			'consoHeure'=> $consoHeure, 
			'erreur' 	=> $data[49], //error code
			'integral'	=> $data,
		);
        break;
	case '14n':
		$depart_chauffage = array( 
			'zone1' => ['est' => 62, 'doit' => 63, 'modeChauff' => 66, 'Tint' => 64],
			'zone2' => ['est' => 68, 'doit' => 69, 'modeChauff' => 72, 'Tint' => 70],
			'zone3' => ['est' => 68, 'doit' => 69, 'modeChauff' => 72, 'Tint' => 70],// n'existe plus en 14n => on pointe sur zone2
		);
		$ballon_ECS = array( 
			'ballon1' => ['est' => 82],
			'ballon2' => ['est' => 82], // n'existe plus en 14n => on pointe sur 82
			'ballon3' => ['est' => 82], // n'existe plus en 14n => on pointe sur 82
		);
		$mode_chauff = array( 
			'modeChauffageA' => ['modeChauff' => 60],
			'modeChauffage1' => ['modeChauff' => 66],
			'modeChauffage2' => ['modeChauff' => 72],
			'modeChauffage3' => ['modeChauff' => 72],// n'existe plus en 14n => on pointe sur 72
			'modeChauffage4' => ['modeChauff' => 72],// n'existe plus en 14n => on pointe sur 72
			'modeChauffage5' => ['modeChauff' => 72],// n'existe plus en 14n => on pointe sur 72
			'modeChauffage6' => ['modeChauff' => 72],// n'existe plus en 14n => on pointe sur 72
		); // pense-bete : a prevoir , suppression des options directement dans la page reglages
		
		$etat_desc = $ETAT[$data[0]];
		if (!$etat_desc){
			$etat_desc = 'Unknown Status '.$data[0];
		}

		$output = array(
			'heure' 	=> time() * 1000,
			'etat_num' 		=> $data[0],
			'etat_desc' 	=> $etat_desc,
			'lambda'	=> $data[1],
			'chaudiereEst'=> $data[3],
			'chaudiereDoit'=> $data[4],
			'Fumee'		=> $data[8],
			'extract'	=> $data[9],
			'puissance' => $data[20],
			'bois'		=> $data[21],
			'Tint'		=> $data[$depart_chauffage[$zone_chauffage]['Tint']],
			'Text'		=> $data[53],
			'TextMoy'	=> $data[54],
			'departEst' => $data[$depart_chauffage[$zone_chauffage]['est']],
			'departDoit'=> $data[$depart_chauffage[$zone_chauffage]['doit']],
			'retourEst' => $data[5],
			'retourDoit'=> $data[6],
			'TempECS'	=> $data[$ballon_ECS[$zone_ecs]['est']], 
			'pompe-ECS'	=> $data[84],
			'tempsDecend'=> $data[37],
			'tempsVis'	=> $data[36],
			'mvtGrille' => $data[39],
			'PelletConso'=> $data[41],
			'PelletRest' => $data[40],
			'variableK' => $data[27],
			'variableF' => $data[28],
			'modeChauff'=> $data[$mode_chauff[$zone_mode_chauffage]['modeChauff']],
			'modeCommand'=> $data[67],
			'consoHeure'=> $consoHeure, 
			'erreur' 	=> $data[30], //error code
			'integral'	=> $data,
		);
        break;
	case 'V14.0HAR.n6'://Modif. by ABR pour une configuration avec ballon Tampon ou j'affiche la charge au lieu température
		$depart_chauffage = array( 
			'zone1' => ['est' => 64, 'doit' => 65, 'modeChauff' => 68, 'Tint' => 66],//Modif. by ABR puis 68
			'zone2' => ['est' => 71, 'doit' => 72, 'modeChauff' => 75, 'Tint' => 73],//c22,c24,c86,c139
			'zone3' => ['est' => 71, 'doit' => 72, 'modeChauff' => 75, 'Tint' => 73],// n'existe plus en 14n => on pointe sur zone2
		);
		$ballon_ECS = array( 
			'ballon1' => ['est' => 14], // fonction selection de reglages ne marche pas on force en 97 devient 14
			'ballon2' => ['est' => 97], // n'existe plus en 14n => on pointe sur 83
			'ballon3' => ['est' => 97], // n'existe plus en 14n => on pointe sur 83
			'ballonTC' => ['est' => 14], // Modif. ABR Température ballon ECS devient charge ballon TP % 97 devient 14

		);
		$mode_chauff = array( 
			'modeChauffageA' => ['modeChauff' => 63],//c84
			'modeChauffage1' => ['modeChauff' => 69],//c85
			'modeChauffage2' => ['modeChauff' => 75],//c86
			'modeChauffage3' => ['modeChauff' => 75],// n'existe plus en 14n => on pointe sur 73
			'modeChauffage4' => ['modeChauff' => 75],// n'existe plus en 14n => on pointe sur 73
			'modeChauffage5' => ['modeChauff' => 75],// n'existe plus en 14n => on pointe sur 73
			'modeChauffage6' => ['modeChauff' => 75],// n'existe plus en 14n => on pointe sur 73
		); // pense-bete : a prevoir , suppression des options directement dans la page reglages
		
		$etat_desc = $ETAT[$data[0]];
		if (!$etat_desc){
			$etat_desc = 'Etat inconnu '.$data[0];
		}

		$output = array(
			'heure' 	=> time() * 1000,
			'etat_num' 		=> $data[0],
			'etat_desc' 	=> $etat_desc,
			'lambda'	=> $data[1],
			'chaudiereEst'=> $data[3],
			'chaudiereDoit'=> $data[4],
			'Fumee'		=> $data[8],
			'extract'	=> $data[9],
			'puissance' => $data[20],
			'bois'		=> $data[21],
			'Tint'		=> $data[$depart_chauffage[$zone_chauffage]['Tint']],
			'Text'		=> $data[55],//Modif. by ABR 54 devient 55
			'TextMoy'	=> $data[56],//Modif.by ABR 55 devient 56
			'departEst' => $data[$depart_chauffage[$zone_chauffage]['est']],
			'departDoit'=> $data[$depart_chauffage[$zone_chauffage]['doit']],
			'retourEst' => $data[5],
			'retourDoit'=> $data[6],
			'TempECS'	=> $data[$ballon_ECS[$zone_ecs]['est']], 
			'pompe-ECS'	=> $data[17],//Modif. by ABR 101 devient 17 pour charge decharge BT 
			'tempsDecend'=> $data[38],
			'tempsVis'	=> $data[37],
			'mvtGrille' => $data[40],
			'PelletConso'=> $data[43],//modif ABR 41 devient 43
			'PelletRest' => $data[42],//modif ABR 40 devient 42
			'variableK' => $data[27],
			'variableF' => $data[28],
			'modeChauff'=> $data[$mode_chauff[$zone_mode_chauffage]['modeChauff']],
			'modeCommand'=> $data[69],//c101 Modif.by ABR 70 devient 69
			'consoHeure'=> $consoHeure, 
			'erreur' 	=> $data[30], //error code
			'integral'	=> $data,
		);
        break;

	case 'V14.0HAR.o':
		$depart_chauffage = array( 
			'zone1' => ['est' => 63, 'doit' => 64, 'modeChauff' => 67, 'Tint' => 65],
			'zone2' => ['est' => 69, 'doit' => 70, 'modeChauff' => 73, 'Tint' => 71],
			'zone3' => ['est' => 69, 'doit' => 70, 'modeChauff' => 73, 'Tint' => 71],// n'existe plus en 14n => on pointe sur zone2
		);
		$ballon_ECS = array( 
			'ballon1' => ['est' => 83],
			'ballon2' => ['est' => 83], // n'existe plus en 14n => on pointe sur 83
			'ballon3' => ['est' => 83], // n'existe plus en 14n => on pointe sur 83
		);
		$mode_chauff = array( 
			'modeChauffageA' => ['modeChauff' => 61],
			'modeChauffage1' => ['modeChauff' => 67],
			'modeChauffage2' => ['modeChauff' => 73],
			'modeChauffage3' => ['modeChauff' => 73],// n'existe plus en 14n => on pointe sur 73
			'modeChauffage4' => ['modeChauff' => 73],// n'existe plus en 14n => on pointe sur 73
			'modeChauffage5' => ['modeChauff' => 73],// n'existe plus en 14n => on pointe sur 73
			'modeChauffage6' => ['modeChauff' => 73],// n'existe plus en 14n => on pointe sur 73
		); // pense-bete : a prevoir , suppression des options directement dans la page reglages
		
		$etat_desc = $ETAT[$data[0]];
		if (!$etat_desc){
			$etat_desc = 'Unknown Status '.$data[0];
		}

		$output = array(
			'heure' 	=> time() * 1000,
			'etat_num' 		=> $data[0],
			'etat_desc' 	=> $etat_desc,
			'lambda'	=> $data[1],
			'chaudiereEst'=> $data[3],
			'chaudiereDoit'=> $data[4],
			'Fumee'		=> $data[8],
			'extract'	=> $data[9],
			'puissance' => $data[20],
			'bois'		=> $data[21],
			'Tint'		=> $data[$depart_chauffage[$zone_chauffage]['Tint']],
			'Text'		=> $data[54],
			'TextMoy'	=> $data[55],
			'departEst' => $data[$depart_chauffage[$zone_chauffage]['est']],
			'departDoit'=> $data[$depart_chauffage[$zone_chauffage]['doit']],
			'retourEst' => $data[5],
			'retourDoit'=> $data[6],
			'TempECS'	=> $data[$ballon_ECS[$zone_ecs]['est']], 
			'pompe-ECS'	=> $data[85],
			'tempsDecend'=> $data[38],
			'tempsVis'	=> $data[37],
			'mvtGrille' => $data[40],
			'PelletConso'=> $data[42],
			'PelletRest' => $data[41],
			'variableK' => $data[27],
			'variableF' => $data[28],
			'modeChauff'=> $data[$mode_chauff[$zone_mode_chauffage]['modeChauff']],
			'modeCommand'=> $data[68],
			'consoHeure'=> $consoHeure, 
			'erreur' 	=> $data[30], //error code
			'integral'	=> $data,
		);
        break;

	case 'V14.0HAR.o2':
		$depart_chauffage = array( 
			'zone1' => ['est' => 65, 'doit' => 66, 'modeChauff' => 69, 'Tint' => 67],//c21,c23,c85,c138
			'zone2' => ['est' => 71, 'doit' => 72, 'modeChauff' => 75, 'Tint' => 73],//c22,c24,c86,c139
			'zone3' => ['est' => 77, 'doit' => 78, 'modeChauff' => 81, 'Tint' => 79],//c29,c31,c87,c33
		);
		$ballon_ECS = array( 
			'ballon1' => ['est' => 97], // c27
			'ballon2' => ['est' => 99], // c35 
			'ballon3' => ['est' => 97], // n'existe plus en 14o2 => on pointe sur precedent
		);
		$mode_chauff = array( 
			'modeChauffageA' => ['modeChauff' => 63],//c84
			'modeChauffage1' => ['modeChauff' => 69],//c85
			'modeChauffage2' => ['modeChauff' => 75],//c86
			'modeChauffage3' => ['modeChauff' => 81],//c87 
			'modeChauffage4' => ['modeChauff' => 87],//c88 
			'modeChauffage5' => ['modeChauff' => 75],// n'existe plus en 14o2 => on pointe sur precedent
			'modeChauffage6' => ['modeChauff' => 75],// n'existe plus en 14o2 => on pointe sur precedent
		); // pense-bete : a prevoir , suppression des options directement dans la page reglages
		
		$etat_desc = $ETAT[$data[0]];
		if (!$etat_desc){
			$etat_desc = 'Unknown Status '.$data[0];
		}

		$output = array(
			'heure' 	=> time() * 1000,
			'etat_num' 		=> $data[0],
			'etat_desc' 	=> $etat_desc,
			'lambda'	=> $data[1],
			'chaudiereEst'=> $data[3],
			'chaudiereDoit'=> $data[4],
			'Fumee'		=> $data[8],
			'extract'	=> $data[9],
			'puissance' => $data[20],
			'bois'		=> $data[21],
			'Tint'		=> $data[$depart_chauffage[$zone_chauffage]['Tint']],
			'Text'		=> $data[54],
			'TextMoy'	=> $data[55],
			'departEst' => $data[$depart_chauffage[$zone_chauffage]['est']],
			'departDoit'=> $data[$depart_chauffage[$zone_chauffage]['doit']],
			'retourEst' => $data[5],
			'retourDoit'=> $data[6],
			'TempECS'	=> $data[$ballon_ECS[$zone_ecs]['est']], 
			'pompe-ECS'	=> $data[101],//c92
			'tempsDecend'=> $data[38],
			'tempsVis'	=> $data[37],
			'mvtGrille' => $data[40],
			'PelletConso'=> $data[42],
			'PelletRest' => $data[41],
			'variableK' => $data[27],
			'variableF' => $data[28],
			'modeChauff'=> $data[$mode_chauff[$zone_mode_chauffage]['modeChauff']],
			'modeCommand'=> $data[70],//c101
			'consoHeure'=> $consoHeure, 
			'erreur' 	=> $data[30], //error code
			'integral'	=> $data,
		);
        break;

	case 'V14.0HAR.p': 
	default:
		$depart_chauffage = array( 
			'zone1' => ['est' => 63, 'doit' => 64, 'modeChauff' => 67, 'Tint' => 65],//c21,c23,c85,c138
			'zone2' => ['est' => 69, 'doit' => 70, 'modeChauff' => 73, 'Tint' => 71],//c22,c24,c86,c139
			'zone3' => ['est' => 69, 'doit' => 70, 'modeChauff' => 73, 'Tint' => 71],//c29,c31,c87,c33 // n'existe plus en 14p => on pointe sur zone2
		);
		$ballon_ECS = array( 
			'ballon1' => ['est' => 83], // c27
			'ballon2' => ['est' => 83], // c35 n'existe plus en 14p => on pointe sur precedent
			'ballon3' => ['est' => 83], // n'existe plus en 14p => on pointe sur precedent
		);
		$mode_chauff = array( 
			'modeChauffageA' => ['modeChauff' => 61],//c84
			'modeChauffage1' => ['modeChauff' => 67],//c85
			'modeChauffage2' => ['modeChauff' => 73],//c86
			'modeChauffage3' => ['modeChauff' => 73],//c87 n'existe plus en 14p => on pointe sur 73
			'modeChauffage4' => ['modeChauff' => 73],//c88 n'existe plus en 14p => on pointe sur 73
			'modeChauffage5' => ['modeChauff' => 73],// n'existe plus en 14p => on pointe sur 73
			'modeChauffage6' => ['modeChauff' => 73],// n'existe plus en 14p => on pointe sur 73
		); // pense-bete : a prevoir , suppression des options directement dans la page reglages
		
		$etat_desc = $ETAT[$data[0]];
		if (!$etat_desc){
			$etat_desc = 'Unknown Status '.$data[0];
		}

		$output = array(
			'heure' 	=> time() * 1000,
			'etat_num' 		=> $data[0],
			'etat_desc' 	=> $etat_desc,
			'lambda'	=> $data[1],
			'chaudiereEst'=> $data[3],
			'chaudiereDoit'=> $data[4],
			'Fumee'		=> $data[8],
			'extract'	=> $data[9],
			'puissance' => $data[20],
			'bois'		=> $data[21],
			'Tint'		=> $data[$depart_chauffage[$zone_chauffage]['Tint']],
			'Text'		=> $data[54],
			'TextMoy'	=> $data[55],
			'departEst' => $data[$depart_chauffage[$zone_chauffage]['est']],
			'departDoit'=> $data[$depart_chauffage[$zone_chauffage]['doit']],
			'retourEst' => $data[5],
			'retourDoit'=> $data[6],
			'TempECS'	=> $data[$ballon_ECS[$zone_ecs]['est']], 
			'pompe-ECS'	=> $data[85],//c92
			'tempsDecend'=> $data[38],
			'tempsVis'	=> $data[37],
			'mvtGrille' => $data[40],
			'PelletConso'=> $data[42],
			'PelletRest' => $data[41],
			'variableK' => $data[27],
			'variableF' => $data[28],
			'modeChauff'=> $data[$mode_chauff[$zone_mode_chauffage]['modeChauff']],
			'modeCommand'=> $data[68],//c101
			'consoHeure'=> $consoHeure, 
			'erreur' 	=> $data[30], //error code
			'integral'	=> $data,
		);
        break;



}	

// on renvoi la reponse
echo json_encode($output, JSON_NUMERIC_CHECK);  //numeric_check : remove ""

?>
