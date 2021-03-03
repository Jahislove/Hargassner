<?php require("header_debut.php"); ?>
<script type="text/javascript" src="js/call_ajax_light.js">	</script>
<?php require("header_fin.php"); ?>
    
<script type="text/javascript">
	requestData();
</script>

<?php require_once("conf/settings.inc.php");?>

<form name="form1" method="post" action="write_setting.php">
	<input type="radio" name="zone_chauffage" id="zone1"  value="zone1" <?php echo ($zone_chauffage == "zone1") ? 'checked' : '';?> >
	<label for="zone1">zone 1</label><br>
	<input type="radio" name="zone_chauffage" id="zone2"  value="zone2" <?php echo ($zone_chauffage == "zone2") ? 'checked' : '';?> >
	<label for="zone2">zone 2</label><br>
	<input type="radio" name="zone_chauffage" id="zone3"  value="zone3" <?php echo ($zone_chauffage == "zone3") ? 'checked' : '';?> >
	<label for="zone3">zone 3</label><br> 
	
	<input type="radio" id="ecs1" name="zone_ecs" value="ballon1" <?php echo ($zone_ecs == "ballon1") ? 'checked' : '';?> > Ballon 1<BR>
	<input type="radio" id="ecs2" name="zone_ecs" value="ballon2" <?php echo ($zone_ecs == "ballon2") ? 'checked' : '';?> > Ballon 2<BR>
	<input type="radio" id="ecs3" name="zone_ecs" value="ballon3" <?php echo ($zone_ecs == "ballon3") ? 'checked' : '';?> > Ballon 3<BR>

	<input type="submit" value=" Enregistrer ">
</form>

<?php require("footer.php");?>





