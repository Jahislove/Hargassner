<?php
require_once("conf/config.inc.php");


$hostname = "127.0.0.1"; //127.0.0.1 si la BDD est sur la meme machine que le serveur web , sinon IP
$portSQL  = "3306";
$database = "test"; // nom de la BDD
$username = "hargassner"; // utilisateur mysql
$password = "password";

$conn = mysqli_connect ($hostname, $username, $password, $database, $portSQL); 
if (!$conn) {
	die("Connection BDD failed: " . mysqli_connect_error());
}

//variable provenant de php
$fichier_ori = $_FILES['data']['name'] ; // nom du fichier d'origine
$fichier_tmp = $_FILES['data']['tmp_name']; //chemin et nom du fichier temporaire
$error = $_FILES['data']['error']; // code retour de l'upload

//verification extension du fichier
$extension = strrchr($fichier_ori, '.');
if ( $extension != '.csv') {
	die('extension du fichier non valide');
}
//verification code retour
if ( $error != 0) {
	die("erreur lors de l'upload");
}
	
$data = file($fichier_tmp);// ecrit les données du fichier dans un tableau
// verification contenu du fichier
if ( rtrim($data[0]) != 'utc,local,celsius') { // verification format du csv
	die("contenu du fichier incorrect");
}

// traitement 
for ($i = 1; $i < count($data); $i++){ // pour chaque ligne du tableau
	list($UTC, $GMT, $temp) = explode(",",$data[$i]);//separe les champs

	$GMT = str_replace('T',' ',$GMT); // supprime le T
	$GMT = substr($GMT, 0, -9); // supprime les 9 caracteres de la fin( secondes et l'heure gmt)
	$temp = round($temp,1); // arrondi la temperature a 1 chiffre apres la virgule

	$requete = "UPDATE data SET c138 = '$temp'
				WHERE dateB LIKE '$GMT:__'";

	echo "<br>" . $requete;
	//injection dans la BDD
	if (mysqli_query($conn, $requete)) {
		echo " => record updated successfully";
	} else {
		echo " => Error: " . mysqli_error($conn);
	}


}

	
	
	

	
	
	


	mysqli_close($conn);


?>
