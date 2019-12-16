</head>

<body>
    <?php
    // **********recherche nouvelle version******************************
    require_once("conf/version.php");
    $config_github = fopen('https://raw.githubusercontent.com/Jahislove/Hargassner/master/conf/version.php', 'r'); 
    if ($config_github) {
        while (!feof($config_github)) {
            $ligne = fgets($config_github); //lit chaque ligne du fichier
            $ligne_version = strstr($ligne,'version'); //recherche la chaine 'version'
            if ($ligne_version) {
                $version_github = floatval(explode('=',$ligne_version)[1]); // explode en champ, et extrait la valeur en decimal du champ 1
				break;
            }
        }
        fclose($config_github);
    } else {
		echo '<div id="new_version">';
		echo 'impossible de joindre github pour vérifier les mises a jour, ';
		echo "si le problème persiste vérifiez que votre serveur php est bien lancé avec les extensions openssl et zip";
        echo '</div>';
	}

    if ($version < $version_github) {
        echo '<div id="new_version">';
        echo 'Nouvelle version disponible : '.$version_github.' - <a href="https://github.com/Jahislove/Hargassner/blob/master/notes_version.txt">Notes de version</a> - <a href="auto-install.php">Installation</a>';
        echo '</div>';
    }
	//ajout nouveau parametre dans config.php
	// si un fichier de nouveau parametre existe
	if (is_file('conf/new_param.txt')) {
		
		$new_param = file('conf/new_param.txt');// ecrit parametres dans tableau
		$new_param = array_reverse($new_param); // inverse le tableau
		$k = floor(count($new_param)/2);// divise par 2 pour avoir le nombre de couple

		$old_lignes = file('conf/config.inc.php'); //ecrit fichier dans tableau
		for ($i = 0; $i < $k; $i++){
			array_splice($old_lignes,$new_param[$i*2],0,$new_param[$i*2+1]);// insert lignes
		}
		$new_content = join('',$old_lignes);
		$fp = fopen('conf/config.inc.php','w');
		$write = fwrite($fp, $new_content);
		fclose($fp);

		// avertir
		
		unlink('conf/new_param.txt');
    }

	
	
    // ******************************************************************
    ?>

	<nav>
        <ul class="fancyNav">
            <li id="home">   <a href="index.php" class="homeIcon">Accueil</a></li>
            <li id="chart">  <a href="page_1_24h.php">Régulation</a></li>
            <li id="chart2"> <a href="page_2_courbes.php">Variables</a></li>
            <li id="chart3"> <a href="page_3_conso.php">Consommation</a></li>
            <li id="about">  <a href="about.php">a propos</a></li>
        </ul>
	</nav>

	<div id="etat" class="etat">?</div>    
	<!-- <div>
        <table class="TableInstant">
            <tr>
			<th id="etat" >?</th>
             <th id="T°ext" >. </th>
            <th id="T°depart" >. </th> 
			</tr>
        </table>
	</div>-->
