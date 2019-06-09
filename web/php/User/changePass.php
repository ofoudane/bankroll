<?php
require_once __DIR__ . "/../Verification/verifieSession.php";
global $db;
if(VALID){
	$pass = pg_escape_string($_POST['newPass']);
	$key = pg_escape_string($_POST['key']);
	$requete = "select changePassword('$pass','$key','".MAIL."','".SESSIONID."')";
	$result = $db->prepare($requete);
	$result->execute();
	$resultat = $result->fetch();
	
	$result->closeCursor();
	echo $resultat[0];

}
?>