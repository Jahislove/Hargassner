// appel ajax et rafraichissement des données
function call_ajax() {
$.ajax({
    url: 'json_telnet.php', 
    cache: false,
    success: function(channel) {
        heure = channel[0]; // stock la date puis
        channel.shift(); // supprime la 1ere valeur (date) pour etre synchro avec les numero de channel

        //  remplace valeur numerique de "etat" par un texte
        switch(channel[0]) { 
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
		document.getElementById('etat').innerHTML = etat;
        //document.getElementById('etat').innerHTML = etat + ' | ' + channel[134] + '%';
        //document.getElementById('T°ext').innerHTML = 'T°ext : ' + channel[6];
        //document.getElementById('T°depart').innerHTML = 'T°depart : ' + channel[21];
    },
});
};
