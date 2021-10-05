<?php
// MySQL config
$hostname = "192.168.0.222:3307"; // 3306 MySQL 5 , 3307 MySQL 10
$database = "hargassner"; // nom de la BDD
$username = "hargassner"; // utilisateur mysql
$password = "password";

// requete 
$query = "show tables;";
            
$conn = mysqli_connect ($hostname, $username, $password, $database); 
    $req = mysqli_query($conn, $query) ;
	mysqli_close($conn);
    
if ($conn){
	echo "connexion OK - ";
	echo "lecture tables : ";
	while($data = mysqli_fetch_row($req)){
		echo $data[0];
	}
} else {
	echo "connexion KO - ";
}

?>