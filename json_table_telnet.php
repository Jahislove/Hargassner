<?php
// appelé par ajax, reçoit 1 channel en parametre et renvoi un objet serie
// pour page_1_24h.php
require_once("conf/config.inc.php");
require_once("conf/settings.inc.php");
	if (!isset($language)) {
	  $language = 'en';
	}
	include('locale/' . $language . '.php');
require_once("conf/BDD_description_chanel.php");
require_once("conf/firmware.inc.php");
 
	header("Content-type: text/json");

    $id = $_GET["id"];
    $periode = $_GET["periode"];
	

// utilisation du dictionnaire de firmware.inc.php
// pour determiner les colonne valide
	$channel = $dict[$id];

	if ($channel) {
		$query = "SELECT dateB,$channel FROM data
				  ORDER by dateB DESC LIMIT $periode";
		$conn = mysqli_connect ($hostname, $username, $password, $database); 
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
		$req = mysqli_query($conn, $query);
		mysqli_close($conn);
		
		while($data = mysqli_fetch_row($req)){
			$dateD = strtotime($data[0]) * 1000;
			$liste[] = [$dateD, $data[1]];
		}
		$liste = array_reverse($liste);
    }          


    $obj = ['name'=> 't'.$id.'/'.$channel.'/'.$BDD[$channel]['desc'] ,
			'data'=> $liste,
			'id'  => 't'.$id,
			];

    echo json_encode($obj, JSON_NUMERIC_CHECK);
	
?>
