<?php
//****vos parametres **************************************************** 	
$IPchaudiere = "192.168.0.198";
$port = 23; //port telnet 
$taille_silo = 4000; // en kg


	
//*********************************************************************	
$histo_live = 2500;
$refresh = 5000; //rafraichissement en ms, ne pas descendre sous les 2000 car le telnet de la chaudiere n'arrive plus a repondre assez vite




//Chart localization
$months = "['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin',  'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre']";
$weekdays = "['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi']";
$shortMonths = "['Janv', 'Fev', 'Mars', 'Avr', 'Mai', 'Juin',  'Juil', 'Aout', 'Sept', 'Oct', 'Nov', 'Dec']";
$thousandsSep = "''"; // thousands separator 
    
    

?>