<?php 
// version 1.5	ajout firmware V14.0HAR.p
// version 1.4	ajout firmware V14.0HAR.o2
// version 1.3	ajout firmware V14.0HAR.o
// version 1.2	ajout firmware 14n
// version 1.1  choix firmware se fait maintenant avec conf/firmware.inc.php
// version 1.0  ajout scraper prix moyen
// version 0.9  refonte calcul conso + correction bug 14g
// version 0.8	ajout firmware 14m
// version 0.7	ajout firmware 14l
// version 0.6	ajout firmware 14i, 14j, 14k
// version 0.5	ajout firmware 10.2h
// version 0.4 compatibilité avec php7
// auteur : JahisLove 2015-2024
// licence GPL-3.0-or-later
// ecriture des data dans la bdd en php /writing data in database
// this script need to be executed every minute
/* 	

available firmware (if yours is not here , use the pellets last one ( modify in conf/config.inc.php)
pellets  14e , 14f , 14g , 14i , 14j, 14k, 14l, 14m, 14n, V14.0HAR.o, V14.0HAR.o2, V14.0HAR.p
wood 4.3d, 10.2h

nothing to modify here by user /rien a configurer ici par l'utilisateur

the order of parameter send by boiler vary with firmwares
to keep compatibility with this web site , the database columns never change.
instead we reorder parameter before writing in database

l'ordre des parametres envoyés par la chaudiere differe en fonction du firmware
pour conserver la compatibilité des differentes versions , les colonnes de la BDD ne changent jamais.
c'est dans conf/firmware.inc.php , qu'on modifie l'ordre des parametres dans la requete avant d'écrire en BDD.
ex : on stock normalement le parametre telnet 134 (qui correspond a la puissance) dans la colonne c134 de la BDD 
mais si avec un autre firmware la puissance correspond au parametre telnet  50 , alors  on stock ce parametre 50 dans la colonne c134 de la BDD
de cette manière , le reste du site continue a lire la puissance dans la c134
*/
header("Content-type: text/json");
require_once("conf/config.inc.php");
include('simple_html_dom.php'); // load scraper librarie
require_once("conf/firmware.inc.php");

//*******************declaration des fonctions*******************************************************

// fonction calcul de la consommation de la veille et insertion dans la table consommation
// la table consommation se rempli 1 seule fois par jour, apres minuit
function calcul_consommation($hostname, $database, $username, $password){
	$conn = mysqli_connect ($hostname, $username, $password, $database); 
	$requete = "SELECT dateB FROM consommation ORDER by dateB DESC LIMIT 1 ";

	if ($result = mysqli_query($conn, $requete)){ // recuperation derniere journée en base
		$lastDateInConso = mysqli_fetch_row($result);
 	}
	
	$jourCalcul = date("Y-m-d", strtotime($lastDateInConso[0]." +1 day")); // la journée a calculer est la suivante
	$plageCalcul = "'".$jourCalcul . " 00:00:00' AND '". $jourCalcul ." 23:59:59'"; // transformation pour SQL
	
	$jour = date('Y-m-d', time());  

        if ($jourCalcul < $jour){ // si on a changé de journée on calcul
            $SQLrequete = "SELECT DATE(dateB),MAX(c99)-MIN(c99),FORMAT(AVG(c6), 1) FROM data
                           WHERE dateB BETWEEN $plageCalcul ";
			$result = mysqli_query($conn, $SQLrequete);
			$data = mysqli_fetch_row($result);
			if ($data[0]) { //si données existent
				$SQLinsert = "INSERT INTO consommation (dateB, conso, Tmoy) VALUES ('$data[0]',$data[1],$data[2])" ;
			}else { //si pas de données on insert des zero
				$SQLinsert = "INSERT INTO consommation (dateB, conso, Tmoy) VALUES ('$jourCalcul',0,0)" ;
			}
			mysqli_query($conn, $SQLinsert);
		}
		
	mysqli_close($conn);
}
// recupere le prix moyen sur internet
function scraper_prix_moyen($hostname, $database, $username, $password){
	$html = file_get_html('https://www.proxi-totalenergies.fr/prix-pellets');

	foreach($html->find('.unit-price') as $e) // recupere la valeur de la class .unit-price
    // echo $e->innertext . '<br>';
	preg_match_all('!\d+!', $e, $data);
	$prix = $data[0][0];
	
	foreach($html->find('p.cell') as $e) // recupere la valeur du selecteur p ayant class .cell
    // echo $e->innertext . '<br>';
	preg_match_all('!\d+!', $e, $data);
	// print_r($date);
	$date = $data[0][5].'-'.$data[0][4].'-'.$data[0][3]; //format date pour mysql

	$query = "INSERT IGNORE INTO prix_moyen (dateB , prix) VALUES ('$date' , $prix )" ;

	$conn = mysqli_connect ($hostname, $username, $password, $database); 
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	
	// test validité date
	if (DateTime::createFromFormat('Y-m-d', trim($date)) !== FALSE) {
		$dateOK = true;
	}

	if($dateOK == true and is_numeric($prix)){
		$req = mysqli_query($conn, $query) ;
		// echo mysqli_error($conn);
	}
	mysqli_close($conn);
}

//ouverture socket telnet 
function ecoute_socket($IPchaudiere, $port){
	$fp = fsockopen ($IPchaudiere, $port, $errno, $errstr);
	if(!$fp){
		return;
	}
	$reponse = fgets ($fp,1024); //lecture reponse telnet
	fclose($fp);
	return $reponse; 
}

// lecture et analyse reponse telnet
function lecture($IPchaudiere, $port){
	$reponse = ecoute_socket($IPchaudiere, $port);
	$prefix = strpos($reponse, 'pm');// verifie si debut de la ligne commence par pm
	
	while(!$reponse or $prefix === false) {
		sleep(2);
		$reponse = ecoute_socket($IPchaudiere, $port);
		$prefix = strpos($reponse, 'pm');// verifie si debut de la ligne commence par pm
		$i++;
		if ($i >10){
			addLogEvent("lecture du socket KO",$cheminLog);
			break ; // si pas de reponse on quitte tout le programme
		}
	}
	return $reponse;
}

// log
// si ecriture en BDD impossible on ecrit dans stockBDD.log a la place
// 
function addLogEvent($event,$cheminLog){
	$horodatage = date('Y-m-d H:i:s', time());  
    $event = $horodatage." ".$event."\n";
    file_put_contents($cheminLog."/stockBDD.log", $event, FILE_APPEND);
}

//*******************programme principal*******************************************************
// appel fonction lecture
$reponse = lecture($IPchaudiere, $port); //interrogation chaudiere

//traitement des données
$dataTelnet = explode(" ",$reponse); //transforme la reponse telnet (separateur espace) en tableau

array_shift($dataTelnet); // supprime le 1er element (le pm) , le tableau devient synchro avec les chanels : $dataTelnet[0] = telnet 0 = c0
$date = date('Y-m-d H:i:s', time());

// construction de la requete en fonction du firmware
//la selection du firmware par $dict se fait dans conf/firmware.inc.php
$requete = "INSERT INTO data (id,dateB";
for ($i=0;$i<200;$i++){
	if ($dict[$i]) {					//preparation de la requete ,n'insert que les données existantes dans le dictionaire	
		$requete .= ",".$dict[$i];		//construction des colonnes pour  insert
		$liste .= ",'$dataTelnet[$i]'"; //construction de la liste de data
	}
}
$requete .= ") VALUES (null, '$date' $liste)";

// insertion dans la BDD

$conn = mysqli_connect ($hostname, $username, $password, $database); 
$result = mysqli_query($conn, $requete);

if (!$result) { // si requete KO on log 
	addLogEvent(mysqli_error($conn),$cheminLog);
	addLogEvent($requete,$cheminLog);	
}
mysqli_close($conn);

//appel fonction consommation pour remplissage 1 fois par jour de la table consommation
$heure = date('H', time());
$minute = date('i', time());

if ($heure == '00' and $minute < '30'){ # si heure est comprise entre 00h00 et 00h30 on calcul la conso de la veille
	calcul_consommation($hostname, $database, $username, $password);
}

//appel fonction scraper_prix_moyen pour remplissage 1 fois par jour de la table prix_moyen
if ($heure == '00' and $minute < '5'){  
	scraper_prix_moyen($hostname, $database, $username, $password);
}

?>
