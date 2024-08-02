
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
			<span class="tooltipBulle"><?php echo text_fan;?></span>
			<span id="extr-texte"  class='texte-bulle'></span>
		</div>
		<span class='tooltipContainer fumee-bulle'>
			<span class="tooltipBulle"><?php echo text_temp_smoke;?></span>
			<span id="fumee-texte" class='texte-bulle'></span>
		</span>
	
		<span class='tooltipContainer Tchaud-bulle'>
			<span class="tooltipBulle"><?php echo text_temp_waterIs;?></span>
			<span id="Tchaud-texte" class='texte-bulle'></span>
		</span>
	
		<span class='tooltipContainer puiss-bulle'>
			<span class="tooltipBulle"><?php echo text_power;?></span>
			<span id="puiss-texte"  class='texte-bulle'></span>
		</span>
        
        <div class='maison-bulle'>
			<div class='tooltipContainer maison-Tint-texte'>
				<div id="Tint-texte" ></div>	
				<span class="tooltipMaison"><?php echo text_temp_indoor;?></span>
			</div>
			<div class='tooltipContainer maison-Text-texte'>
				<span id="Text-texte"></span>
				<span class="tooltipMaison"><?php echo text_temp_outdoor;?></span>
			</div>
			<div class='tooltipContainer radiateur-texte'>
				<span id="radiateur-texte"></span>
				<span class="tooltipMaison"><?php echo text_temp_toHeaterIs;?></span>
			</div>

			<span id="pompe-radiat" class='tooltipContainer pompeOFF'>
				<span class="tooltipBulle"><?php echo text_pump_heater;?></span>
			</span>
			<div id="ballonECS-bulle" class='hidden'>
				<span id="tuyau-ECS" class='tuyau-ECS'></span>				
				<span id="ballonECS-texte"   class='BallonECS-texte'></span>
				<div id="pompe-ECS" class='tooltipContainer pompeOFF'>
					<span class="tooltipBulle"><?php echo text_pump_ECS;?></span>
				</div>
			</div>
        </div>

		<span id="silo-bulle" class='silo-bulle'>
			<span class='tooltipContainer'>
				<span class="tooltipBulle"><?php echo text_pellet_left;?></span>
				<span id="silo-texte"   class='silo-texte'></span>
				<img id="silo" src="img/Silo-textile-GWTS-XXL2.png"></img>
			</span>
		</span>

		<span class='tooltipContainer bois-bulle'>
			<span class="tooltipBulle"><?php echo text_feeder;?></span>
			<span id="bois-texte"   class='texte-bulle'></span>
		</span>
	</div>

	<div id='tableau' class="hidden" >  
        <span id='gauche'>  
            <table class='TableInstant'>  
                <tr><th><?php echo text_lambda;?></th>    			<td id="Gauche1">?</td></tr>    
                <tr><th><?php echo text_temp_indoor;?></th>    		<td id="Gauche2">?</td></tr>    
                <tr><th><?php echo text_temp_outdoor;?></th>   		<td id="Gauche3">?</td></tr>    
                <tr><th><?php echo text_temp_outdoorAvg;?></th> 	<td id="Gauche4">?</td></tr>    
                <tr><th><?php echo text_temp_toHeaterIs;?></th>   	<td id="Gauche5">?</td></tr>    
                <tr><th><?php echo text_temp_toHeaterMust;?></th>  	<td id="Gauche6">?</td></tr>    
                <tr><th><?php echo text_temp_waterIs;?></th>  		<td id="Gauche7">?</td></tr>    
                <tr><th><?php echo text_temp_waterMust;?></th>  	<td id="Gauche8">?</td></tr>    
                <tr><th><?php echo text_temp_returnIs;?></th>   	<td id="Gauche9">?</td></tr>    
                <tr><th><?php echo text_temp_returnMust;?></th>  	<td id="Gauche10">?</td></tr>    
           </table>
        </span>
        <span id='droite'>  
            <table class='TableInstant'>  
                <tr><th><?php echo text_time_ash;?></th>			<td id="Droite1">?</td></tr>  
                <tr><th><?php echo text_time_screw;?></th> 		   	<td id="Droite2">?</td></tr>    
                <tr><th><?php echo text_move_ash;?></th>   			<td id="Droite3">?</td></tr>  
                <tr><th><?php echo text_pellet_consum;?></th>    	<td id="Droite4">?</td></tr>  
                <tr><th><?php echo text_pellet_left;?></th>    		<td id="Droite5">?</td></tr>  
                <tr><th><?php echo text_temp_tank;?></th>    		<td id="Droite6">?</td></tr>  
                <tr><th><?php echo text_state_tank;?></th>			<td id="Droite7">?</td></tr>  
                <tr><th><?php echo text_var_F;?></th>   			<td id="Droite8">?</td></tr>    
                <tr><th><?php echo text_var_K;?></th> 				<td id="Droite9">?</td></tr>    

            </table>
       </span>
    </div>
</div>

