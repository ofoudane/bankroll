<?php
    require_once "../Verification/verifieSession.php";
    global $db;
    $message ;

    if(VALID){
       $nomBankroll = $_POST['nomBank'];
       if(strlen($nomBankroll) > 3) {
           $nomBankroll = pg_escape_string($nomBankroll);
           $message = "1";
           $soldeDeDepart = $_POST['soldeDepart'];
           if (is_numeric($soldeDeDepart)) {
               $message = $message . "1";
               if ($soldeDeDepart >= 0) {
                   $message = $message . "1";
                   $mail = pg_escape_string($_SESSION['e-mail']);
                   $sessionId = pg_escape_string($_SESSION['sessionId']);
                   $soldeDeDepart = pg_escape_string($soldeDeDepart);
                   
                   $requete = "select addBankroll('$nomBankroll',$soldeDeDepart,'$mail','$sessionId')";
                   $result = $db->prepare($requete);
                   $result->execute();
                   $resultat = $result->fetch();
                   
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
    $result->closeCursor();
    echo $message;
