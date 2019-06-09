<?php
    require_once __DIR__ . "/../../../bankroll-connect/db-connect.php";
	global $db;
	$reponse = 0;
	if(isset($_POST['addresse'])){
		$mail = pg_escape_string($_POST['addresse']);
		
		$requete = "select sendMail('$mail')";
		$result = $db->prepare($requete);
		$result->execute();
		$resultat = $result->fetch();
		
		$result->closeCursor();

		if(strlen($resultat[0]) > 3 && mail($mail,"Mot de passe oublié","votre clé de récupération est : ".$resultat[0])){
			$reponse = 1;
		} 
        echo $requete;
	}



?>