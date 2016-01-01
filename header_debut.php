<!DOCTYPE html>
<html>
    <?php require_once("conf/config.inc.php");?>
    <?php require_once("conf/connectBDD.inc.php");?>
<head>
    <title>My nanoPK</title>
    <link rel="icon" type="image/png" href="img/home.png" />
	<link type="text/css" rel="stylesheet" href="css/main.css" />
    <link href='http://fonts.googleapis.com/css?family=Cabin+Condensed' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet' type='text/css'>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="http://code.jquery.com/jquery-2.1.4.js"></script>
    <script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script> 
    <!-- <script src="https://code.highcharts.com/stock/highstock.js"></script>-->

<script type="text/javascript">	
    var histo_live_shift = <?php echo $histo_live_shift;?>;
    var refresh = <?php echo $refresh;?>;
    var id;
    var heure;
    var chart_live; 
    var chart_silo; 
    var etat;

    // auto refresh des données avec ajax
    // requestData est appelée la 1ere fois par graph_live.php puis boucle toute seule
    function requestData() { 
        call_ajax(); //appel ajax au loading
        id = setInterval(call_ajax,refresh*1000); 
        setTimeout(stop_refresh, 6000000); // 600000ms  stop rafraichissement apres 10 mn 
    };
    function stop_refresh() {clearInterval(id)};
</script>
