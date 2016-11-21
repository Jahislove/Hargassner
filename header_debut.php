<!DOCTYPE html>
<html lang="fr">
    <?php require_once("conf/config.inc.php");?>
    <?php  ?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>My Hargassner</title>
    <link rel="icon" type="image/png" href="img/logo.png" />

    <link rel="stylesheet" href="js/bootstrap/css/bootstrap.css" /> <!-- utilisé uniquement pour le datepicker -->
    <link rel="stylesheet" href="js/datepicker/bootstrap-datepicker3.min.css" /><!-- utilisé uniquement pour le datepicker -->
	<link rel="stylesheet" href="css/main.css" type="text/css"  />

    <link href='http://fonts.googleapis.com/css?family=Cabin+Condensed' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet' type='text/css'>

    <script src="http://code.jquery.com/jquery-2.1.4.js"></script>
    <script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
    
    <script src="js/datepicker/bootstrap-datepicker.min.js"></script><!-- utilisé uniquement pour le datepicker -->
    <script src="js/datepicker/bootstrap-datepicker.fr.min.js" charset="UTF-8"></script><!-- utilisé uniquement pour le datepicker -->
    <script src="js/highcharts.js"></script> 
    <script src="js/exporting.js"></script> 
    

<script type="text/javascript">	
    var histo_live_shift = <?php echo $histo_live_shift;?>;
    var refresh = <?php echo $refresh;?>;
    var id;
    var heure;
    var chart_live; 
    var chart_silo; 
    var etat;

    // auto refresh des données avec ajax
    function requestData() { 
        call_ajax(); //appel ajax au loading dans call_ajax_full.js
        id = setInterval(call_ajax,refresh*1000); 
        setTimeout(stop_refresh, 60000000); // 600000ms  stop rafraichissement apres 10 mn 
    };
    function stop_refresh() {clearInterval(id)};
</script>
