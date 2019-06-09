<?php
require_once __DIR__ . "/../Verification/verifieSession.php";
global $db;
if(VALID){
    $cotes = pg_escape_string($_POST['cotes']);
    $etats = pg_escape_string($_POST['etats']);
    $nomParis = pg_escape_string($_POST['nom']);
    $nomBankroll = pg_escape_string($_POST['bank']);
    $mise = pg_escape_string($_POST['mise']);
    $type = pg_escape_string($_POST['type']);
    if(type > 1 && sizeof($cotes) < 2){
        echo "0";
    }
    else{
        $requete = "select addMatchs('$nomParis','$nomBankroll','$mise',$cotes,$etats,$type,'".MAIL."','".SESSIONID."')";
    }


}