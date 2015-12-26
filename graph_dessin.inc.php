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
            <span class="tooltip"><a>Puissance du ventilateur d'extraction des fumées</a></span>
            <span id="extr-texte"  class='texte-bulle'></span>
        </span>
        
        <span class='fumee-bulle'>
            <span class="tooltip"><a>Température des fumées</a></span>
            <span id="fumee-texte" class='texte-bulle'></span>
        </span>
        
        <span class='Tchaud-bulle'>
            <span class="tooltip"><a>Température de l'eau</a></span>
            <span id="Tchaud-texte" class='texte-bulle'></span>
        </span>
        
        <span class='puiss-bulle'>
            <span class="tooltip"><a>Puissance</a></span>
            <span id="puiss-texte"  class='texte-bulle'></span>
        </span>
        
        <span class='maison-bulle'>
            <span class="tooltip"><a>Température intérieur et extérieur</a></span>
            <span id="Tint-texte"   class='maison-Tint-texte'></span>
            <span id="Text-texte"   class='maison-Text-texte'></span>
        </span>
        
        <span class='depart-bulle'>
            <span class="tooltip"><a>température de départ de l'eau</a></span>
            <span id="depart-texte" class='texte-bulle'></span>
        </span>
        
        <span id="silo-bulle" class='silo-bulle'>
            <span class="tooltip"><a>quantité de granulés restant</a></span>
            <span id="silo-texte"   class='silo-texte'></span>
        </span>

        <span class='bois-bulle'>
            <span class="tooltip"><a>pourcentage d'amené de la vis à granulé</a></span>
            <span id="bois-texte"   class='texte-bulle'></span>
        </span>
        
        
	</div>
	<div id='tableau' class="hidden" >  
        <span id='gauche'>  
            <table class='TableInstant'>  
                <tr><th>O² est</th>             <td id="Gauche1">?</td></tr>    
                <tr><th>O² doit</th>            <td id="Gauche2">?</td></tr>    
                <tr><th>T° chaudière est</th>   <td id="Gauche3">?</td></tr>    
                <tr><th>T° chaudière doit</th>  <td id="Gauche4">?</td></tr>    
                <tr><th>T° fumée</th>           <td id="Gauche5">?</td></tr>    
                <tr><th>T° exterieur</th>       <td id="Gauche6">?</td></tr>    
                <tr><th>T° exterieur moy</th>   <td id="Gauche7">?</td></tr>    
                <tr><th>T° depart ext</th>      <td id="Gauche8">?</td></tr>    
                <tr><th>T° depart doit</th>     <td id="Gauche9">?</td></tr>    
                <tr><th>Variable F</th>         <td id="Gauche10">?</td></tr>    
                <tr><th>Variable K</th>         <td id="Gauche11">?</td></tr>    
            </table>
        </span>
        <span id='droite'>  
            <table class='TableInstant'>  
                <tr><th>heures vis bois</th>        <td id="Droite1">?</td></tr>    
                <tr><th>tps comb pour décend est</th>   <td id="Droite2">?</td></tr>  
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

            </table>
       </span>
    </div>
</div>

