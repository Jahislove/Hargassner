<?php
	// appelé par page_reglages.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	//lecture du fichier ini et stockage dans tableau 2D
	$content = parse_ini_file('conf/settings.ini', true);

echo "<pre>". print_r($content,true) . "</pre>";
	// remplacement par nouvelles valeurs
	if ($_POST['language']) {
		$content['localization']['language']= $_POST['language'];
		$content['localization']['cost_origin']= $_POST['cost_origin'];
		$content['localization']['cost_de_1']= 'https://www.holzpellets.net/pelletspreise';
		$content['localization']['cost_fr_1']= 'https://www.proxi-totalenergies.fr/prix-pellets';
		$content['localization']['cost_en_1']= 'https://www.proxi-totalenergies.fr/prix-pellets';
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
echo "<pre>". print_r($newText,true) . "</pre>";
	// ecriture du fichier
	file_put_contents('conf/settings.ini',$newText);
}

?>