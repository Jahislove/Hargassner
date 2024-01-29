// ######## rafraichissement des données ########################################################
// voir chanel-nanoPK-vxxxx.txt pour les numeros de canaux

// rafraichissement page acceuil
function call_ajax(type) {
	$.ajax({
		url: 'json_telnet.php', 
		cache: false,
		success: function(chanel) {
			switch(type){
				case 'call_ajax_accueil':
					call_ajax_light(chanel);
					call_ajax_accueil(chanel);
					break;
				case 'call_ajax_regul':
					call_ajax_light(chanel);
					call_ajax_regul(chanel);
					break;
				case 'call_ajax_light':
					call_ajax_light(chanel);
					break;
			}
		},
	});
};
		
function call_ajax_accueil(chanel){
	// animation du dessin par chargement de class CSS
	switch(chanel['etat_num']) { 
		case 0:
			// etat = '0';
			break;
		case 1:
			// etat = 'Arrêt';
			document.getElementById('nano-D1').className = 'foyer_eteint';
			document.getElementById('nano-C1').className = 'coeur_eteint';
			document.getElementById('nano-D2').className = 'vis_stop';
			document.getElementById('nano-B1').className = 'ressort_fixe';
			document.getElementById('nano-E1').className = 'cendrier_ferme';
			break;
		case 2:
			// etat = 'init grille';
			document.getElementById('nano-D1').className = 'foyer_allumage';
			document.getElementById('nano-D2').className = 'vis_stop';
			document.getElementById('nano-B1').className = 'ressort_fixe';
			break;
		case 3:
			// etat = 'Démarrage';
			document.getElementById('nano-D2').className = 'vis_stop';
			document.getElementById('nano-B1').className = 'ressort_fixe';
			break;
		case 4:
			// etat = 'Controle allumage residuel';
			document.getElementById('nano-D1').className = 'foyer_reprise';
			document.getElementById('nano-D2').className = 'vis_marche';
			break;
		case 5:
			// etat = 'Allumage électrique';
			document.getElementById('nano-D1').className = 'foyer_allumage';
			break;
		case 6:
			// etat = 'Démarrage combustion';
			document.getElementById('nano-D1').className = 'foyer_reprise';
			document.getElementById('nano-E1').className = 'cendrier_ventil';
			document.getElementById('nano-D2').className = 'vis_marche';
			document.getElementById('nano-B1').className = 'ressort_fumee';
			break;
		case 7:
			// etat = 'Combustion';
			document.getElementById('nano-C1').className = 'coeur_combustion'; 
			document.getElementById('nano-D1').className = 'foyer_combustion';
			document.getElementById('nano-E1').className = 'cendrier_ventil';
			document.getElementById('nano-D2').className = 'vis_marche';
			document.getElementById('nano-B1').className = 'ressort_fumee';
			break;
		case 8:
			// etat = 'En veille';
			document.getElementById('nano-C1').className = 'coeur_eteint';
			document.getElementById('nano-D1').className = 'foyer_veille';
			document.getElementById('nano-E1').className = 'cendrier_ferme';
			document.getElementById('nano-D2').className = 'vis_stop';
			document.getElementById('nano-B1').className = 'ressort_fixe';
			break;
		case 9:
			// etat = 'Arrêt pour décendrage';
			document.getElementById('nano-C1').className = 'coeur_eteint';
			document.getElementById('nano-D1').className = 'foyer_veille';
			document.getElementById('nano-D2').className = 'vis_stop';
			break;
		case 10:
			// etat = 'Décendrage';
			document.getElementById('nano-E1').className = 'cendrier_mouvt';
			break;
		case 11:
			// etat = 'Refroidissement/chaleur residuelle';
			break;
		case 12:
			// etat = 'Nettoyage';
			document.getElementById('nano-E1').className = 'cendrier_ouvert';
			document.getElementById('nano-B1').className = 'ressort_anime';
			break;
		case 17:
			// etat = 'Assistant de combustion';
			break;
		default:
			// etat = 'inconnu';
			break;
	}
        
	// elements qui ne dependent pas d'un etat , mais de la valeur d'un chanel
	// l'extracteur de fumée 
	if ( chanel['extract'] > 0 ) {
		document.getElementById('nano-A1').className = 'extr_anime'; 
	}
	else {
		document.getElementById('nano-A1').className = 'extr_fixe'; 
	}
	
	// test presence et remplissage ballon ECS 
	var TempECS = chanel['TempECS'];
	switch ( true ) {
		case (TempECS==140): // ballon ECS absent
			chanel['TempECS'] = "null";
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
        
	// rafraichissement des bulles
	document.getElementById('extr-texte').innerHTML =  chanel['extract'] + '%';
	document.getElementById('fumee-texte').innerHTML = chanel['Fumee'] + '°C';
	document.getElementById('Tchaud-texte').innerHTML =chanel['chaudiereEst'] + '°C';
	document.getElementById('puiss-texte').innerHTML = chanel['puissance'] + '%';
	document.getElementById('Tint-texte').innerHTML =  chanel['Tint'] + '°C';
	document.getElementById('Text-texte').innerHTML =  chanel['Text'] + '°C';
	document.getElementById('radiateur-texte').innerHTML =  chanel['departEst'] + '°C';
	document.getElementById('ballonECS-texte').innerHTML =  chanel['TempECS'] + '°C';
	document.getElementById('bois-texte').innerHTML =  chanel['bois'] + '%<br>' + Math.round(((chanel['consoHeure']*60)*chanel['bois'])/1000)/100+ 'kg/h'; // consoHeure= gr/tr (R8a), 60 = 60 tr/h (supposition)
	
	// rafraichissement des pompes
	if ( chanel['departDoit'] > 0 ) {
		document.getElementById('pompe-radiat').className = 'tooltipContainer pompeON';
	} else {
		document.getElementById('pompe-radiat').className = 'tooltipContainer pompeOFF';
	}	
	if ( chanel['pompe-ECS'] > 0 ) { //old: 183   Ballon ECS 0:off , 1:charge, 2:recyclage 
		document.getElementById('pompe-ECS').className = 'tooltipContainer pompeON';
	} else {
		document.getElementById('pompe-ECS').className = 'tooltipContainer pompeOFF';
	}	

	// rafraichissement graphe silo
	chart_silo.series[0].points[0].update(chanel['PelletRest']);

	// aspiration RAPS : desactivé car parametre non connu
	 if ( chanel['aspiration'] == 2000 ) {
		 document.getElementById('nano-A2').className = 'RAPS_anime'; 
	 }
	 else {
		 document.getElementById('nano-A2').className = 'RAPS_fixe'; 
	 }
	 
	// rafraichissement graphe live
	var shift = chart_live.series[0].data.length > histo_live_shift;
	chart_live.series[0].addPoint([chanel['heure'], chanel['etat']], true, shift);
	chart_live.series[1].addPoint([chanel['heure'], chanel['chaudiereEst']], true, shift);
	chart_live.series[2].addPoint([chanel['heure'], chanel['extract']], true, shift);
	chart_live.series[3].addPoint([chanel['heure'], chanel['bois']], true, shift);
	chart_live.series[4].addPoint([chanel['heure'], chanel['puissance']], true, shift);
	chart_live.series[5].addPoint([chanel['heure'], chanel['departEst']], true, shift);
	//chart_live.series[6].addPoint([heure, chanel[54]], true, shift);
	//chart_live.series[7].addPoint([heure, chanel[160]], true, shift);  
		
	// rafraichissement tableau gauche et droite
	Gauche1.innerHTML = chanel['lambda']; 
	Gauche2.innerHTML = chanel['Tint'];    
	Gauche3.innerHTML = chanel['Text'];    
	Gauche4.innerHTML = chanel['TextMoy'];    
	Gauche5.innerHTML = chanel['departEst'];    
	Gauche6.innerHTML = chanel['departDoit'];    
	Gauche7.innerHTML = chanel['chaudiereEst'];    
	Gauche8.innerHTML = chanel['chaudiereDoit'];    
	Gauche9.innerHTML = chanel['retourEst'];    
	Gauche10.innerHTML = chanel['retourDoit'];    

	Droite1.innerHTML = chanel['tempsDecend'];    
	Droite2.innerHTML = chanel['tempsVis'];    
	Droite3.innerHTML = chanel['mvtGrille'];    
	Droite4.innerHTML = chanel['PelletConso'];    
	Droite5.innerHTML = chanel['PelletRest'];    
	Droite6.innerHTML = chanel['TempECS'];    
	Droite7.innerHTML = chanel['pompe-ECS'];    
	Droite8.innerHTML = chanel['variableF'];    
	Droite9.innerHTML = chanel['variableK'];    
};



// rafraichissement header seulement
function call_ajax_light(chanel){
	// rafraichissement etat
	document.getElementById('etat').innerHTML = chanel['etat_desc'];
	document.getElementById('puissance').innerHTML = chanel['puissance']+'%';
	switch ( chanel['modeCommand'] ) {
		case 1: 
			document.getElementById('modeCommand').className = 'modeCommandProgram';
			document.getElementById('tooltipModeCommand').innerHTML = 'Mode Auto';
		break;
		case 2: 
			document.getElementById('modeCommand').className = 'modeCommandReduit';
			document.getElementById('tooltipModeCommand').innerHTML = 'Réduit forcé';
			break;
		case 3: 
			document.getElementById('modeCommand').className = 'modeCommandConfort';
			document.getElementById('tooltipModeCommand').innerHTML = 'Confort forcé';
			break;
		case 4: 
			document.getElementById('modeCommand').className = 'modeCommandArret';
			document.getElementById('tooltipModeCommand').innerHTML = 'Arret';
			break;
		case 5: 
			document.getElementById('modeCommand').className = 'modeCommandSoiree';
			document.getElementById('tooltipModeCommand').innerHTML = "Soirée : mode confort<br>activé jusqu'au<br>prochain changement<br>d'état programmé";
			break;
		case 6: 
			document.getElementById('modeCommand').className = 'modeCommandAbsence';
			document.getElementById('tooltipModeCommand').innerHTML = "Absence : mode réduit<br>activé jusqu'au<br>prochain changement<br>d'état programmé";
			break;
		default:
			document.getElementById('modeCommand').innerHTML = chanel['modeCommand'];
			document.getElementById('tooltipModeCommand').innerHTML = '?';
	}
	switch ( chanel['modeChauff'] ) {
		case 0: 
			document.getElementById('modeChauff').className = 'modeCommandConfort';
			document.getElementById('tooltipModeChauff').innerHTML = 'Mode été';
			break;
		case 1: 
			document.getElementById('modeChauff').className = 'modeCommandConfort';
			document.getElementById('tooltipModeChauff').innerHTML = 'Confort';
			break;
		case 2: 
			document.getElementById('modeChauff').className = 'modeCommandReduit'; 
			document.getElementById('tooltipModeChauff').innerHTML = 'Confort vers Réduit';
			break;
		case 3: 
			document.getElementById('modeChauff').className = 'modeCommandReduit';
			document.getElementById('tooltipModeChauff').innerHTML = 'Réduit';
			break;
		case 4: 
			document.getElementById('modeChauff').className = 'modeCommandArret';
			document.getElementById('tooltipModeChauff').innerHTML = 'Arrêt';
			break;
		case 5: 
			document.getElementById('modeChauff').className = 'modeCommandArret';
			document.getElementById('tooltipModeChauff').innerHTML = 'Arrêt sur temp ext';
			break;
		case 9: 
			document.getElementById('modeChauff').className = 'modeCommandArret';
			document.getElementById('tooltipModeChauff').innerHTML = 'Arrêt en cours';
			break;
		default:
			document.getElementById('modeChauff').innerHTML = chanel['modeChauff'];
			document.getElementById('tooltipModeChauff').innerHTML = 'Code inconnu';
	}
// en cas d'erreur
// la liste des erreurs est contenue dans TabErreur (js/codes_erreurs.js)
	document.getElementById('erreurNumber').innerHTML = chanel['erreur'];
	switch(chanel['erreur']) { 
		case 0: 
			document.getElementById('erreurText').innerHTML = TabErreur[chanel['erreur']];
			document.getElementById('erreur').className = 'erreur erreurNonVisible';
			break;
		default:
			document.getElementById('erreur').className = 'erreur erreurVisible';
			if (typeof TabErreur[chanel['erreur']] == 'undefined') {
				document.getElementById('erreurText').innerHTML = "erreur inconnue";
			}else{
				document.getElementById('erreurText').innerHTML = TabErreur[chanel['erreur']];
			}
			break;
	}
};

// rafraichissement table telnet
function call_ajax_regul(chanel){
	for(var i = 0;i<200;i=i+1){
		if(chanel['integral'][i] === undefined){
			chanel['integral'][i] ='.'; 
		}
		document.getElementById(i).innerHTML = chanel['integral'][i]; 
	}
};
