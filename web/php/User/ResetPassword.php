<?php
    require_once __DIR__ . "/../../../bankroll-connect/db-connect.php";
    global $db;
    $mail = pg_escape_string($_POST['mail']);
    $key = pg_escape_string($_POST['key']);

    $answer = 0;
    $requete = "select resetPassword('$key','$mail')";
    $result = $db->prepare($requete);
    $result->execute();
    $resultat = $result->fetch();
    if(strlen($resultat[0]) > 2){
        if(mail($mail,'Mot De Passe bankroll','Votre nouveau mot de passe est : '.$resultat[0]))
            $answer = 1;
    }

    $result->closeCursor();
    echo $answer;
    ?>
