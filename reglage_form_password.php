<!--
// <?php 
// require("header.php"); 
// ?>
    
<script type="text/javascript">
	requestData(call_ajax_light);
</script>
-->
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
