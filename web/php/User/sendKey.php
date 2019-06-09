<?php
require_once __DIR__ . "/../Verification/verifieSession.php";
global $db;
if(VALID){
	$answer = 0 ;
	$requete = "select getKey('".MAIL."','".SESSIONID."')";
	$result = $db->prepare($requete);
	$result->execute();
	$resultat = $result->fetch();
	if(strlen($resultat[0]) > 5){
		if(mail(MAIL,"Cle récupération","Votre clé de récupération est : ".$resultat[0]))
			$answer = 1;
		
	}
	$result->closeCursor();
	echo $answer;

}
?>