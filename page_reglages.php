<?php require("header_debut.php"); ?>
<script type="text/javascript" src="js/call_ajax_light.js">	</script>
<?php require("header_fin.php"); ?>
    
<script type="text/javascript">
 requestData();
</script>

<form name="form1" method="post" action="write_setting.php">
	<input type="radio" name="zone_chauffage" id="zone1"  value="chauff1" CHECKED>
	<label for="zone1">zone 1</label><br>
	<input type="radio" name="zone_chauffage" id="zone2"  value="chauff2">
	<label for="zone2">zone 2</label><br>
	<input type="radio" name="zone_chauffage" id="zone3"  value="chauff3">
	<label for="zone3">zone 3</label><br> 

	<input type="radio" id="ecs1" name="zone_ecs" value="ecs1" CHECKED> Ballon 1<BR>
	<input type="radio" id="ecs2" name="zone_ecs" value="ecs2"> Ballon 2<BR>
	<input type="radio" id="ecs3" name="zone_ecs" value="ecs3"> Ballon 3<BR>
	<input type="submit" value="Send">
</form>

<?php require("footer.php");?>





