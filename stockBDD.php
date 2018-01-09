<?php 
// version 0.1
//en cours dev
// ecriture des data dans bdd en php
header("Content-type: text/json");
require_once("conf/config.inc.php");
	
$hostname = "127.0.0.1"; //127.0.0.1 si la BDD est sur la meme machine que le serveur web , sinon IP
$portSQL  = "3306";
$database = "test"; // nom de la BDD
$username = "hargassner"; // utilisateur mysql
$password = "password";

$conn = mysqli_connect ($hostname, $username, $password, $database, $portSQL); 
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}
	
# declaration nombre de parametre dans la trame en fonction du firmware (note : +2 par rapport au numero du dernier chanel)
# pour les vieux firmware avec moins de 164 parametres , l'ordre des champs est 
# modifié afin d'etre compatible avec le site web
if ($firmware == '4.3d'){
    $nbre_param = 85;
    $list_champ = str_repeat(",'%s'", $nbre_param) ; # adapte la requete au nombre de parametre
    $requete = "INSERT INTO data (id,dateB,c0,c1,c2,c3,c4,c5,c6,c7,c8,c9,c10,c11,c12,c13,c14,c15,c16,c17,c18,c19,c20,c21,c22,c23,c24,c25,c26,c27,c28,c29,c30,c31,c32,c33,c34,c35,c36,c37,c38,c39,c40,c41,c42,c43,c44,c45,c46,c47,c48,c49,c50,c51,c52,c53,c54,c55,c56,c57,c58,c59,c60,c61,c62,c63,c64,c65,c66,c67,c68,c69,c70,c71,c72,c73,c74,c75,c76,c77,c78,c79,c182,c81,c82,c83) VALUES (null" . list_champ . ")" ;
} elseif ($firmware == '14d' or $firmware == '14e' or $firmware == '14f'){
    $nbre_param = 174;
    $list_champ = str_repeat(",'%s'", $nbre_param) ; # adapte la requete au nombre de parametre
    $requete = "INSERT INTO data  VALUES (null" . $list_champ . ")" ;# null correspond au champ id qui sera auto completed par mysql
} elseif ($firmware == '14g'){
    $nbre_param = 190;
    $list_champ = str_repeat(",'%s'", $nbre_param) ; # adapte la requete au nombre de parametre
    # requete = "INSERT INTO data (id,dateB,c0,c1,c2,c3,c4,c5,c6,c7,c8,c9,c10,c11,c12,c13,c14,c15,c16,c17,c18,c19,c20,c21,c22,c23,c24,c25,c26,c27,c28,c29,c30,c31,c32,c33,c34,c35,c36,c37,c38,c39,c40,c41,c42,c43,c44,c45,c46,c47,c48,c49,c50,c51,c52,c53,c54,c55,c56,c57,c58,c59,c60,c61,c62,c63,c64,c65,c66,c67,c68,c69,c70,c71,c72,c73,c74,c75,c76,c77,c78,c79,c80,c81,c82,c83,c84,c85,c86,c87,c88,c89,c90,c91,c92,c93,c94,c95,c96,c97,c98,c99,c100,c101,c102,c103,c104,c105,c106,c107,c108,c109,c110,c111,c112,c113,c114,c115,c116,c117,c118,c119,c120,c121,c122,c123,c124,c125,c126,c127,c128,c129,c130,c131,c132,c133,c134,c135,c136,c137,c138,c139,c140,c141,c142,c143,c144,c145,c146,c147,c148,c149,c150,c151,c152,c153,c154,c155,c156,c157,c158,c159,c160,c161,c162,c163,c164,c165,c166,c167,c168,c169,c170,c171,c172,c173,c174,c175,c176,c177,c178,c179,c180,c181,c182,c183,c184,c185,c186,c187,c188) VALUES (null" + $list_champ + ")" 
    $requete = "INSERT INTO data  VALUES (null" . $list_champ . ")" ;# null correspond au champ id qui sera auto completed par mysql
} else {
    $nbre_param = 174;
    $list_champ = str_repeat(",'%s'", $nbre_param) ; # adapte la requete au nombre de parametre
    $requete = "INSERT INTO data  VALUES (null" . $list_champ . ")" ;# null correspond au champ id qui sera auto completed par mysql
}	

//ouverture socket telnet et lecture
$fp = fsockopen ($IPchaudiere, $port, $errno, $errstr);
if(!$fp){
	echo "$errstr";
}
else {
	$reponse=fgets ($fp,1024); //lecture reponse telnet
	fclose($fp);
}

$data = explode(" ",$reponse); //transforme la reponse telnet (separateur espace) en array
    
    // verifie le bon format de la reponse
    // pm 0 0 0 0 0 0 ....
    if($data[0] == "pm"){
        $data[0] = date('Y-m-d H:i:s', time()); //remplace pm par la date
        $data = array_slice($data, 0, $nbre_param); // selectionne le nombre de param suivant le firmware
		// echo json_encode($data, JSON_NUMERIC_CHECK);  //numeric_check : remove ""  
    }
	// $requete = 'select * from data
	// LIMIT 1';
	$liste = "'" . implode("','", $data) . "'";
	// $liste = "null,'" . implode("','", $data) . "'";
	// echo $liste;
// $liste = "'2018-01-02 21:29:25','1','1.2','8.0','38','0','35','9','8','120','-20','120','125','38','35','100','25','-20','0','20','-20','0','25','140','0','0','21','20','20','0','-20','-20','0','0','20','20','-20','0','-20','-20','0','0','20','20','-20','0','20','24','20','20','20','20','20','0.0','0','100','43','0.0','0','0','0','0','0','50','0.0','0.0','0','0.0','0','0','0','0','0','4','0','0','0','0','0','0','0','0','1','0','0','0','4','0','0','0','0','0','0','0','0','0','0','0','0','516','2270','1','1','1','1','1','1','1','0','0','0','0','18','163','0','581','584','0','0','0','0','0','0','0','0','0','0','0','0','0.0','107.8','0.0','0.0','0.0','-20','0','4','-2','20.0','20.6','20.0','20.0','20.0','20.0','20.0','0','0','0','0','0','0','0','0','0','0','0.0','2957','968','16.8','990','0.9','123.0','968.6','240','189.6','73.5','0.0','0.0','0.0','0','0','0','0','0','0','0','0','5.0','100.0','-20.0','-20.0','100','0003','4000','0000','0000','0000','0110','0000','0000'";
	
	
	// $requete = "INSERT INTO data VALUES (null, '$liste')";
	$requete = "INSERT INTO data  VALUES (null, $liste)";
	// $requete = "INSERT INTO consommation VALUES ('2018-01-05','1','6')";
    // $req = mysqli_query($connn, $requete) ;

	if (mysqli_query($conn, $requete)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $requete . "<br>" . mysqli_error($conn);
}


echo getcwd();

	mysqli_close($conn);
    
    // $dataf = mysqli_fetch_row($req);
	// echo json_encode($dataf, JSON_NUMERIC_CHECK);
?>
