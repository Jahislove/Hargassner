// ######## rafraichissement des données ########################################################
// voir channel-nanoPK-vxxxx.txt pour les numeros de canaux

function call_ajax() {

$.ajax({
    url: 'json_telnet.php', 
    cache: false,
	//dataType : "JSON",
    success: function(channel) {
        heure = channel[0]; // stock la date puis
        channel.shift(); // supprime la 1ere valeur (date) et decale les autres pour etre synchro avec les numero de channel

		// initialise les variables (utilisées) au dela du chanel 164 au cas ou le firmware < 14.g 
		if (typeof channel[183] === 'undefined') {
			channel[183] = 0;
			channel[181] = 0;
		}		 
        // animation du dessin par chargement de class CSS

        // remplace valeur numerique de "etat" par un texte
        switch(channel[0]) { 
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
        if ( channel[53] > 0 ) {
            document.getElementById('nano-A1').className = 'extr_anime'; 
        }
        else {
            document.getElementById('nano-A1').className = 'extr_fixe'; 
        }
        
		// test presence et remplissage ballon ECS 
		var TempECS = channel[27];
		switch ( true ) {
			case (TempECS==140): // ballon ECS absent
				channel[27] = "null";
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
        document.getElementById('extr-texte').innerHTML =  channel[53] + '%';
        document.getElementById('fumee-texte').innerHTML =  channel[5] + '°C';
        document.getElementById('Tchaud-texte').innerHTML =  channel[3] + '°C';
        document.getElementById('puiss-texte').innerHTML =  channel[134] + '%';
        document.getElementById('Tint-texte').innerHTML =  channel[138] + '°C';
        document.getElementById('Text-texte').innerHTML =  channel[6] + '°C';
        document.getElementById('radiateur-texte').innerHTML =  channel[21] + '°C';
        document.getElementById('ballonECS-texte').innerHTML =  channel[27] + '°C';
        document.getElementById('bois-texte').innerHTML =  channel[56] + '%';
        
		// rafraichissement des pompes
		if ( channel[23] > 0 ) {
			document.getElementById('pompe-radiat').className = 'pompeON';
        } else {
			document.getElementById('pompe-radiat').className = 'pompeOFF';
		}	
		if ( channel[92] > 0 ) { //old: 183   Ballon ECS 0:off , 1:charge, 2:recyclage 
			document.getElementById('pompe-ECS').className = 'pompeON';
        } else {
			document.getElementById('pompe-ECS').className = 'pompeOFF';
		}	

        // rafraichissement graphe silo
        chart_silo.series[0].points[0].update(channel[115]);

        // aspiration RAPS : desactivé car parametre non connu
        // if ( channel[?] == 2000 ) {
            // document.getElementById('nano-A2').className = 'RAPS_anime'; 
        // }
        // else {
            // document.getElementById('nano-A2').className = 'RAPS_fixe'; 
        // }

        // rafraichissement graphe live
        var shift = chart_live.series[0].data.length > histo_live_shift;
        chart_live.series[0].addPoint([heure, channel[0]], true, shift);
        chart_live.series[1].addPoint([heure, channel[3]], true, shift);
        chart_live.series[2].addPoint([heure, channel[53]], true, shift);
        chart_live.series[3].addPoint([heure, channel[56]], true, shift);
        chart_live.series[4].addPoint([heure, channel[134]], true, shift);
        chart_live.series[5].addPoint([heure, channel[21]], true, shift);
        //chart_live.series[6].addPoint([heure, channel[54]], true, shift);
        //chart_live.series[7].addPoint([heure, channel[160]], true, shift);  
            
        // rafraichissement tableau gauche et droite
        Gauche1.innerHTML = channel[1]; 
        Gauche2.innerHTML = channel[138];    
        Gauche3.innerHTML = channel[3];    
        Gauche4.innerHTML = channel[4];    
        Gauche5.innerHTML = channel[5];    
        Gauche6.innerHTML = channel[6];    
        Gauche7.innerHTML = channel[7];    
        Gauche8.innerHTML = channel[21];    
        Gauche9.innerHTML = channel[23];    
        Gauche10.innerHTML = channel[54];    
        Gauche11.innerHTML = channel[160];    
        Gauche12.innerHTML = channel[12];    
        Gauche13.innerHTML = channel[13];    
        Gauche14.innerHTML = channel[15];    
        Gauche15.innerHTML = channel[25];    
        Gauche16.innerHTML = channel[26];    
        Gauche17.innerHTML = channel[45];    
        Gauche18.innerHTML = channel[181];    
		Gauche19.innerHTML = channel[110];    
        Gauche20.innerHTML = channel[129];    

        Droite1.innerHTML = channel[98];    
        Droite2.innerHTML = channel[111];    
        Droite3.innerHTML = channel[112];    
        Droite4.innerHTML = channel[113];    
        Droite5.innerHTML = channel[114];    
        Droite6.innerHTML = channel[99];    
        Droite7.innerHTML = channel[115];    
        Droite8.innerHTML = channel[155];    
        Droite9.innerHTML = channel[156];    
        Droite10.innerHTML = channel[157];    
        Droite11.innerHTML = channel[158];    
        Droite12.innerHTML = channel[159];    
        Droite13.innerHTML = channel[162];    
        Droite14.innerHTML = channel[163];    
        Droite15.innerHTML = channel[164];    
        Droite16.innerHTML = channel[27];    
        Droite17.innerHTML = channel[92];    
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