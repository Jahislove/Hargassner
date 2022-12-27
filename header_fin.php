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

	
	
    // ******************************************************************
    ?>

	<nav>
        <ul class="fancyNav">
            <li id="home">   <a href="index.php" class="homeIcon">Accueil</a></li>
            <li id="chart">  <a href="page_1_24h.php">Régulation</a></li>
            <li id="chart2"> <a href="page_2_courbes.php">Variables</a></li>
            <li id="chart3"> <a href="page_3_conso.php">Consommation</a></li>
            <li id="setting"><a href="page_reglages.php">Réglages</a></li>
            <li id="about">  <a href="about.php">a propos</a></li>
        </ul>
	</nav>

	<!-- <div id="etat" class="etat">?</div>     -->
	<div>
        <table class="etat">
            <tr>
				<th id="etat" >?</th>
				<th class ="tooltipContainer">
					<span id="tooltipModeChauff" class="tooltipEtat">?</span> 
					<span id="modeChauff" ></span> 
				</th>
				<th class ="tooltipContainer">
					<span class="tooltipEtat" >
						<span id="tooltipModeCommand">?</span> 
					</span>
					<span id="modeCommand" ></span>
				</th> 
			</tr>
        </table>
        <table id="erreur" class="erreur erreurNonVisible">
			<tr>
				<th id="erreurNumber" ></th>
				<th id="erreurText" ></th>
			</tr>
        </table>
	</div>
