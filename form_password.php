<?php 
require("header_debut.php"); 
?>
<script type="text/javascript" src="js/codes_erreurs.js">	</script>
<script type="text/javascript" src="js/call_ajax_light.js">	</script>
<?php require("header_fin.php"); ?>
    
<script type="text/javascript">
	requestData();
</script>

<body>

<form method="POST">
  <?php if( $_SERVER['REQUEST_METHOD'] == 'POST' ) { ?>
	<div class="error_password_div">
		mot de passe incorrect
	</div>
  <?php } ?>
  
	<div class="password_div">
		<p>Entrez le mot de passe pour accéder aux réglages</p>
		<input type="password" name="password">
		<button type="submit"> Valider </button>
	</div>
	
</form>

</body>

<?php require("footer.php");?>
