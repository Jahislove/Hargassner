<?php
	// appelé par page_reglages.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	//lecture du fichier ini et stockage dans tableau
	$content = parse_ini_file('conf/settings.ini', true);

echo "<pre>". print_r($content,true) . "</pre>";
	// remplacement par nouvelles valeurs
	if ($_POST['language']) {
		$content['localization']['cost_origin']= $_POST['cost_origin'];
		$content['localization']['language']= $_POST['language'];
	}
	
	// transformation tableau en texte 
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