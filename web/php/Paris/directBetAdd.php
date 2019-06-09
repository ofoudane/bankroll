<?php
require_once "../Verification/verifieSession.php";
global $db;
if(VALID){
    $nom = pg_escape_string($_POST['nomParis']);
    $nomBankroll = pg_escape_string($_POST['nomBank']);
    $mise = pg_escape_string($_POST['miseParis']);
    $cote = pg_escape_string($_POST['coteParis']);
    $etat = pg_escape_string($_POST['etatBankroll']);
    
    $requete = "select addParis('$nom','$nomBankroll',$mise,$cote,cast($etat as smallint),'".MAIL."','".SESSIONID."')";
    $result = $db->prepare($requete);
    $result->execute();
    $resultat=$result->fetch();
    
    $result->closeCursor();
    echo $resultat[0];
}