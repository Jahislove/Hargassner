<?php require("header_debut.php"); ?>
<script type="text/javascript" src="js/codes_erreurs.js">	</script>
<script type="text/javascript" src="js/call_ajax_light.js">	</script>
<?php require("header_fin.php"); ?>
    
<script type="text/javascript">
	requestData();
</script>

<?php require_once("conf/settings.inc.php");?>

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

<?php require("footer.php");?>





