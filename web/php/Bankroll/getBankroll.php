<?php
require_once "../Verification/verifieSession.php";
global $db;
if(VALID){
    $answer = "";
    $requete = "select * from getBankrollNames('".MAIL."','".SESSIONID."')";
    $result = $db->prepare($requete);
    $result->execute();
    if($result->rowCount() == 0 )
        $answer = "<option value='' selected></option><option value='' >Aucune, Créer?</option>";
    else{
        while($row = $result->fetch(PDO::FETCH_BOTH)){
           $answer = $answer . "<option value='$row[0]' class='availableBankroll'>$row[0]</option>";
        }
    }
    $result->closeCursor();
    echo $answer;
}