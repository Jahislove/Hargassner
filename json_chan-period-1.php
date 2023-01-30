<?php
// appelé par ajax, reçoit 1 channel en parametre et renvoi un objet serie
// pour page_1_24h.php
require_once("conf/config.inc.php");
 
	header("Content-type: text/json");

    $id = $_GET["id"];
    $periode = $_GET["periode"];
	
	switch ($firmware) { // dictionnaire faisant le lien entre le T et le c
		case '14k':
			$dict = ['c0','c1','c2','c3','c4','c5','c53','c52','c134','c56','c57','c58','c59','c60','c61','c6','c7','c8','c178','c9','c179','c10','c11','c12','c13','c15','c129','c160','c54','
			c55','c116','c117','c112','c111','c113','c114','c154','c130','c136','c62','c95','c96','c180','c177','c176','c128','c115','c99','c81','c97','c16','c17','c137','c45','c84','c100','c21','c23','c138','c46','c85','
			c101','c22','c24','c139','c47','c86','c102','c29','c31','c140','c48','c87','c103','c30','c32','c141','c49','c88','c104','c37','c39','c142','c50','c89','c105','c38','c40','c143','c51','c90','c106','c19','c20','
			c91','c27','c28','c92','c35','c36','c93','c43','c44','c94','c107','c108','c109','c110','c168','c146','c147','c148','c149','c150','c151','c152','c153','c169','c170','c171','c172','c173','c174','c175','c73','
			c74','c75','c76','c77','c78','c79','c80','c118','c119','c120','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','c182','c183','','','','c187'];
			break;
	}
	$channel = $dict[$id];

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
        $liste1[] = [$dateD, $data[1]];
    }

    $liste1 = array_reverse($liste1);



    $obj = ['name'=> 'T'.$id.'-'.$channel ,
			'data'=> $liste1,
			'id'  => 't'.$id,
			];

    echo json_encode($obj, JSON_NUMERIC_CHECK);
	
?>
