<?php
//****vos parametres **************************************************** 	
$IPchaudiere = "192.168.0.198";
$port = 23; //port telnet 

$taille_silo = 4000; // en kg , il s'agit de la capacité max du silo

$refresh = 5; //rafraichissement en sec, ne pas descendre sous les 2 car le telnet de la chaudiere n'arrive plus a repondre assez vite
$histo_temps = 30; //historique du graphe live en mn


//*****couleurs ************************************************	
$color_TdepD = '#781BE1'; //F62B07
$color_TdepE = '#EA7C01';
$color_Tchaud = '#E662CC';
$color_Text = '#11C4F0';
$color_TextM = '#72EA01';
$color_Tint = '#19AF09';
$color_etat = '#01AEE3';
$color_puiss = 'red';
$color_fum = 'grey';
$color_O2 = '#01DF01';
$color_gran = '#D07705';//B8AD0E
$color_aspi = '#1F4AEA';

$color_legend = '#DBEDFF'; //65AEF8

//*****ne pas modifier ************************************************	
$histo_live_shift = $histo_temps * 60 / $refresh; // nombre de valeur avant de shift
$histo_live_X = $histo_temps * 60; // init longueur axe X du graphe live 



//Chart localization
$months = "['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin',  'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre']";
$weekdays = "['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi']";
$shortMonths = "['Janv', 'Fev', 'Mars', 'Avr', 'Mai', 'Juin',  'Juil', 'Aout', 'Sept', 'Oct', 'Nov', 'Dec']";
$thousandsSep = "''"; // thousands separator 
    
    

?>