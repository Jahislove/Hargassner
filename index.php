<!-- ************************************************************************
*** Supervision chaudiere Hargassner avec touchtronic
*** Auteur : Jahislove
*** licence GPL-3.0-or-later
************************************************************************
*** version php 7.x
*** le serveur php doit etre lancé avec les extensions mysqli, zip et openssl

/ -->


<?php require("header_debut.php"); ?>
<script type="text/javascript" src="js/call_ajax_full.js">	</script>
<?php require("header_fin.php"); ?>
    
<?php	



    include("dessin.inc.php");
    include("graph_silo.inc.php"); 
    include("graph_live.inc.php");
    include("footer.php");
    

?>

