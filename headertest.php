<!DOCTYPE html>
<html>
<head>
    <title>My nanoPK</title>
    <link rel="icon" type="image/png" href="img/home.png" />
	<link type="text/css" rel="stylesheet" href="css/main.css" />
    <link href='http://fonts.googleapis.com/css?family=Cabin+Condensed' rel='stylesheet' type='text/css'>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="http://code.highcharts.com/stock/1.3.10/highstock.js"></script>
    <script src="http://code.highcharts.com/4.0/modules/solid-gauge.src.js"></script>
	<script src="http://code.highcharts.com/stock/1.3.10/highcharts-more.js"></script> -->
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    
    
    
    
  
    
   

</head>

<body>
	<?php require_once("conf/config.inc.php");?>
	<?php require_once("conf/connectBDD.inc.php");?>
    
	<header>
		<h1>
		    <!--My Own 
		    <IMG SRC="img/Owl-Intuition.png" ALT="Owl intuition" WIDTH=115 HEIGHT=33 >
		     <IMG SRC="img/Owl-Logo.png" ALT="Logo" WIDTH=30 HEIGHT=30 > -->
		</h1>
	</header>

	<nav>
        <ul class="fancyNav">
            <li id="home">   <a href="index.php" class="homeIcon">Accueil</a></li>
            <li id="chart">  <a href="graph_highchart.php">last 12h</a></li>
            <li id="eco">    <a href="graph_highchart2.php">2</a></li>
            <li id="cost">   <a href="graph_highchart3.php">3</a></li>
            <li id="spa">    <a href="graph_highchart3.php">3</a></li>
            <li id="temp">   <a href="graph_highchart3.php">3</a></li>
            <li id="about">  <a href="about.php">a propos</a></li>
        </ul>
	</nav>

	
	

