<?php
require_once "../Verification/verifieSession.php";
global $db;
if(VALID){
    $nomBank = pg_escape_string($_POST['nom']);
    $requete = "select * from getBankrollNumericInformation('$nomBank','".MAIL."','".SESSIONID."')";
    $result = $db->prepare($requete);
    $result->execute();
    $row = $result->fetch(PDO::FETCH_BOTH);
    $result->closeCursor();
    
    echo "$row[0],$row[1],$row[2]";

}

