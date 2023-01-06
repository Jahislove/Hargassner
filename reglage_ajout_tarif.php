<?php
	require_once("conf/config.inc.php");

	$nombre_saison = $_POST['nombre_saison'];

	for ($i=0 ; $i < $nombre_saison ; $i++){
		$query .= "UPDATE tarif
				SET prix =".$_POST["prix".$i.""]."
				WHERE saison='". $_POST["saison".$i.""] ."';" ;
	}
	
	$conn = mysqli_connect ($hostname, $username, $password, $database); 
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	
    $req = mysqli_multi_query($conn, $query) ;
	// echo mysqli_error($conn);

	mysqli_close($conn);

 require("page_reglages.php");
?>
