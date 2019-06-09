<?php
require_once "../Verification/verifieSession.php";
global $db;
if(VALID){
    $nomBankroll = $_POST['nomBank'];
    if(strlen($nomBankroll) > 3) {
        $nomBankroll = pg_escape_string($nomBankroll);
        $message = "1";
        $montant = $_POST['montant'];

        //Verification du montant
        if (is_numeric($montant)) {
            $message = $message . "1";
           
            if ($montant >= 0) {
                $message = $message . "1";
                $montant = pg_escape_string($montant);
                $requete = "select cashoutBankroll('$nomBankroll',$montant,'".MAIL."','".SESSIONID."')";
                $result = $db->prepare($requete);
                $result->execute();
                $resultat = $result->fetch();
                $result->closeCursor();
                if($resultat[0]){
                    $message = $message . "1";
                }
                else{
                    if(!VALID){
                        session_unset();
                        session_destroy();
                    }
                    else
                        $message = $message . "0";
                }
            }
            else
                $message = $message . "02";
        }
        else{
            $message = $message . "022";
        }
    }
    else{
        $message = "0222" ;
    }
}
echo $message;


?>