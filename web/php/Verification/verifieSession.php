<?php
    session_start();
    require_once __DIR__ . "/../../../bankroll-connect/db-connect.php";
    global $db;
    if(isset($_SESSION['e-mail']) && isset($_SESSION['sessionId'])){
        
        $mail = pg_escape_string($_SESSION['e-mail']);
        $sessionCode = pg_escape_string($_SESSION['sessionId']);
        
        $requete = "select verifieSession('$mail','$sessionCode')";
        $answer = $db->prepare($requete);
        $answer->execute();
        $resultat = $answer->fetch();
        $answer->closeCursor();
        
        define("VALID",$resultat[0]);
        define("MAIL",$mail);
        define("SESSIONID",$sessionCode);
    }
    else
        define("VALID",false);

    if(!VALID){
        session_destroy();
        echo "false";
        exit(1);
    }