
<div id="tableau_dessin">
	<div id="image" onclick="clic()">
		<span id="nano-A1" class="extr_fixe"></span>
		<span id="nano-A2" class="RAPS_fixe"></span>
		<span id="nano-B1" class="ressort_fixe"></span>
		<span id="nano-B2"></span>
		<span id="nano-C1" class="coeur_eteint"></span>
		<span id="nano-C2"></span>
		<span id="nano-D1" class="foyer_eteint"></span>
		<span id="nano-D2" class="vis_stop"></span>
		<span id="nano-E1" class="cendrier_ferme"></span>
		<span id="nano-E2"></span>
	</div>
    
	<div id='bulles' class="visible" onclick="clic()">  
        <span class='extr-bulle'>
            <span class="tooltip-general tooltip"><a>Puissance du ventilateur d'extraction des fumées</a></span>
            <span id="extr-texte"  class='texte-bulle'></span>
        </span>
        
        <span class='fumee-bulle'>
            <span class="tooltip-general tooltip"><a>Température des fumées</a></span>
            <span id="fumee-texte" class='texte-bulle'></span>
        </span>
        
        <span class='Tchaud-bulle'>
            <span class="tooltip-general tooltip"><a>Température de l'eau</a></span>
            <span id="Tchaud-texte" class='texte-bulle'></span>
        </span>
        
        <span class='puiss-bulle'>
            <span class="tooltip-general tooltip"><a>Puissance</a></span>
            <span id="puiss-texte"  class='texte-bulle'></span>
        </span>
        
        <span class='maison-bulle'>
            <span id="tooltip_Tint" class="tooltip"><a>Température intérieur</a></span>
            <span id="Tint-texte"   class='maison-Tint-texte'></span>
            <span id="tooltip_Text" class="tooltip"><a>Température extérieur</a></span>
            <span id="Text-texte"   class='maison-Text-texte'></span>
			<span id="tooltip_chauffage" class=" tooltip"><a>température de départ chauffage</a></span>
			<span id="radiateur-texte" class='radiateur-texte'></span>
			<span id="pompe-radiat" class='pompeOFF'></span>

			<span id="ballonECS-bulle" class='hidden'>
				<span class="tooltip-general tooltip"><a>Ballon ECS</a></span>
				<span id="ballonECS-texte"   class='BallonECS-texte'></span>
				<span id="pompe-ECS" class='pompeOFF'></span>
				<span id="tuyau-ECS" class='tuyau-ECS'></span>				
			</span>
        </span>

        <span id="silo-bulle" class='silo-bulle'>
            <span class="tooltip-general tooltip"><a>quantité de granulés restant</a></span>
            <span id="silo-texte"   class='silo-texte'></span>
            <img id="silo" src="img/Silo-textile-GWTS-XXL2.png"></img>
        </span>


        <span class='bois-bulle'>
            <span class="tooltip-general tooltip"><a>pourcentage d'amené de la vis à granulé</a></span>
            <span id="bois-texte"   class='texte-bulle'></span>
        </span>
	</div>

	<div id='tableau' class="hidden" >  
        <span id='gauche'>  
            <table class='TableInstant'>  
                <tr><th>O² Lambda</th>          <td id="Gauche1">?</td></tr>    
                <tr><th>T° chaudière est</th>   <td id="Gauche3">?</td></tr>    
                <tr><th>T° chaudière doit</th>  <td id="Gauche4">?</td></tr>    
                <tr><th>T° fumée</th>           <td id="Gauche5">?</td></tr>    
                <tr><th>T° interieur</th>       <td id="Gauche2">?</td></tr>    
                <tr><th>T° exterieur</th>       <td id="Gauche6">?</td></tr>    
                <tr><th>T° exterieur moy</th>   <td id="Gauche7">?</td></tr>    
                <tr><th>T° depart est</th>      <td id="Gauche8">?</td></tr>    
                <tr><th>T° depart doit</th>     <td id="Gauche9">?</td></tr>    
                <tr><th>Variable F</th>         <td id="Gauche10">?</td></tr>    
                <tr><th>Variable K</th>         <td id="Gauche11">?</td></tr>    
                <tr><th>T° retour</th>   		<td id="Gauche12">?</td></tr>    
                <tr><th>T° retour doit</th>		<td id="Gauche13">?</td></tr>    
                <tr><th>channel 15 : Tplat</th> <td id="Gauche14">?</td></tr>    
                <tr><th>channel 25 : TR1</th>   <td id="Gauche15">?</td></tr>    
                <tr><th>channel 26 : TR2</th>   <td id="Gauche16">?</td></tr>    
                <tr><th>channel 45 : TRs_A</th> <td id="Gauche17">?</td></tr>    
                <tr><th>channel 46 : TRs_1</th> <td id="Gauche18">?</td></tr>    
                <tr><th>channel 110 : Höchste A</th><td id="Gauche19">?</td></tr>    
                <tr><th>channel 129 : BRT</th>  <td id="Gauche20">?</td></tr>    
           </table>
        </span>
        <span id='droite'>  
            <table class='TableInstant'>  
                <tr><th>heures vis bois</th>        <td id="Droite1">?</td></tr>    
                <tr><th>tps comb pour décend est</th><td id="Droite2">?</td></tr>  
                <tr><th>temps vis aspiration</th>   <td id="Droite3">?</td></tr>    
                <tr><th>nombre décendrage</th>      <td id="Droite4">?</td></tr>  
                <tr><th>mouvement grille</th>       <td id="Droite5">?</td></tr>    
                <tr><th>consommation pellet</th>    <td id="Droite6">?</td></tr>  
                <tr><th>pellet restant</th>         <td id="Droite7">?</td></tr>  
                <tr><th>heures sous tension</th>    <td id="Droite8">?</td></tr>  
                <tr><th>heures chauffage</th>       <td id="Droite9">?</td></tr>  
                <tr><th>heures allumage</th>        <td id="Droite10">?</td></tr>  
                <tr><th>heures extr fumée</th>      <td id="Droite11">?</td></tr>  
                <tr><th>heures extr silo</th>       <td id="Droite12">?</td></tr>  
                <tr><th>nombre allumage</th>        <td id="Droite13">?</td></tr>  
                <tr><th>heure puissance > 90%</th>  <td id="Droite14">?</td></tr>  
                <tr><th>veille</th>                 <td id="Droite15">?</td></tr>  
                <tr><th>Ballon ECS °C</th>          <td id="Droite16">?</td></tr>  
                <tr><th>Ballon ECS On/Off/recyc</th>      <td id="Droite17">?</td></tr>  

            </table>
       </span>
    </div>
</div>

