<?php
//****vos parametres **************************************************** 	
$IPchaudiere = "192.168.0.198"; // indiquez l'IP de votre chaudiere
$port = 23; //port telnet, ne pas modifier

$taille_silo = 4000; // en kg , il s'agit de la capacité max du silo

$refresh = 10; //rafraichissement en sec de l'etat de la chaudiere , ne pas descendre sous les 2 car le telnet de la chaudiere n'arrive plus a repondre assez vite
$histo_temps = 30; //historique du graphique de la page d'accueil en mn


//*****couleurs ************************************************	
$color_TdepD = '#781BE1'; 
$color_TdepE = '#EA7C01';
$color_Tchaud = '#E662CC';
$color_Text = '#11C4F0';
$color_TextM = '#6B10E0'; 
$color_Tint = '#19AF09';
$color_etat = '#01AEE3';
$color_puiss = 'red';
$color_fum = 'grey';
$color_O2 = '#01DF01';
$color_gran = '#108BE0';
$color_aspi = '#1F4AEA';
$color_extrac = '#04E9A4';
$color_varF = '#1F4AEA';
$color_varK = '#E900BB';
$color_regul = '#A0A0A0';
$color_bois = '#E97E04';

$color_legend = '#DBEDFF'; 

//*****ne pas modifier ci dessous************************************************	
$histo_live_shift = $histo_temps * 60 / $refresh; // nombre de valeur avant de shift
$histo_live_X = $histo_temps * 60; // init longueur axe X du graphe live 

//Chart localization
$months = "['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin',  'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre']";
$weekdays = "['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi']";
$shortMonths = "['Janv', 'Fev', 'Mars', 'Avr', 'Mai', 'Juin',  'Juil', 'Aout', 'Sept', 'Oct', 'Nov', 'Dec']";
$thousandsSep = "''"; // thousands separator 
?>