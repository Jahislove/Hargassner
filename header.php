<!DOCTYPE html>
<html lang="fr">
<?php 
	require_once("conf/config.inc.php");
	require_once("conf/settings.inc.php");
	if (!isset($language)) {
	  $language = 'en';
	}
	include('locale/' . $language . '.php');
?>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="description" content="Supervision en temps réel d'une chaudière à granulés Hargassner. Site en php/MariaDB">
    <title>My Hargassner</title>
    <link rel="icon" type="image/png" href="img/logo.png" />
	<link rel="shortcut icon" href="img/favicon.ico">
	<link rel="apple-touch-icon" href="img/logo.png"/>
	
    <link rel="stylesheet" href="js/bootstrap/css/bootstrap.min.css" /> <!-- utilisé uniquement pour le datepicker -->
    <link rel="stylesheet" href="js/datepicker/bootstrap-datepicker3.min.css" /><!-- utilisé uniquement pour le datepicker -->
	<link rel="stylesheet" href="css/main.css" type="text/css"  />

    <!--<link href='https://fonts.googleapis.com/css?family=Cabin+Condensed' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet' type='text/css'>

    <!-- <script src="https://code.jquery.com/jquery-3.2.1.js"></script>  -->
    <script src="js/jquery-3.6.0.min.js"></script>
    
    <script src="js/datepicker/bootstrap-datepicker.js"></script><!-- utilisé uniquement pour le datepicker -->
    <script src="js/datepicker/bootstrap-datepicker.fr.js" charset="UTF-8"></script><!-- utilisé uniquement pour le datepicker -->
    <script src="js/datepicker/bootstrap-datepicker.de.js" charset="UTF-8"></script><!-- utilisé uniquement pour le datepicker -->
    
	<!--<script src="https://code.highcharts.com/highcharts.js"></script> -->
    <!--<script src="https://code.highcharts.com/highcharts-more.js"></script> -->
	<!--<script src="https://code.highcharts.com/modules/exporting.js"></script> -->
	<script src="js/highcharts.js"></script> 
	<script src="js/highcharts-more.js"></script>  
    <script src="js/exporting.js"></script>

<script type="text/javascript" src="js/codes_erreurs.js">	</script>

<script type="text/javascript">
//stockage variable php pour utilisation dans call_ajax
	var modeCommand_auto = '<?php echo modeCommand_auto; ?>';
	var modeCommand_nigh = '<?php echo modeCommand_nigh; ?>';
	var modeCommand_comf = '<?php echo modeCommand_comf; ?>';
	var modeCommand_stop = '<?php echo modeCommand_stop; ?>';
	var modeCommand_tmpComf = '<?php echo modeCommand_tmpComf; ?>';
	var modeCommand_tmpNigh = '<?php echo modeCommand_tmpNigh; ?>';
	var modeChauff_Summ = '<?php echo modeChauff_Summ; ?>';
	var modeChauff_Comf = '<?php echo modeChauff_Comf; ?>';
	var modeChauff_Red = '<?php echo modeChauff_Red; ?>';
	var modeChauff_Nigh = '<?php echo modeChauff_Nigh; ?>';
	var modeChauff_Stop = '<?php echo modeChauff_Stop; ?>';
	var modeChauff_StopTemp = '<?php echo modeChauff_StopTemp; ?>';
	var modeChauff_StopProg = '<?php echo modeChauff_StopProg; ?>';
</script>
<script type="text/javascript" src="js/call_ajax.js">	</script>

<script type="text/javascript">	
    var histo_live_shift = <?php echo $histo_live_shift;?>;
    var refresh = <?php echo $refresh;?>;
    var id;
    var heure;
    var chart_live; 
    var chart_silo; 
    var etat;


	// auto refresh des données avec ajax
	// l'appel initial de cette fonction se fait dans graph_live.inc.php et dans chaque page

	// var mesFonctions = {
	//   	call_ajax_light : function () {
	//  		call_ajax('call_ajax_light');
		//   },
	//   	call_ajax_full : function () {
	//  		call_ajax('call_ajax_full');
		//   }
	// };
	
    function requestData(type) { 
		//type = call_ajax_regul,call_ajax_light,call_ajax_accueil
        // mesFonctions[type](); //appel ajax au loading dans call_ajax.js
        // id = setInterval(mesFonctions[type],refresh*1000); // recharge les data toutes les x secondes
        call_ajax(type); //appel ajax au loading dans call_ajax.js
        id = setInterval(call_ajax,refresh*1000,type); // recharge les data toutes les 10 secondes(par defaut)
        // setTimeout(stop_refresh, 60000000); // 600000ms  stop rafraichissement apres 10 mn 
    };
    function stop_refresh() {clearInterval(id)};
	
</script>
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
		echo text_ERROR .'<br>';
		echo text_gitko .'<br>';
		echo text_gitmsg .'<br>';
        echo '</div>';
	}

    if ($version < $version_github) {
        echo '<div id="new_version">';
        echo text_new.' : '.$version_github.' - <a href="https://github.com/Jahislove/Hargassner/blob/master/notes_version.txt">Info</a> - <a href="auto-install.php">'.echo text_update.'</a>';
        echo '</div>';
    }

	
	
    // ******************************************************************
    ?>
	<nav>
        <ul class="fancyNav">
            <li id="home">   <a href="index.php" class="homeIcon"><?php echo menu_home;?></a></li>
            <li id="chart">  <a href="page_1_24h.php"><?php echo menu_data;?></a></li>
            <li id="chart2"> <a href="page_2_courbes.php"><?php echo menu_graph;?></a></li>
            <li id="chart3"> <a href="page_3_conso.php"><?php echo menu_consumption;?></a></li>
            <li id="setting"><a href="page_reglages.php"><?php echo menu_settings;?></a></li>
            <li id="about">  <a href="about.php"><?php echo menu_about;?></a></li>
        </ul>
	</nav>

        <table class="etat">
            <tr>
				<th id="etat" >?</th>
				<th class ="tooltipContainer">
					<span class="tooltipEtat"><?php echo text_power;?></span> 
					<span id="puissance" ></span> 
				</th>
				<th class ="tooltipContainer">
					<span id="tooltipModeChauff" class="tooltipEtat">?</span> 
					<span id="modeChauff" ></span> 
				</th>
				<th class ="tooltipContainer">
					<span id="tooltipModeCommand" class="tooltipEtat">?</span> 
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
