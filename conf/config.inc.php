<?php
//****vos parametres **************************************************** 	
// licence GPL-3.0-or-later

// chaudiere IP/boiler IP
$IPchaudiere = "192.168.0.198"; 

// password pour la page reglages /password for settings page
$password_settings = 'password';

// chemin réel pour stockage des logs /real path for log file
$cheminLog = "/volume1/web/hargassner";

$port = 23; //port telnet, ne pas modifier / no need to change

$taille_silo = 4000; // silo max size / en kg ,  capacité max du silo
$consoHeure = 38; // = parameter R8a in factory parameter of the boiler

// MySQL config
$hostname = "127.0.0.1:3307"; //127.0.0.1 si la BDD est sur la meme machine que le serveur web , sinon IP . 3306 MySQL 5 , 3307 MySQL 10
$database = "hargassner"; // nom de la BDD
$username = "hargassner"; // utilisateur mysql
$password = "password"; //  a personnaliser

//*****couleurs (code couleur HTML)************************************************	
$color_TdepD = '#781BE1'; 
$color_TdepE = '#EA7C01';
$color_Tchaud = '#E662CC';
$color_Tchauddoit = '#6F3263';
$color_Text = '#11C4F0';
$color_TextM = '#9f19f0'; 
$color_Tint = '#19AF09';
$color_etat = '#01AEE3';
$color_puiss = 'red';
$color_fum = 'black';
$color_O2 = '#01DF01';
$color_O2doit = '#0C750C';
$color_gran = '#108BE0'; //108BE0  ff9900
$color_aspi = '#1F4AEA';
$color_extrac = '#04E9A4';
$color_varF = '#1F4AEA';
$color_varK = '#E900BB';
$color_regul = '#0040A8';
$color_bois = '#E97E04';
$color_decend = '#AAFFAC';
$color_legend = '#DBEDFF'; 
$color_ECS_T = '#b7950b';
$color_ECS_etat = '#B4EDFE';

//*****ne pas modifier ci dessous/ do not modify below************************************************	
$mode_conn = 'telnet'; //or  serial for old boiler
$refresh = 10; //refresh main page / rafraichissement en seconde de l'etat de la chaudiere , ne pas descendre sous les 2 car le telnet de la chaudiere n'arrive plus a repondre assez vite
$histo_temps = 30; //historique du graphique de la page d'accueil en mn
$histo_live_shift = $histo_temps * 60 / $refresh; // nombre de valeur avant de shift
$histo_live_X = $histo_temps * 60; // init longueur axe X du graphe live 

?>