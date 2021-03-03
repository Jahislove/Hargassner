<?php require("header_debut.php"); ?>
<script type="text/javascript" src="js/call_ajax_light.js">	</script>
<?php require("header_fin.php"); ?>
    
<script type="text/javascript">
	requestData();
</script>

<?php require_once("conf/settings.inc.php");?>

<form name="form1" method="post" action="write_setting.php">
	<input type="radio" name="zone_chauffage" id="zone1"  value="1" <?php echo ($zone_chauffage == 1) ? 'checked' : '';?> >
	<label for="zone1">zone 1</label><br>
	<input type="radio" name="zone_chauffage" id="zone2"  value="2" <?php echo ($zone_chauffage == 2) ? 'checked' : '';?> >
	<label for="zone2">zone 2</label><br>
	<input type="radio" name="zone_chauffage" id="zone3"  value="3" <?php echo ($zone_chauffage == 3) ? 'checked' : '';?> >
	<label for="zone3">zone 3</label><br> 
	
	<input type="radio" id="ecs1" name="zone_ecs" value="1" <?php echo ($zone_ecs == 1) ? 'checked' : '';?> > Ballon 1<BR>
	<input type="radio" id="ecs2" name="zone_ecs" value="2" <?php echo ($zone_ecs == 2) ? 'checked' : '';?> > Ballon 2<BR>
	<input type="radio" id="ecs3" name="zone_ecs" value="3" <?php echo ($zone_ecs == 3) ? 'checked' : '';?> > Ballon 3<BR>

	<input type="submit" value=" Enregistrer ">
</form>

<?php require("footer.php");?>





