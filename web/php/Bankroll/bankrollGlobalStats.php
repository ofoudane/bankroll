<?php
require_once "../Verification/verifieSession.php";
global $db;
if(VALID){
    $nomBankroll = pg_escape_string($_POST['nom']);
    
    $requete = "select getGlobalStats('$nomBankroll','".MAIL."','".SESSIONID."')";
    $result = $db->prepare($requete);
    $result->execute();
    $resultat = $result->fetch();

    echo $resultat[0];
    
    $result->closeCursor();
}