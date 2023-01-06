<?php
	require_once("conf/config.inc.php");

	$saison = $_POST['saison'];

	$query1 = "CREATE TABLE IF NOT EXISTS `tarif` (
		`saison` CHAR(9) NOT NULL COLLATE 'utf8_general_ci',
		`prix` DECIMAL(5,3) NOT NULL DEFAULT '0.000',
		UNIQUE INDEX `index_unique` (`saison`) USING BTREE
		) COLLATE='utf8_general_ci'";

	$query2 = "INSERT INTO tarif (saison , prix) VALUES ('$saison' , 0 )" ;

	$conn = mysqli_connect ($hostname, $username, $password, $database); 
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	
    $req1 = mysqli_query($conn, $query1) ;
	echo mysqli_error($conn);
	
	if($saison){
		$req2 = mysqli_query($conn, $query2) ;
		echo mysqli_error($conn);
	}
	mysqli_close($conn);

 require("page_reglages.php");
?>
