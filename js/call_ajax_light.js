// appel ajax et rafraichissement des données

function call_ajax() {
$.ajax({
    url: 'json_telnet.php', 
    cache: false,
    success: function(chanel) {

        //  remplace valeur numerique de "etat" par un texte
        switch(chanel['etat']) { 
            case 0:
                etat = '0';
                break;
            case 1:
                etat = 'Arrêt';
                break;
            case 2:
                etat = 'init grille';
                break;
            case 3:
                etat = 'Démarrage';
                break;
            case 4:
                etat = 'Controle allumage residuel';
                break;
            case 5:
                etat = 'Allumage électrique';
                break;
            case 6:
                etat = 'Démarrage combustion';
                break;
            case 7:
                etat = 'Combustion';
                break;
            case 8:
                etat = 'En veille';
                break;
            case 9:
                etat = 'Arrêt pour décendrage';
                break;
            case 10:
                etat = 'Décendrage';
                break;
            case 11:
                etat = 'Refroidissement/chaleur residuelle';
                break;
            case 12:
                etat = 'Nettoyage';
                break;
            case 17:
                etat = 'Assistant de combustion';
                break;
            default:
                etat = 'inconnu';
                break;
        }
        // rafraichissement etat
        document.getElementById('etat').innerHTML = etat;
		switch ( chanel['modeCommand'] ) {
			case 1: 
				document.getElementById('modeCommand').className = 'modeCommandProgram';
				document.getElementById('tooltipModeCommand').innerHTML = 'Mode Programmé';
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
				document.getElementById('tooltipModeChauff').innerHTML = 'Mode confort';
				break;
			case 2: 
				document.getElementById('modeChauff').className = 'modeCommandArret'; // etat inconnu
				document.getElementById('tooltipModeChauff').innerHTML = '?';
				break;
			case 3: 
				document.getElementById('modeChauff').className = 'modeCommandReduit';
				document.getElementById('tooltipModeChauff').innerHTML = 'Mode réduit';
				break;
			case 4: 
				document.getElementById('modeChauff').className = 'modeCommandArret';
				document.getElementById('tooltipModeChauff').innerHTML = 'Mode arrêt';
				break;
			case 5: 
				document.getElementById('modeChauff').className = 'modeCommandArret';
				document.getElementById('tooltipModeChauff').innerHTML = 'Arrêt sur temp ext';
				break;
			case 9: 
				document.getElementById('modeChauff').className = 'modeCommandArret';
				document.getElementById('tooltipModeChauff').innerHTML = 'arrêt en cours';
				break;
			default:
				document.getElementById('modeChauff').innerHTML = chanel['modeChauff'];
				document.getElementById('tooltipModeChauff').innerHTML = 'code inconnu';
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
    },
});
};
