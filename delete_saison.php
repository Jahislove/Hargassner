<?php
	require_once("conf/config.inc.php");

	$saison = $_POST['delete'];

	$query = "DELETE from tarif WHERE saison='$saison'" ;

	$conn = mysqli_connect ($hostname, $username, $password, $database); 
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	
    $req = mysqli_query($conn, $query) ;
	echo mysqli_error($conn);

	mysqli_close($conn);

 require("page_reglages.php");
?>
