<?php 
//called by stockBDD.php
require_once('simple_html_dom.php'); // load scraper librarie

// this is a html scrapping , if web design change , it can break the code
// and need to be recoded, please open a issue on github

switch ($cost_origin) {
    case 'cost_DEU':
		$html = file_get_html('https://www.holzpellets.net/pelletspreise');
		
		//search for cost
		$value=$html->find('.fw600',0); //search for text in the first element with class name...
		$value= $value->innertext ; // keep only text(remove balises html)
		preg_match_all('!\d+!', $value, $data, ); //'!\d+!' extract integer , '!\d+\.*\d*!' extract a decimal
		$prix = $data[0][0];
		
		//search for date
		$datefull=$html->find('.card_current_price_stand',0); //search for text in the first element with class name...
		$datefull= $datefull->innertext ; // keep only text(remove balises html)
		$dateTab = date_parse($datefull); // parse date
		$date = $dateTab['year'].'-'.$dateTab['month'].'-'.$dateTab['day'];// transform date in mySQL format
        break;
		
    case 'cost_AUT':
		$html = file_get_html('https://at.holzpellets.net/pelletspreise');
		
		//search for cost
		$value=$html->find('.fw600',0); //search for text in the first element with class name...
		$value= $value->innertext ; // keep only text(remove balises html)
		preg_match_all('!\d+!', $value, $data, ); //'!\d+!' extract integer , '!\d+\.*\d*!' extract a decimal
		$prix = $data[0][0];
		
		//search for date
		$datefull=$html->find('.card_current_price_stand',0); //search for text in the first element with class name...
		$datefull= $datefull->innertext ; // keep only text(remove balises html)
		$dateTab = date_parse($datefull); // parse date
		$date = $dateTab['year'].'-'.$dateTab['month'].'-'.$dateTab['day'];// transform date in mySQL format
        break;
		
    case 'cost_FRA':
		$html = file_get_html('https://www.proxi-totalenergies.fr/prix-pellets');
		
		$value=$html->find('.unit-price',0); 
		$value= $value->innertext ; 
		preg_match_all('!\d+!', $value, $data, ); 
		$prix = $data[0][0];
		
		$datefull=$html->find('p.cell',0); 
		$datefull= $datefull->innertext ; 
		preg_match_all('!\d+!', $datefull, $data);//preg au lieu de parse car phrase complete
		$date = $data[0][2].'-'.$data[0][1].'-'.$data[0][0]; //format date pour mysql
        break;
}

// echo "<pre>". print_r($dateTab,true) . "</pre>";
// echo $date;

// https://simplehtmldom.sourceforge.io/docs/1.9/manual/finding-html-elements/
// Find all element which id=foo
// $ret = $html->find('#foo');

// Find all element which class=foo
// $ret = $html->find('.foo');

// Find (N)th anchor, returns element object or null if not found (zero based) -1=last
// $ret = $html->find('a', 0); 

// Find all <div> which attribute id=foo
// $ret = $html->find('div[id=foo]');

	//seconde methode possible avec regex
    // $datefull= $datefull->innertext . '<br>'; //retire les balises html
	// preg_match_all('!\d+!', $datefull, $data, ); //extrait les chiffres dans un tableau $data[0][x]
	// $date = $data[0][2].'-'.$data[0][4].'-'.$data[0][3]; //format date pour mysql
	// print_r($date);

	//old method
	// foreach($html->find('p.cell') as $e) // recupere la valeur du selecteur p ayant class .cell
    // echo $e->innertext . '<br>';
	// preg_match_all('!\d+!', $e, $data);
	// print_r($data);
	// $date = $data[0][5].'-'.$data[0][4].'-'.$data[0][3]; //format date pour mysql
	// print_r($date);
?>
