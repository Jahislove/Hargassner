<?php require("header_debut.php"); ?>
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
		<div class="radio_bouton">
			<input type="submit" value=" Enregistrer ">
		</div>
	</form>
</div>

<?php require("footer.php");?>





