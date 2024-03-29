
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
		<div class='tooltipContainer extr-bulle '>
			<span class="tooltipBulle">Puissance du ventilateur d'extraction des fumées</span>
			<span id="extr-texte"  class='texte-bulle'></span>
		</div>
		<span class='tooltipContainer fumee-bulle'>
			<span class="tooltipBulle">Température des fumées</span>
			<span id="fumee-texte" class='texte-bulle'></span>
		</span>
	
		<span class='tooltipContainer Tchaud-bulle'>
			<span class="tooltipBulle">Température de l'eau</span>
			<span id="Tchaud-texte" class='texte-bulle'></span>
		</span>
	
		<span class='tooltipContainer puiss-bulle'>
			<span class="tooltipBulle">Puissance</span>
			<span id="puiss-texte"  class='texte-bulle'></span>
		</span>
        
        <div class='maison-bulle'>
			<div class='tooltipContainer maison-Tint-texte'>
				<div id="Tint-texte" ></div>	
				<span class="tooltipMaison">Température intérieure</span>
			</div>
			<div class='tooltipContainer maison-Text-texte'>
				<span id="Text-texte"></span>
				<span class="tooltipMaison">Température extérieure</span>
			</div>
			<div class='tooltipContainer radiateur-texte'>
				<span id="radiateur-texte"></span>
				<span class="tooltipMaison">température de départ chauffage</span>
			</div>

			<span id="pompe-radiat" class='tooltipContainer pompeOFF'>
				<span class="tooltipBulle">pompe radiateur</span>
			</span>
			<div id="ballonECS-bulle" class='hidden'>
				<span id="tuyau-ECS" class='tuyau-ECS'></span>				
				<span id="ballonECS-texte"   class='BallonECS-texte'></span>
				<div id="pompe-ECS" class='tooltipContainer pompeOFF'>
					<span class="tooltipBulle">pompe ECS</span>
				</div>
			</div>
        </div>

		<span id="silo-bulle" class='silo-bulle'>
			<span class='tooltipContainer'>
				<span class="tooltipBulle">quantité de granulés restant</span>
				<span id="silo-texte"   class='silo-texte'></span>
				<img id="silo" src="img/Silo-textile-GWTS-XXL2.png"></img>
			</span>
		</span>

		<span class='tooltipContainer bois-bulle'>
			<span class="tooltipBulle">pourcentage d'amené de la vis à granulé</span>
			<span id="bois-texte"   class='texte-bulle'></span>
		</span>
	</div>

	<div id='tableau' class="hidden" >  
        <span id='gauche'>  
            <table class='TableInstant'>  
                <tr><th>O² Lambda</th>          <td id="Gauche1">?</td></tr>    
                <tr><th>T° interieur</th>       <td id="Gauche2">?</td></tr>    
                <tr><th>T° exterieur</th>   	<td id="Gauche3">?</td></tr>    
                <tr><th>T° exterieur moy</th> 	<td id="Gauche4">?</td></tr>    
                <tr><th>T° depart est</th>   	<td id="Gauche5">?</td></tr>    
                <tr><th>T° depart doit</th>  	<td id="Gauche6">?</td></tr>    
                <tr><th>T° chaudière est</th>  	<td id="Gauche7">?</td></tr>    
                <tr><th>T° chaudière doit</th>  <td id="Gauche8">?</td></tr>    
                <tr><th>T° retour est</th>      <td id="Gauche9">?</td></tr>    
                <tr><th>T° retour doit</th>     <td id="Gauche10">?</td></tr>    
           </table>
        </span>
        <span id='droite'>  
            <table class='TableInstant'>  
                <tr><th>tps comb pour décend est</th><td id="Droite1">?</td></tr>  
                <tr><th>tps vis depuis aspi</th>    <td id="Droite2">?</td></tr>    
                <tr><th>mouvement grille</th>       <td id="Droite3">?</td></tr>  
                <tr><th>consommation pellet</th>    <td id="Droite4">?</td></tr>  
                <tr><th>pellet restant</th>         <td id="Droite5">?</td></tr>  
                <tr><th>Ballon ECS °C</th>          <td id="Droite6">?</td></tr>  
                <tr><th>Ballon ECS On/Off/recyc</th><td id="Droite7">?</td></tr>  
                <tr><th>Variable F</th>         	<td id="Droite8">?</td></tr>    
                <tr><th>Variable K</th>   			<td id="Droite9">?</td></tr>    

            </table>
       </span>
    </div>
</div>

