<?php
	require_once "../Verification/verifieSession.php";
	global $db;
	if(VALID){
		$idParis = pg_escape_string($_POST['id']);

		$requete = "select deleteParis($idParis,'".MAIL."','".SESSIONID."')";
		$result = $db->prepare($requete);
		$result->execute();
		$resultat = $result->fetch();
		if(!$resultat[0])
			echo "0";
		else
			echo "1";
		
		$result->closeCursor();
	}
?>