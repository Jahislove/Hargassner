<?php
require_once("conf/config.inc.php");
header("Content-type: text/json");

switch($_POST['request']){
	case 'Tmin':
		// $query = "SELECT dateB,c6 FROM data
				// WHERE c6=(SELECT MIN(c6) FROM data)
				// group BY  DATE(dateB)
				// LIMIT 3" ;
		$query = "SELECT dateB,MIN(c6) AS temp FROM data
				group BY  DATE(dateB)
				ORDER BY temp ASC
				LIMIT 3" ;
		break;
	case 'Tmax':
		// $query = "SELECT dateB,c6 FROM data
				// WHERE c6=(SELECT MAX(c6) FROM data)
				// group BY  DATE(dateB)
				// LIMIT 3" ;
		$query = "SELECT dateB,MAX(c6) AS temp FROM data
				group BY  DATE(dateB)
				ORDER BY temp DESC
				LIMIT 3" ;
		break;
	case 'Gmax':
		$query = "SELECT dateB,conso FROM consommation
				WHERE conso=(SELECT MAX(conso) FROM consommation)
				group BY  DATE(dateB)
				LIMIT 2" ;
		break;
	case 'ecs':
		$query = "SELECT dateB, ROUND(avg(sum_conso),0) FROM (
				  SELECT dateB, SUM(conso) AS sum_conso FROM consommation
					WHERE month(dateB) IN(6,7,8)  
					GROUP BY year(dateB),month(dateB)
					HAVING SUM(conso) <> 0) tmp" ;
		break;
	case 'prix_moyen':
		$query = "SELECT dateB, prix FROM  prix_moyen
				  ORDER BY dateB ASC" ;
		break;
	default :
		break;
}

$conn = mysqli_connect ($hostname, $username, $password, $database); 
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}
$req = mysqli_query($conn, $query);
mysqli_close($conn);

// #########traitement query#####################################################################################
while($data = mysqli_fetch_row($req)){
	// $phpdate = strtotime($data[0]) ;
	// $date = date( 'd/m/Y', $phpdate );
	$objetDivers[] = ['Date'=> $data[0],
					  'Data'=> $data[1],
					 ];
}

echo json_encode($objetDivers, JSON_NUMERIC_CHECK);
?>
