<?php 
// version 0.5	ajout firmware 10.2h

// version 0.4 compatibilité avec php7
// auteur : JahisLove 2018-2021
// licence GPL-3.0-or-later
// ecriture des data dans la bdd en php

/* 	ATTENTION pour les installations deja existantes ,même si vous restez en php5.6 il y a quand même une action a faire
		si vous restez en php5 : 
			mysqli est pré-installé :
			+ il faut ajouter ou remplacez l'extension mysql par mysqli dans votre config du serveur php
		
		si vous remplacez php5 par 7 : 
			mysqli est pré-installé :
			+ ajoutez simplement l'extension  mysqli dans votre config du serveur php 
			
			dans le fichier conf/php.ini :
			+ modifiez le extension_dir pour pointer vers le nouveau chemin(lancer  phpinfo.php dans votre barre d'adresse)
			+ supprimer la ligne extension = mysql.so 
			+ ajouter la ligne extension = mysqli.so 
			
			+ sur Synology modifier l'executable php dans votre tache planifiée
				ex php74 -c /volume1/web/hargassner/conf/php.ini -f /volume1/web/hargassner/stockBDD.php
 

rien a configurer ici par l'utilisateur
seule une ligne dans conf/php.ini est a configurer ( la ligne extension_dir)
pour trouver votre chemin utiliser la page et cherchez extension_dir
http://ip_mon_serveur/hargassner/phpinfo.php
pensez egalement a bien configurer le firmware dans conf/config.inc.php
les valeurs prises en compte a ce jour sont 

granulés  14e , 14f , 14g , 14i , 14j, 14k, 14l
buches 4.3d, 10.2h

l'ordre des parametres envoyés par la chaudiere differe en fonction du firmware
pour conserver la compatibilité des differentes versions , les colonnes de la BDD ne changent jamais.
c'est ici dans stockBDD.php , qu'on modifie l'ordre des parametres dans la requete avant d'écrire en BDD.
ex : on stock normalement le parametre 134 reçu par telnet dans la colonne c134 de la BDD ( qui correspond a la puissance)
mais si avec un autre firmware la puissance correspond au parametre telnet  50 , alors  on stock ce parametre 50 dans la colonne c134 de la BDD
de cette manière , le reste du site continue a lire la puissance dans la c134
*/
header("Content-type: text/json");
require_once("conf/config.inc.php");

//*******************declaration des fonctions*******************************************************

// fonction calcul de la consommation de la veille et insertion dans la table consommation
// la table consommation se rempli 1 seule fois par jour, apres minuit
function calcul_consommation($hostname, $database, $username, $password){
	$conn = mysqli_connect ($hostname, $username, $password, $database); 
	$requete = "SELECT dateB FROM consommation ORDER by dateB DESC LIMIT 1 ";

	if ($result = mysqli_query($conn, $requete)){
		while ($id = mysqli_fetch_row($result)) {
		}
 	}
	$last_conso = date("Y-m-d", strtotime($id[0]." -1 day"));
	$hist_conso = date("Y-m-d", strtotime($id[0]." -10 day"));
	$jour = date('Y-m-d', time());  
	
        if ($jour > $last_conso){
            $SQLrequete = "SELECT DATE(dateB),MAX(c99)-MIN(c99),FORMAT(AVG(c6), 1) FROM data
                        WHERE dateB > $hist_conso
						GROUP BY DATE(dateB)
                        ORDER by dateB DESC LIMIT 1,1 ";
			$result = mysqli_query($conn, $SQLrequete);
			$data = mysqli_fetch_row($result);
           $SQLinsert = "INSERT INTO consommation (dateB, conso, Tmoy) VALUES ('$data[0]',$data[1],$data[2])" ;
			mysqli_query($conn, $SQLinsert);
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
			addLogEvent("lecture du socket KO");
			break ; // si pas de reponse on quitte tout le programme
		}
	}
	return $reponse;
}

// log
// si ecriture en BDD impossible on ecrit dans stockBDD.log a la place
// 
function addLogEvent($event)
{
    $event = $event.";"."\n";
    file_put_contents("stockBDD.log", $event, FILE_APPEND);
}

//*******************programme principal*******************************************************
// appel fonction lecture
$reponse = lecture($IPchaudiere, $port); //interrogation chaudiere

//traitement des données
$data = explode(" ",$reponse); //transforme la reponse telnet (separateur espace) en tableau
$data[0] = date('Y-m-d H:i:s', time()); //remplace le premier parametre (pm) par la date


// construction de la requete en fonction du firmware
			
// ordre original de la BDD
/* $requete = "INSERT INTO data (id,dateB,c0,c1,c2,c3,c4,c5,c6,c7,c8,c9,c10,c11,c12,c13,c14,c15,c16,c17,c18,c19,c20,c21,c22,c23,c24,c25,c26,c27,c28,c29,c30,c31,c32,
			c33,c34,c35,c36,c37,c38,c39,c40,c41,c42,c43,c44,c45,c46,c47,c48,c49,c50,c51,c52,c53,c54,c55,c56,c57,c58,c59,c60,c61,c62,c63,c64,c65,c66,c67,c68,c69,c70,
			c71,c72,c73,c74,c75,c76,c77,c78,c79,c80,c81,c82,c83,c84,c85,c86,c87,c88,c89,c90,c91,c92,c93,c94,c95,c96,c97,c98,c99,c100,c101,c102,c103,c104,c105,c106,
			c107,c108,c109,c110,c111,c112,c113,c114,c115,c116,c117,c118,c119,c120,c121,c122,c123,c124,c125,c126,c127,c128,c129,c130,c131,c132,c133,c134,c135,c136,
			c137,c138,c139,c140,c141,c142,c143,c144,c145,c146,c147,c148,c149,c150,c151,c152,c153,c154,c155,c156,c157,c158,c159,c160,c161,c162,c163,c164,c165,c166,
			c167,c168,c169,c170,c171,c172,c173,c174,c175,c176,c177,c178,c179,c180,c181,c182,c183,c184,c185,c186,c187,c188) VALUES (null, $liste)";  */
switch ($firmware) {
    case '10.2h':
		$nbre_param = 163; // declaration nombre de parametre dans la trame en fonction du firmware (note : +2 par rapport au numero du dernier chanel)
        $data = array_slice($data, 0, $nbre_param); // selectionne le nombre de param dans la trame suivant le firmware ( car parfois il y a plus de parametre dans le telnet)
		$liste = "'" . implode("','", $data) . "'";
		$requete = "INSERT INTO data (id,dateB,c3,c5,c1,c8,c9,c10,c6,c21,c22,c25,c26,c27,c23,c24,c46,c47,c73,c74,c75,c76,c52,c14,c0,c2,c62,c77,c134,c4,c29,c30,c33,
					c34,c35,c31,c32,c48,c49,c37,c38,c41,c42,c43,c39,c40,c50,c51,c53,c15,c12,c180,c168,c146,c147,c63,c64,c65,c66,c11,c13,c7,c67,c68,c69,c154,c130,
					c131,c132,c19,c17,c45,c18,c16,c100,c101,c102,c103,c104,c105,c106,c137,c138,c139,c140,c141,c142,c143,c78,c79,c80,c107,c148,c108,c109,c116,c117,
					c118,c119,c120,c121,c54,c55,c56,c57,c58,c59,c60,c169,c122,c149,c150,c151,c152,c70,c71,c72,c81,c82,c83,c98,c99,c111,c112,c113,c114,c115,c123,c124,
					c125,c153,c126,c127,c155,c156,c128,c129,c157,c176,c177,c178,c179,c159,c84,c85,c86,c87,c88,c89,c90,c91,c92,c93,c94,c184,c186,c187,c188,c170,c171,
					c172,c173,c174,c175) VALUES (null, $liste)" ;
        break;
    case '4.3d':
		$nbre_param = 85; // declaration nombre de parametre dans la trame en fonction du firmware (note : +2 par rapport au numero du dernier chanel)
        $data = array_slice($data, 0, $nbre_param); // selectionne le nombre de param dans la trame suivant le firmware ( car parfois il y a plus de parametre dans le telnet)
		$liste = "'" . implode("','", $data) . "'";
		$requete = "INSERT INTO data (id,dateB,c0,c1,c2,c3,c4,c5,c6,c7,c8,c9,c10,c11,c12,c13,c14,c15,c16,c17,c18,c19,c20,c21,c22,c23,c24,c25,c26,c27,c28,c29,c30,
					c31,c32,c33,c34,c35,c36,c37,c38,c39,c40,c41,c42,c43,c44,c45,c46,c47,c48,c49,c50,c51,c52,c53,c54,c55,c56,c57,c58,c59,c60,c61,c62,c63,c64,c65,
					c66,c67,c68,c69,c70,c71,c72,c73,c74,c75,c76,c77,c78,c79,c182,c81,c82,c83) VALUES (null, $liste)" ;
        break;
    case '14d':
    case '14e':
    case '14f':
		$nbre_param = 174;
        $data = array_slice($data, 0, $nbre_param); 
		$liste = "'" . implode("','", $data) . "'";
		$requete = "INSERT INTO data (id,dateB,c0,c1,c2,c3,c4,c5,c6,c7,c8,c9,c10,c11,c12,c13,c14,c15,c16,c17,c18,c19,c20,c21,c22,c23,c24,c25,c26,c27,c28,c29,c30,c31,c32,
			c33,c34,c35,c36,c37,c38,c39,c40,c41,c42,c43,c44,c45,c46,c47,c48,c49,c50,c51,c52,c53,c54,c55,c56,c57,c58,c59,c60,c61,c62,c63,c64,c65,c66,c67,c68,c69,c70,
			c71,c72,c73,c74,c75,c76,c77,c78,c79,c80,c81,c82,c83,c84,c85,c86,c87,c88,c89,c90,c91,c92,c93,c94,c95,c96,c97,c98,c99,c100,c101,c102,c103,c104,c105,c106,
			c107,c108,c109,c110,c111,c112,c113,c114,c115,c116,c117,c118,c119,c120,c121,c122,c123,c124,c125,c126,c127,c128,c129,c130,c131,c132,c133,c134,c135,c136,
			c137,c138,c139,c140,c141,c142,c143,c144,c145,c146,c147,c148,c149,c150,c151,c152,c153,c154,c155,c156,c157,c158,c159,c160,c161,c162,c163,c164,c165,c166,
			c167,c182,c169,c170,c171,c172) VALUES (null, $liste)"; // 168 (alphanum) est ecrit dans c182
        break;
    case '14g':
		$nbre_param = 190; // 188 chanels
        $data = array_slice($data, 0, $nbre_param); 
		$liste = "'" . implode("','", $data) . "'";
		$requete = "INSERT INTO data  VALUES (null, $liste)" ; // la BDD compte 190 champ , on peut donc simplifier la requete
        break;
    case '14i':
	case '14j':
	case '14k':
	case '14l':
		$nbre_param = 136; //134 chanels
        $data = array_slice($data, 0, $nbre_param); 
		$liste = "'" . implode("','", $data) . "'"; // a partir du 14i l'ordre des parametres a changé => on modifie l'ordre d'ecriture en bdd
		$requete = "INSERT INTO data (id,dateB,c0,c1,c2,c3,c4,c5,c53,c52,c134,c56,c57,c58,c59,c60,c61,c6,c7,c8,c178,c9,c179,c10,c11,c12,c13,c15,c129,c160,c54,
			c55,c116,c117,c112,c111,c113,c114,c154,c130,c136,c62,c95,c96,c180,c177,c176,c128,c115,c99,c81,c97,c16,c17,c137,c45,c84,c100,c21,c23,c138,c46,c85,
			c101,c22,c24,c139,c47,c86,c102,c29,c31,c140,c48,c87,c103,c30,c32,c141,c49,c88,c104,c37,c39,c142,c50,c89,c105,c38,c40,c143,c51,c90,c106,c19,c20,
			c91,c27,c28,c92,c35,c36,c93,c43,c44,c94,c107,c108,c109,c110,c168,c146,c147,c148,c149,c150,c151,c152,c153,c169,c170,c171,c172,c173,c174,c175,c73,
			c74,c75,c76,c77,c78,c79,c80,c118,c119,c120) VALUES (null, $liste)" ;
        break;
}			
			
// insertion dans la BDD

$conn = mysqli_connect ($hostname, $username, $password, $database); 

$result = mysqli_query($conn, $requete);

if (!$result) { // si requete KO on log et on quitte
	addLogEvent($requete);	
	exit("connexion BDD impossible");
}

mysqli_close($conn);

//appel fonction consommation pour remplissage 1 fois par jour de la table consommation
$heure = date('H', time());
$minute = date('i', time());

if ($heure == '00' and $minute < '30'){ # si heure est comprise entre 00h00 et 00h30 on calcul la conso de la veille
	calcul_consommation($hostname, $database, $username, $password);
}

?>
