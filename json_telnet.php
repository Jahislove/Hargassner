
<?php 
// licence GPL-3.0-or-later

// appelé par ajax, permet d'interroger la chaudiere par telnet et retourne la reponse en JSON 
// pour les anciennes chaudiere ne disposant que du port serie , on remplace le telnet par une interrogation mysql
	header("Content-type: text/json");
    require_once("conf/config.inc.php");

if ($mode_conn == 'serial'){ 
    //ouverture port serie
	$query = "SELECT * FROM data 
			ORDER by id DESC
			LIMIT 1" ;
			  
	connectMaBase($hostname, $database, $username, $password);
	$req = mysql_query($query) ;
	mysql_close();
	
    $data = mysql_fetch_row($req);
    $data[1] = strtotime($data[1]) * 1000;
	array_shift ($data); // supprime le champ id
	
} else {
    //ouverture socket telnet
    $fp = fsockopen ($IPchaudiere, $port, $errno, $errstr);
    if(!$fp){
        echo "$errstr";
    }
    else {
        $reponse=fgets ($fp,1024); //lecture reponse telnet
        fclose($fp);
    }
    $data = explode(" ",$reponse); //transforme la reponse telnet (separateur espace) en array
	$data[0] = time() * 1000;// remplace pm par la date au format javascript (unix *1000)
}

// a partir du firmware 14.0i , l'ordre des parametres a changé
// on remet les valeurs dans l'ordre attendu par le site
if ($firmware == '14i' || $firmware == '14j' || $firmware == '14k'){
	$T = $data; // reprends le tableau data
	array_shift($T); // supprime la date pour aligner les chanels

	//initialisation du tableau attendu
	for ($i = 1; $i <= 190; $i++) {
		$c[]=0;
	}

	// on rempli le tableau attendu avec les valeurs reçues du telnet

	$c[0]=$T[0]		;$c[20]=$T[93]	;$c[40]=$T[87]	;$c[60]=$T[13]		;$c[80]=$T[131]	;$c[100]=$T[55]		;$c[120]=$T[134]	;$c[140]=$T[70]		;$c[160]=$T[27]		;$c[180]=$T[42]  ;
	$c[1]=$T[1]		;$c[21]=$T[56]	;$c[41]=$T[null];$c[61]=$T[14]		;$c[81]=$T[48]	;$c[101]=$T[61]		;$c[121]=$T[null]	;$c[141]=$T[76]		;$c[161]=$T[null]	;$c[181]=$T[null];
	$c[2]=$T[2]		;$c[22]=$T[62]	;$c[42]=$T[null];$c[62]=$T[39]		;$c[82]=$T[null];$c[102]=$T[67]		;$c[122]=$T[null]	;$c[142]=$T[82]		;$c[162]=$T[null]	;$c[182]=$T[null];
	$c[3]=$T[3]		;$c[23]=$T[57]	;$c[43]=$T[101]	;$c[63]=$T[null]	;$c[83]=$T[null];$c[103]=$T[73]		;$c[123]=$T[null]	;$c[143]=$T[88]		;$c[163]=$T[null]	;$c[183]=$T[null];
	$c[4]=$T[4]		;$c[24]=$T[63]	;$c[44]=$T[102]	;$c[64]=$T[null]	;$c[84]=$T[54]	;$c[104]=$T[79]		;$c[124]=$T[null]	;$c[144]=$T[null]	;$c[164]=$T[null]	;$c[184]=$T[null];
	$c[5]=$T[5]		;$c[25]=$T[null];$c[45]=$T[53]	;$c[65]=$T[null]	;$c[85]=$T[60]	;$c[105]=$T[85]		;$c[125]=$T[null]	;$c[145]=$T[null]	;$c[165]=$T[null]	;$c[185]=$T[null];
	$c[6]=$T[15]	;$c[26]=$T[null];$c[46]=$T[59]	;$c[66]=$T[null]	;$c[86]=$T[66]	;$c[106]=$T[91]		;$c[126]=$T[null]	;$c[146]=$T[109]	;$c[166]=$T[null]	;$c[186]=$T[null];
	$c[7]=$T[16]	;$c[27]=$T[95]	;$c[47]=$T[65]	;$c[67]=$T[null]	;$c[87]=$T[72]	;$c[107]=$T[104]	;$c[127]=$T[null]	;$c[147]=$T[110]	;$c[167]=$T[null]	;$c[187]=$T[null];
	$c[8]=$T[17]	;$c[28]=$T[96]	;$c[48]=$T[71]	;$c[68]=$T[null]	;$c[88]=$T[78]	;$c[108]=$T[105]	;$c[128]=$T[45]		;$c[148]=$T[111]	;$c[168]=$T[108]	;$c[188]=$T[null];
	$c[9]=$T[19]	;$c[29]=$T[68]	;$c[49]=$T[77]	;$c[69]=$T[null]	;$c[89]=$T[84]	;$c[109]=$T[106]	;$c[129]=$T[26]		;$c[149]=$T[112]	;$c[169]=$T[117]	;$c[189]=$T[null];
	$c[10]=$T[21]	;$c[30]=$T[74]	;$c[50]=$T[83]	;$c[70]=$T[null]	;$c[90]=$T[90]	;$c[110]=$T[107]	;$c[130]=$T[37]		;$c[150]=$T[113]	;$c[170]=$T[118]	;$c[190]=$T[null];
	$c[11]=$T[22]	;$c[31]=$T[69]	;$c[51]=$T[89]	;$c[71]=$T[null]	;$c[91]=$T[94]	;$c[111]=$T[33]		;$c[131]=$T[null]	;$c[151]=$T[114]	;$c[171]=$T[119]	;
	$c[12]=$T[23]	;$c[32]=$T[75]	;$c[52]=$T[7]	;$c[72]=$T[null]	;$c[92]=$T[97]	;$c[112]=$T[32]		;$c[132]=$T[null]	;$c[152]=$T[115]	;$c[172]=$T[120]	;
	$c[13]=$T[24]	;$c[33]=$T[null];$c[53]=$T[6]	;$c[73]=$T[124]		;$c[93]=$T[100]	;$c[113]=$T[34]		;$c[133]=$T[null]	;$c[153]=$T[116]	;$c[173]=$T[121]	;
	$c[14]=$T[null]	;$c[34]=$T[null];$c[54]=$T[28]	;$c[74]=$T[125]		;$c[94]=$T[103]	;$c[114]=$T[35]		;$c[134]=$T[8]		;$c[154]=$T[36]		;$c[174]=$T[122]	;
	$c[15]=$T[25]	;$c[35]=$T[98]	;$c[55]=$T[29]	;$c[75]=$T[126]		;$c[95]=$T[40]	;$c[115]=$T[46]		;$c[135]=$T[null]	;$c[155]=$T[null]	;$c[175]=$T[123]	;
	$c[16]=$T[50]	;$c[36]=$T[99]	;$c[56]=$T[9]	;$c[76]=$T[127]		;$c[96]=$T[41]	;$c[116]=$T[30]		;$c[136]=$T[38]		;$c[156]=$T[null]	;$c[176]=$T[44]		;
	$c[17]=$T[51]	;$c[37]=$T[80]	;$c[57]=$T[10]	;$c[77]=$T[128]		;$c[97]=$T[49]	;$c[117]=$T[31]		;$c[137]=$T[52]		;$c[157]=$T[null]	;$c[177]=$T[43]		;
	$c[18]=$T[null]	;$c[38]=$T[96]	;$c[58]=$T[11]	;$c[78]=$T[129]		;$c[98]=$T[null];$c[118]=$T[132]	;$c[138]=$T[58]		;$c[158]=$T[null]	;$c[178]=$T[18]		;
	$c[19]=$T[92]	;$c[39]=$T[81]	;$c[59]=$T[12]	;$c[79]=$T[130]		;$c[99]=$T[47]	;$c[119]=$T[133]	;$c[139]=$T[64]		;$c[159]=$T[null]	;$c[179]=$T[20]		;

	// on remet l'heure au debut
	array_unshift($c, time() * 1000);
	$data = $c;
}

// on renvoi une des reponses
echo json_encode($data, JSON_NUMERIC_CHECK);  //numeric_check : remove ""


?>
