// ######## rafraichissement des données ########################################################
// voir channel-nanoPK-vxxxx.txt pour les numeros de canaux

function call_ajax() {
$.ajax({
    url: 'json_telnet.php', 
    cache: false,
	//dataType : "JSON",
    success: function(channel) {
        //heure = channel[0]; // stock la date puis
        //channel.shift(); // supprime la 1ere valeur (date) et decale les autres pour etre synchro avec les numero de channel

		// initialise les variables (utilisées) au dela du chanel 164 au cas ou le firmware < 14.g 
		// if (typeof channel[183] === 'undefined') {
			// channel[183] = 0;
			// channel[181] = 0;
		// }		 
        // animation du dessin par chargement de class CSS

        // remplace valeur numerique de "etat" par un texte
        switch(channel['etat']) { 
            case 0:
                etat = '0';
                break;
            case 1:
                etat = 'Arrêt';
                document.getElementById('nano-D1').className = 'foyer_eteint';
                document.getElementById('nano-C1').className = 'coeur_eteint';
                document.getElementById('nano-D2').className = 'vis_stop';
                document.getElementById('nano-B1').className = 'ressort_fixe';
                document.getElementById('nano-E1').className = 'cendrier_ferme';
				break;
            case 2:
                etat = 'Allumage';
                document.getElementById('nano-D1').className = 'foyer_allumage';
                document.getElementById('nano-D2').className = 'vis_stop';
                document.getElementById('nano-B1').className = 'ressort_fixe';
                break;
            case 3:
                etat = 'Démarrage';
                document.getElementById('nano-D2').className = 'vis_stop';
                document.getElementById('nano-B1').className = 'ressort_fixe';
                break;
            case 4:
                etat = 'Controle allumage';
                document.getElementById('nano-D1').className = 'foyer_reprise';
                document.getElementById('nano-D2').className = 'vis_marche';
                break;
            case 5:
                etat = 'Allumage électrique';
                document.getElementById('nano-D1').className = 'foyer_allumage';
                break;
            case 6:
                etat = 'Démarrage combustion';
                document.getElementById('nano-D1').className = 'foyer_reprise';
                document.getElementById('nano-E1').className = 'cendrier_ventil';
                document.getElementById('nano-D2').className = 'vis_marche';
                document.getElementById('nano-B1').className = 'ressort_fumee';
                break;
            case 7:
                etat = 'Combustion';
                document.getElementById('nano-C1').className = 'coeur_combustion'; 
                document.getElementById('nano-D1').className = 'foyer_combustion';
                document.getElementById('nano-E1').className = 'cendrier_ventil';
                document.getElementById('nano-D2').className = 'vis_marche';
                document.getElementById('nano-B1').className = 'ressort_fumee';
                break;
            case 8:
                etat = 'En veille';
                document.getElementById('nano-C1').className = 'coeur_eteint';
                document.getElementById('nano-D1').className = 'foyer_veille';
                document.getElementById('nano-E1').className = 'cendrier_ferme';
                document.getElementById('nano-D2').className = 'vis_stop';
                document.getElementById('nano-B1').className = 'ressort_fixe';
                break;
            case 9:
                etat = 'Arrêt pour décendrage';
                document.getElementById('nano-C1').className = 'coeur_eteint';
                document.getElementById('nano-D1').className = 'foyer_veille';
                document.getElementById('nano-D2').className = 'vis_stop';
                break;
            case 10:
                etat = 'Décendrage';
                document.getElementById('nano-E1').className = 'cendrier_mouvt';
                break;
            case 11:
                etat = 'Refroidissement sécurité';
                break;
            case 12:
                etat = 'Nettoyage';
                document.getElementById('nano-E1').className = 'cendrier_ouvert';
                document.getElementById('nano-B1').className = 'ressort_anime';
                break;
            case 17:
                etat = 'Assistant de combustion';
            default:
                etat = 'inconnu';
                break;
        }
        
        // elements qui ne dependent pas d'un etat , mais de la valeur d'un channel
        // l'extracteur de fumée 
        if ( channel['extract'] > 0 ) {
            document.getElementById('nano-A1').className = 'extr_anime'; 
        }
        else {
            document.getElementById('nano-A1').className = 'extr_fixe'; 
        }
        
		// test presence et remplissage ballon ECS 
		var TempECS = channel['TempECS'];
		switch ( true ) {
			case (TempECS==140): // ballon ECS absent
				channel['TempECS'] = "null";
				break;
			case (TempECS<20):
				document.getElementById('ballonECS-bulle').className = 'visible ballonECS-0 tuyau-ECS';
				break;
			case (TempECS<30):
				document.getElementById('ballonECS-bulle').className = 'visible ballonECS-10 tuyau-ECS';
				break;
			case (TempECS<40):
				document.getElementById('ballonECS-bulle').className = 'visible ballonECS-20 tuyau-ECS';
				break;
			case (TempECS<43):
				document.getElementById('ballonECS-bulle').className = 'visible ballonECS-30 tuyau-ECS';
				break;
			case (TempECS<46):
				document.getElementById('ballonECS-bulle').className = 'visible ballonECS-40 tuyau-ECS';
				break;
			case (TempECS<49):
				document.getElementById('ballonECS-bulle').className = 'visible ballonECS-50 tuyau-ECS';
				break;
			case (TempECS<52):
				document.getElementById('ballonECS-bulle').className = 'visible ballonECS-60 tuyau-ECS';
				break;
			case (TempECS<55):
				document.getElementById('ballonECS-bulle').className = 'visible ballonECS-70 tuyau-ECS';
				break;
			case (TempECS<58):
				document.getElementById('ballonECS-bulle').className = 'visible ballonECS-80 tuyau-ECS';
				break;
			case (TempECS<=60):
				document.getElementById('ballonECS-bulle').className = 'visible ballonECS-90 tuyau-ECS';
				break;
			default:
				document.getElementById('ballonECS-bulle').className = 'visible ballonECS-100 tuyau-ECS';
		}
		
		// test diagnostic
		// channel[181] = parseInt(channel[181]);
		// if ( channel[181] >= 2000 ) {
			// document.getElementById('etat').className = 'etat_erreur';
			// switch ( true ) {
				// case (channel[181]==2003): 
					// etat = etat + '/Temps de Remplissage dépassé';
					// break;
				// case (channel[181]==2009):
					// etat = etat + '/défaut';
					// break;
				// default:
					// etat = etat + '/alerte inconnue';
			// }
        // } else {
			// document.getElementById('etat').className = 'etat';
		// }			
		
			
        // rafraichissement etat
        document.getElementById('etat').innerHTML = etat;
        
        // rafraichissement des bulles
        document.getElementById('extr-texte').innerHTML =  channel['extract'] + '%';
        document.getElementById('fumee-texte').innerHTML =  channel['Fumee'] + '°C';
        document.getElementById('Tchaud-texte').innerHTML =  channel['chaudiereEst'] + '°C';
        document.getElementById('puiss-texte').innerHTML =  channel['puissance'] + '%';
        document.getElementById('Tint-texte').innerHTML =  channel['Tint'] + '°C';
        document.getElementById('Text-texte').innerHTML =  channel['Text'] + '°C';
        document.getElementById('radiateur-texte').innerHTML =  channel['departEst'] + '°C';
        document.getElementById('ballonECS-texte').innerHTML =  channel['TempECS'] + '°C';
        document.getElementById('bois-texte').innerHTML =  channel['bois'] + '%';
        
		// rafraichissement des pompes
		if ( channel['pompe-rad'] > 0 ) {
			document.getElementById('pompe-radiat').className = 'pompeON';
        } else {
			document.getElementById('pompe-radiat').className = 'pompeOFF';
		}	
		if ( channel['pompe-ECS'] > 0 ) { //old: 183   Ballon ECS 0:off , 1:charge, 2:recyclage 
			document.getElementById('pompe-ECS').className = 'pompeON';
        } else {
			document.getElementById('pompe-ECS').className = 'pompeOFF';
		}	

        // rafraichissement graphe silo
        chart_silo.series[0].points[0].update(channel['silo']);

        // aspiration RAPS : desactivé car parametre non connu
        // if ( channel[?] == 2000 ) {
            // document.getElementById('nano-A2').className = 'RAPS_anime'; 
        // }
        // else {
            // document.getElementById('nano-A2').className = 'RAPS_fixe'; 
        // }

        // rafraichissement graphe live
        var shift = chart_live.series[0].data.length > histo_live_shift;
        chart_live.series[0].addPoint([channel['heure'], channel['etat']], true, shift);
        chart_live.series[1].addPoint([channel['heure'], channel['chaudiereEst']], true, shift);
        chart_live.series[2].addPoint([channel['heure'], channel['extract']], true, shift);
        chart_live.series[3].addPoint([channel['heure'], channel['bois']], true, shift);
        chart_live.series[4].addPoint([channel['heure'], channel['puissance']], true, shift);
        chart_live.series[5].addPoint([channel['heure'], channel['departEst']], true, shift);
        //chart_live.series[6].addPoint([heure, channel[54]], true, shift);
        //chart_live.series[7].addPoint([heure, channel[160]], true, shift);  
            
        // rafraichissement tableau gauche et droite
        Gauche1.innerHTML = channel['lambda']; 
        Gauche2.innerHTML = channel['Tint'];    
        Gauche3.innerHTML = channel['Text'];    
        Gauche4.innerHTML = channel['TextMoy'];    
        Gauche5.innerHTML = channel['departEst'];    
        Gauche6.innerHTML = channel['departDoit'];    
        Gauche7.innerHTML = channel['chaudiereEst'];    
        Gauche8.innerHTML = channel['chaudiereDoit'];    
        Gauche9.innerHTML = channel['retourEst'];    
        Gauche10.innerHTML = channel['retourDoit'];    

        Droite1.innerHTML = channel['tempsDecend'];    
        Droite2.innerHTML = channel['tempsVis'];    
        Droite3.innerHTML = channel['mvtGrille'];    
        Droite4.innerHTML = channel['PelletConso'];    
        Droite5.innerHTML = channel['PelletRest'];    
        Droite6.innerHTML = channel['TempECS'];    
        Droite7.innerHTML = channel['pompe-ECS'];    
        Droite8.innerHTML = channel['variableF'];    
        Droite9.innerHTML = channel['variableK'];    
    },
});


};


//alterne affichage bulles/tableau
function clic() {
    if ( bulles.className == 'visible' ) {
        bulles.className = 'hidden';
        tableau.className = 'visible';
    }
    else {
        bulles.className = 'visible';
        tableau.className ='hidden';
    }
};