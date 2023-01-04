<?php 
require("header_debut.php"); 
require_once 'protect.php';
Protect\with('form_password.php', $password_settings);
?>
<script type="text/javascript" src="js/codes_erreurs.js">	</script>
<script type="text/javascript" src="js/call_ajax_light.js">	</script>
<?php require("header_fin.php"); ?>
    
<script type="text/javascript">
	requestData();
</script>

<?php 
require_once("conf/settings.inc.php");

    $query0 = "SELECT * FROM tarif 
            ORDER BY saison ASC ";

	$conn = mysqli_connect ($hostname, $username, $password, $database); 
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

    $req0 = mysqli_query($conn, $query0) ;
	echo mysqli_error($conn);

	mysqli_close($conn);

    while($data = mysqli_fetch_row($req0)){
        $obj_saison[] = [
					'saison'=> $data[0] ,
					'prix' => $data[1],
					];
    }
	$nombre_saison = count($obj_saison);
?>

<div class="ensemble">
	<div class="boutons_radio">
		<form name="form1" method="post" action="write_setting.php" >
			<span>Choix de l'affichage sur la page d'accueil</span>
			<div class="radio_chauffage">
				<input type="radio" name="zone_chauffage" value="zone1" <?php echo ($zone_chauffage == "zone1") ? 'checked' : '';?> > Chauffage zone 1<BR>
				<input type="radio" name="zone_chauffage" value="zone2" <?php echo ($zone_chauffage == "zone2") ? 'checked' : '';?> > Chauffage zone 2<BR>
				<input type="radio" name="zone_chauffage" value="zone3" <?php echo ($zone_chauffage == "zone3") ? 'checked' : '';?> > Chauffage zone 3<BR>
			</div>
			<div class="radio_ECS">
				<input type="radio" name="zone_ecs" value="ballon1" <?php echo ($zone_ecs == "ballon1") ? 'checked' : '';?> > Ballon ECS 1<BR>
				<input type="radio" name="zone_ecs" value="ballon2" <?php echo ($zone_ecs == "ballon2") ? 'checked' : '';?> > Ballon ECS 2<BR>
				<input type="radio" name="zone_ecs" value="ballon3" <?php echo ($zone_ecs == "ballon3") ? 'checked' : '';?> > Ballon ECS 3<BR>
			</div>
			<div class="radio_MODE">
				<input type="radio" name="zone_mode_chauffage" value="modeChauffageA" <?php echo ($zone_mode_chauffage == "modeChauffageA") ? 'checked' : '';?> > Zone FR35 A<BR>
				<input type="radio" name="zone_mode_chauffage" value="modeChauffage1" <?php echo ($zone_mode_chauffage == "modeChauffage1") ? 'checked' : '';?> > Zone FR35 1<BR>
				<input type="radio" name="zone_mode_chauffage" value="modeChauffage2" <?php echo ($zone_mode_chauffage == "modeChauffage2") ? 'checked' : '';?> > Zone FR35 2<BR>
				<input type="radio" name="zone_mode_chauffage" value="modeChauffage3" <?php echo ($zone_mode_chauffage == "modeChauffage3") ? 'checked' : '';?> > Zone FR35 3<BR>
				<input type="radio" name="zone_mode_chauffage" value="modeChauffage4" <?php echo ($zone_mode_chauffage == "modeChauffage4") ? 'checked' : '';?> > Zone FR35 4<BR>
				<input type="radio" name="zone_mode_chauffage" value="modeChauffage5" <?php echo ($zone_mode_chauffage == "modeChauffage5") ? 'checked' : '';?> > Zone FR35 5<BR>
				<input type="radio" name="zone_mode_chauffage" value="modeChauffage6" <?php echo ($zone_mode_chauffage == "modeChauffage6") ? 'checked' : '';?> > Zone FR35 6<BR>
			</div>
			<div class="radio_bouton">
				<input type="submit" value=" Enregistrer ">
			</div>
		</form>
	</div>
	<div class="tarif">
		<form name="form_tarif" method="post" action="ajout_tarif.php">
			<table class='TableTarif'>  
				<input name="nombre_saison" type="hidden" value="<?php echo $nombre_saison ;?>">
				<?php for ($i=0 ; $i < $nombre_saison ; $i++){ ?>
				<tr>
					<th>
						<?php echo $obj_saison[$i]['saison'];?> 
						<input name="saison<?php echo $i;?>" type="hidden" value="<?php echo $obj_saison[$i]['saison'];?>"> <!-- valeur invisible utilisé pour l'envoi dans le POST -->
					</th> 
					<th>
						<input name="prix<?php echo $i;?>" id="prix" type="text" value="<?php echo $obj_saison[$i]['prix'];?>" pattern="(([0-9]){1,1})((\.))([0-9]){1,3}" required >
					</th>
				</tr>    
				<?php } ?>
				
			</table>
			<input type="submit" value="Enregistrer">
		</form>
		
		<form name="form_delete" method="post" action="delete_saison.php">
			<table class='TableTarif'>  
				<?php for ($i=0 ; $i < $nombre_saison ; $i++){ ?>
				<tr>
					<td>
						<input type="radio" name="delete" value="delete<?php echo $i;?>">
					</td>
				</tr>    
				<?php } ?>
			</table>
			<input type="submit" value="Supprimer">
		</form>
		
		<form name="form_ajout_saison" method="post" action="ajout_saison.php">
			<datalist id="list_saison">
				<option value="2015/2016">
				<option value="2016/2017">
				<option value="2017/2018">
				<option value="2018/2019">
				<option value="2019/2020">
				<option value="2020/2021">
				<option value="2021/2022">
				<option value="2022/2023">
				<option value="2023/2024">
				<option value="2024/2025">
				<option value="2025/2026">
			</datalist>
			<label>ajouter saison</label>
				<input placeholder="2015/2016" name="saison" list="list_saison" type="text" pattern="(([0-9]){4,4})((\/))([0-9]){4,4}" required>
				<input type="submit" value="Ajouter Saison">
		</form>
	
	</div>
</div>

<?php require("footer.php");?>
