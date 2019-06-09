<?php
require_once "../Verification/verifieSession.php";
global $db;
if(VALID){
    $id = pg_escape_string($_POST['id']);
    $requete = "select deleteBankroll($id,'".MAIL."','".SESSIONID."')";
    $result = $db->prepare($requete);
    $result->execute();
    $resultat = $result->fetch();
    $result->closeCursor();
    echo $resultat[0];
}