<?php
	// appelé par page_reglages.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// backup and delete historic country average price
	if ($_POST['deleteOK'] == 'coched') {
		require_once("load_cfg.php");
		$query = "SELECT * FROM prix_moyen  ";
		$text = "INSERT INTO `prix_moyen` (`dateB`, `prix`) VALUES \n";
		$conn = mysqli_connect ($hostname, $username, $password, $database); 
		$req = mysqli_query($conn, $query);
		while($data = mysqli_fetch_row($req)){
			$text .= "('$data[0]',$data[1]),\n";
		}
		$text = substr($text,0,-2);// remove last ,\n
		$text .= ";";
		file_put_contents("historic_cost_backup_". date('Y-m-d_Hi').".sql",$text);
		$query = "truncate prix_moyen";
		mysqli_query($conn, $query);
		mysqli_close($conn);
	}
	
	//lecture du fichier ini et stockage dans tableau 2D
	$content = parse_ini_file('conf/settings.ini', true);

	// echo "<pre>". print_r($content,true) . "</pre>";
	if ($_POST['language']) {
		switch ($_POST['zone_chauffage']){
			case 'zone1':
				$depart_chauffage_EST = 'c21';
				$depart_chauffage_DOIT = 'c23';
				break;
			case 'zone2':
				$depart_chauffage_EST = 'c22';
				$depart_chauffage_DOIT = 'c24';
				break;
			case 'zone3':
				$depart_chauffage_EST = 'c29';
				$depart_chauffage_DOIT = 'c31';
				break;
		}
		switch ($_POST['zone_ecs']){
			case 'ballon1':
				$ballon_ECS = 'c27';
				break;
			case 'ballon2':
				$ballon_ECS = 'c35';
				break;
			case 'ballon3':
				$ballon_ECS = 'c43';
				break;
		}
	// remplacement par nouvelles valeurs
		$content['localization']['language']= $_POST['language'];
		$content['localization']['cost_origin']= $_POST['cost_origin'];
		$content['settings_boiler']['firmware']= $_POST['firmware'];
		$content['settings_boiler']['zone_chauffage']= $_POST['zone_chauffage'];
		$content['settings_boiler']['zone_ecs']= $_POST['zone_ecs'];
		$content['settings_boiler']['zone_mode_chauffage']= $_POST['zone_mode_chauffage'];
		$content['chart_chanel']['chart_last24_chan'] = "$depart_chauffage_DOIT,$depart_chauffage_EST,c3,c6,c7,c138,c134";
		$content['chart_chanel']['chart1_chan'] = "c0,c0,c134,c3,c4,c5,c6,c1,c2,c53,$ballon_ECS,c56,c7,c138,$depart_chauffage_EST,$depart_chauffage_DOIT,c22,c24,c99,c92,c112,c12,c111"; // la 2 eme valeur (decendrage) est calculé d"apres c0
		$content['chart_chanel']['json_conso_jour_chanel'] = "dateB,$depart_chauffage_DOIT,$depart_chauffage_EST,c3,c6,c138,c134,c56";
	}

	// transformation tableau en texte 
	$newText = ";Do not modify\n";
    foreach ($content as $section => $settings) {
		$newText .= "[$section]\n";
		foreach ($content[$section] as $settings => $value) {
			$newText .= "    $settings = $value\n";
		}
		$newText .= "\n";
    }
	// echo "<pre>". print_r($newText,true) . "</pre>";
	
	// ecriture du fichier
	file_put_contents('conf/settings.ini',$newText);
}
require("page_reglages.php");

?>