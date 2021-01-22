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
                etat = 'Allumage';
                break;
            case 3:
                etat = 'Démarrage';
                break;
            case 4:
                etat = 'Controle allumage';
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
                etat = 'Refroidissement sécurité';
                break;
            case 12:
                etat = 'Nettoyage';
                break;
            case 17:
                etat = 'Assistant de combustion';
            default:
                etat = 'inconnu';
                break;
        }
        // rafraichissement etat
        document.getElementById('etat').innerHTML = etat;
		switch ( chanel['modeCommand'] ) {
			case 1: 
				//document.getElementById('modeCommand').innerHTML = 'programmé';
				document.getElementById('modeCommand').className = 'modeCommandProgram';
				break;
			case 2: 
				document.getElementById('modeCommand').className = 'modeCommandReduit';
				break;
			case 3: 
				document.getElementById('modeCommand').className = 'modeCommandConfort';
				break;
			case 4: 
				document.getElementById('modeCommand').className = 'modeCommandSoiree';
				break;
			case 5: 
				document.getElementById('modeCommand').className = 'modeCommandAbsence';
				break;
			default:
				document.getElementById('modeCommand').innerHTML = chanel['modeCommand'];
		}
		switch ( chanel['modeChauff'] ) {
			case 1: 
				document.getElementById('modeChauff').className = 'modeCommandConfort';
				break;
			case 3: 
				document.getElementById('modeChauff').className = 'modeCommandReduit';
				break;
			case 4: 
				document.getElementById('modeChauff').className = 'modeCommandArret';
				break;
			case 9: 
				document.getElementById('modeChauff').className = 'modeCommandArret';
				break;
			default:
				document.getElementById('modeChauff').innerHTML = chanel['modeChauff'];
		}
    },
});
};
