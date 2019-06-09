<?php
session_start();
require_once __DIR__ . "/../../../bankroll-connect/db-connect.php";
global $db;

$refuse = array("refused","blocked","send","inexistant");
$mail = $_POST['adresse_mail'];
$password = $_POST['mot_de_passe'];
$mail = pg_escape_string($mail);
$password = pg_escape_string($password);

$requete = "select authenticateUser('$mail','$password')";
$answer = $db->prepare($requete);
$answer->execute();
$result = $answer->fetch();

if(!strcmp($result[0],$refuse[0])){
    $message = "Mail ou mot de passe érronné";
}

else if(!strcmp($result[0],$refuse[1])){
    $message = "Votre compte est bloqué !";
}

else if(!strcmp($result[0],$refuse[2])){
    $message = "Votre compte est bloqué et le propriétaire sera informé";
    $sujet = "Securité Bankroll: Compte Bloqué";
    $text = "Bonjour Monsieur/Madame"."\n"
        ."Ce message vous a été envoyé pour vous informer que quelqu'un essayait d'accéder à votre compte, par conséquence, votre compte est bloqué pour 2 heures";
    if(mail($mail,$sujet,$text)){
        $requete = "select setMailSent('$mail')";
        $answer2 = $db->prepare($requete);
        $answer2->execute();
        $answer2->closeCursor();

    }
}
else if(!strcmp($result[0],$refuse[3])){
    $message = "Compte inexistante <a href='#register' class='text-warning'>le Créer ?</a> ";
}
else{

    $_SESSION['sessionId'] = $result[0];
    $_SESSION['e-mail'] = $mail;
    $message = "0";

}

$answer->closeCursor(); 

echo $message;

?>